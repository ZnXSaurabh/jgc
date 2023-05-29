<?php

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education = [
            [
                'id'                  =>  1,
                'profile_id'          =>  2,
                'level'               =>  'Graduate',
                'course'              =>  'Bca',
                'university'          =>  'HNB',
                'start_year'          =>  '2020-07-15',
                'end_year'            =>  '2020-07-15',
                'percentage'          =>  '70',
                'remarks'             =>  'demo Remark',
                'status'              =>  1,
                'created_at'          => date("Y-m-d h:i:s"),
                'updated_at'          => date("Y-m-d h:i:s"),
            ],
            [
                'id'                  =>  2,
                'profile_id'          =>  2,
                'level'               =>  'Post Graduate',
                'course'              =>  'Mca',
                'university'          =>  'HNB',
                'start_year'          =>  '2020-07-15',
                'end_year'            =>  '2020-07-15',
                'percentage'          =>  '75',
                'remarks'             =>  'demo Remark',
                'status'              =>  1,
                'created_at'          => date("Y-m-d h:i:s"),
                'updated_at'          => date("Y-m-d h:i:s"),
            ],
            
        ];

        Education::insert($education);
    }
}
