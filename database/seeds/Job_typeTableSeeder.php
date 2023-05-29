<?php

use App\Models\JobType;
use Illuminate\Database\Seeder;

class Job_typeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Job_type = [
            [
                'id'             =>  1,
                'job_type'       =>  'Permanent',
                'status'         =>  '1',
                'description'    =>  '',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'             =>  2,
                'job_type'       =>  'Contactual',
                'status'         =>  '1',
                'description'    =>  '',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],           
        ];

        JobType::insert($Job_type);
    }
}
