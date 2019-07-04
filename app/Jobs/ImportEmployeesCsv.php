<?php

namespace App\Jobs;

use App\Models\Storage\Employee\Department;
use App\Models\Storage\Employee\Employee;
use App\Models\Storage\Employee\Position;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class ImportEmployeesCsv implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * File path
     *
     * @var string
     */
    protected $file;

    /**
     * Create a new job instance.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->file || !file_exists($this->file)) {
            Log::info('File not found');
            return;
        }

        if (($handle = fopen($this->file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                try {
                    $this->importEmployee($data);
                } catch (\RuntimeException $e) {
                    Log::error($e->getMessage());
                }
            }
            fclose($handle);
        }

    }

    private function importEmployee(array $record)
    {

        if (!ctype_digit($record[1])) {
            return;
        }
        $position = $this->importPosition(mb_ucfirst(mb_strtolower($record[5])));
        $department = $this->importDepartment(mb_ucfirst(mb_strtolower($record[6])));
        $employeeData = [
            'name' => mb_ucfirst(mb_strtolower($record[2])) . ' '
                . mb_ucfirst(mb_strtolower($record[3])) . ' '
                . mb_ucfirst(mb_strtolower($record[4])),
            'position_id' => $position->id,
            'department_id' => $department->id,
        ];
        Employee::updateOrCreate($employeeData, $employeeData);
    }

    private function importDepartment(string $department): Department
    {
        return Department::updateOrCreate(
            ['name' => mb_ucfirst(mb_strtolower($department))],
            ['name' => mb_ucfirst(mb_strtolower($department))]
        );
    }

    private function importPosition(string $position): Position
    {
        return Position::updateOrCreate(
            ['name' => mb_ucfirst(mb_strtolower($position))],
            ['name' => mb_ucfirst(mb_strtolower($position))]
        );
    }

}
