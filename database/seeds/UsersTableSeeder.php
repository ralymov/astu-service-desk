<?php

use App\Models\Storage\User\Role;
use App\Models\Storage\User\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $records = [
            [
                User::FLD_ROLE_ID => Role::where('code', Role::ADMIN)->first()->id,
                User::FLD_USERNAME => 'admin',
                User::FLD_PASSWORD => Hash::make('admin'),
            ],
            [
                User::FLD_ROLE_ID => Role::where('code', Role::CONTRACTOR)->first()->id,
                User::FLD_USERNAME => 'contractor',
                User::FLD_PASSWORD => Hash::make('contractor'),
            ],
        ];
        fill_seeds($records, User::class, User::FLD_USERNAME);
    }


}
