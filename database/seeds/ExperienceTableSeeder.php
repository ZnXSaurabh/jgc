<?php

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $experience = [
            [
                'id'             =>  1,
                'profile_id'     =>  2,
                'designation'    =>  'Web Developer',
                'department'     =>  'Engeeniring',
                'organisation'   =>  '',
                'start_year'     =>  '2020-07-15',
                'end_year'       =>  '2020-07-15',
                'remarks'        =>  '',
                'status'         =>  1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
        ];

        Experience::insert($experience);
    }
}
