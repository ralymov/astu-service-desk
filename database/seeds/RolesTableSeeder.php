<?php

use App\Models\Storage\User\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            [
                Role::FLD_CODE => Role::ADMIN,
                Role::FLD_NAME => 'admin',
                Role::FLD_DISPLAY_NAME => 'Администратор',
            ],
            [
                Role::FLD_CODE => Role::CONTRACTOR,
                Role::FLD_NAME => 'contractor',
                Role::FLD_DISPLAY_NAME => 'Сотрудник',
            ],
            [
                Role::FLD_CODE => Role::DEPARTMENT_HEAD,
                Role::FLD_NAME => 'department_head',
                Role::FLD_DISPLAY_NAME => 'Начальник отдела',
            ],
            [
                Role::FLD_CODE => Role::GUEST,
                Role::FLD_NAME => 'guest',
                Role::FLD_DISPLAY_NAME => 'Гость',
            ],
        ];
        fill_seeds($records, Role::class);
    }
}
