<?php

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = [
            [
                'id'                     => 1,
                'user_id'                => 1,
                'address'                => 'GIKSINDIA, Dehradun',
                'gender'                 => 'Male',
                'city'                   => 'Dehraudn',
                'state'                  => 'Uttarakhand',
                'country'                => 'India',
                'zip_code'               => '248001',
                'resume'                 => '',
                'dob'                    => '',
                'profile_pic'            => '',
                'about'                  => '',
                'created_at'             => date("Y-m-d h:i:s"),
                'updated_at'             => date("Y-m-d h:i:s"),
                'deleted_at'             => null,
            ],
            [
                'id'                     => 2,
                'user_id'                => 2,
                'address'                => 'GIKSINDIA, Dehradun',
                'gender'                 => 'Male',
                'city'                   => 'Dehraudn',
                'state'                  => 'Uttarakhand',
                'country'                => 'India',
                'zip_code'               => '248001',
                'resume'                 => '',
                'dob'                    => '',
                'profile_pic'            => '',
                'about'                  => '',
                'created_at'             => date("Y-m-d h:i:s"),
                'updated_at'             => date("Y-m-d h:i:s"),
                'deleted_at'             => null,
            ], 
        ];

        Profile::insert($profile);
    }
}
