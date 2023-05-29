<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = [
            [
                'id'            => 1,
                'name'          => 'Engineering',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 2,
                'name'          => 'Procurement',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'            => 3,
                'name'          => 'Construction Management',
                'description'   => '',
                'status'        => 1,
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
           
        ];

        Department::insert($department);
    }
}
