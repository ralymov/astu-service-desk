<?php

use App\Models\Storage\Employee\Department;
use App\Models\Storage\Employee\Position;
use Illuminate\Database\Seeder;

class ReferencesRelationsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Attach positions to departments
        $serviceDepartments = Department::whereName('Сервисный отдел')
            ->orWhere('name', 'Отдел ВСиС')
            ->orWhere('name', 'Отдел ИБ')
            ->orWhere('name', 'Отдел АСУ')
            ->get();
        $positions = Position::whereName('Начальник отдела')
            ->orWhere('name', 'Специалист')
            ->orWhere('name', 'Ведущий специалист')
            ->get();
        foreach ($serviceDepartments as $department) {
            $department->positions()->sync($positions);
        }
    }
}
