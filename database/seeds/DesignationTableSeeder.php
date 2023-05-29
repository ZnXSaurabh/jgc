<?php

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designation = [
            [
                'id'            => 1,
                'name'          => 'Schedule Control Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'    => date("Y-m-d h:i:s"),
                'updated_at'    => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 2,
                'name'          => 'Senior Schedule Control Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'    => date("Y-m-d h:i:s"),
                'updated_at'    => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 3,
                'name'          => 'Process Lead Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'    => date("Y-m-d h:i:s"),
                'updated_at'    => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 4,
                'name'          => 'Process Principal Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 5,
                'name'          => 'Project Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 6,
                'name'          => 'Senior Fire Protection Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 7,
                'name'          => 'Senior Design HSE Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 8,
                'name'          => 'IT Engineer',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 9,
                'name'          => 'Project Manager',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 10,
                'name'          => 'QC Supervisor',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 11,
                'name'          => 'Engineering Manager',
                'description'   => '',
                'status'        => 1,
                'created_at'    => date("Y-m-d h:i:s"),
                'updated_at'    => date("Y-m-d h:i:s"),
            ],
        ];

        Designation::insert($designation);
    }
}
