<?php

use App\Models\Storage\Employee\Department;
use App\Models\Storage\Employee\Location;
use App\Models\Storage\Employee\Position;
use App\Models\Storage\Employee\References\EmployeeType;
use App\Models\Storage\Ticket\References\TicketPriority;
use App\Models\Storage\Ticket\References\TicketStatus;
use App\Models\Storage\Ticket\References\TicketType;
use Illuminate\Database\Seeder;

class ReferencesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seeds for employees
        $locations = [
            [
                'name' => 'Главный корпус',
                'code' => 'main_campus',
            ],
            [
                'name' => '1 корпус',
                'code' => Location::MAIN_CAMPUS,
            ],
            [
                'name' => '2 корпус',
                'code' => Location::FIRST_CAMPUS,
            ],
            [
                'name' => '3 корпус',
                'code' => Location::SECOND_CAMPUS,
            ],
            [
                'name' => '4 корпус',
                'code' => Location::THIRD_CAMPUS,
            ],
            [
                'name' => '5 корпус',
                'code' => Location::FOURTH_CAMPUS,
            ],
            [
                'name' => '6 корпус',
                'code' => Location::FIFTH_CAMPUS,
            ],
            [
                'name' => '7 корпус',
                'code' => Location::SIXTH_CAMPUS,
            ],
            [
                'name' => '8 корпус',
                'code' => Location::SEVENTH_CAMPUS,
            ],
            [
                'name' => '9 корпус',
                'code' => Location::EIGHTH_CAMPUS,
            ],
        ];
        fill_seeds($locations, Location::class);

        $departments = [
            [
                'name' => 'Сервисный отдел',
                'location_id' => Location::whereCode(Location::MAIN_CAMPUS)->first()->id,
            ],
            [
                'name' => 'Отдел ВСиС',
                'location_id' => Location::whereCode(Location::MAIN_CAMPUS)->first()->id,
            ],
            [
                'name' => 'Отдел ИБ',
                'location_id' => Location::whereCode(Location::MAIN_CAMPUS)->first()->id,
            ],
            [
                'name' => 'Отдел АСУ',
                'location_id' => Location::whereCode(Location::MAIN_CAMPUS)->first()->id,
            ],
            [
                'name' => 'Бухгалтерия',
                'location_id' => Location::whereCode(Location::MAIN_CAMPUS)->first()->id,
            ],

        ];
        fill_seeds($departments, Department::class, 'name');

        $positions = [
            ['name' => 'Начальник отдела'],
            ['name' => 'Специалист'],
            ['name' => 'Ведущий специалист'],

        ];
        fill_seeds($positions, Position::class, 'name');

        $employeeTypes = [
            [
                'name' => 'Исполнитель',
                'code' => EmployeeType::CONTRACTOR,
            ],
            [
                'name' => 'Клиент',
                'code' => EmployeeType::CUSTOMER,
            ]
        ];
        fill_seeds($employeeTypes, EmployeeType::class);


        //Seeds for tickets
        $ticketTypes = [
            ['name' => 'Проблема с сетью'],
            ['name' => 'Поломка компьютера'],
            ['name' => 'Установка софта'],
            ['name' => 'Проблема с принтером'],
        ];
        fill_seeds($ticketTypes, TicketType::class, 'name');

        $ticketPriorities = [
            [
                'name' => 'Низкий',
                'code' => TicketPriority::LOW,
            ],
            [
                'name' => 'Обычный',
                'code' => TicketPriority::NORMAL,
            ],
            [
                'name' => 'Высокий',
                'code' => TicketPriority::HIGH,
            ],
        ];
        fill_seeds($ticketPriorities, TicketPriority::class);

        $ticketStatuses = [
            ['name' => 'Новая'],
            ['name' => 'Необходимо уточнение'],
            ['name' => 'Завершенная'],
        ];
        fill_seeds($ticketStatuses, TicketStatus::class, 'name');
    }
}
