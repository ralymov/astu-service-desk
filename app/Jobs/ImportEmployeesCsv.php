<?php

namespace App\Jobs;

use App\Helpers\StringHelper;
use App\Models\Storage\Contractor\Contractor;
use App\Models\Storage\Contractor\ContractorType;
use App\Models\Storage\Contractor\NaturalPerson;
use App\Models\Storage\Employee\Department;
use App\Models\Storage\Employee\Employee;
use App\Models\Storage\Employee\Position;
use App\Models\Storage\Employee\References\EmployeeType;
use App\Models\Storage\Showroom\Reference\VehiclePassportType;
use App\Models\Storage\Showroom\VehiclePassport;
use App\Models\Storage\Showroom\WarehouseItem;
use App\Models\Storage\Showroom\WarehousePrice;
use App\Models\Storage\User\Passport;
use App\Models\Storage\User\Person;
use App\Models\Storage\Vehicle\Brand;
use App\Models\Storage\Vehicle\Engine;
use App\Models\Storage\Vehicle\Series;
use App\Models\Storage\Vehicle\Transmission;
use App\Models\Storage\Vehicle\WheelDrive;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
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
        $position = $this->importPosition($record[5]);
        $department = $this->importDepartment($record[6]);
        $employeeData = [
            'name' => "$record[2] $record[3] $record[4]",
            'position_id' => $position->id,
            'department_id' => $department->id,
            'type_id' => EmployeeType::customer()->first()->id,
        ];
        Employee::updateOrCreate($employeeData, $employeeData);
    }

    private function importDepartment(string $department): Department
    {
        return Department::updateOrCreate(['name' => $department], ['name' => $department]);
    }

    private function importPosition(string $position): Position
    {
        return Position::updateOrCreate(['name' => $position], ['name' => $position]);
    }

}
