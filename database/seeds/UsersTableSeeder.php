<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Super Admin',
                'email'          => 'info@giksindia.com',
                'phone'          => '7500872014',
                'remember_token' => null,
                'status'         => 1,
                'created_by'     => null,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
                'deleted_at'     => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Admin',
                'email'          => 'admin@giksindia.com',
                'phone'          => '8958045685',
                'remember_token' => null,
                'status'         => 1,
                'created_by'     => null,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
                'deleted_at'     => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Gaurav Baliyan',
                'email'          => 'gaurav@giksindia.com',
                'phone'          => '7351276152',
                'remember_token' => null,
                'status'         => 1,
                'created_by'     => null,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
                'deleted_at'     => null,
            ],
        ];

    User::insert($users);
    }
}
