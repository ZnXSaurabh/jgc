<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'                => 1,
                'title'             => 'user_management_access',
                'created_at'        => date("Y-m-d h:i:s"),
                'updated_at'        => date("Y-m-d h:i:s"),
            ],
            [
                'id'                => 2,
                'title'             => 'candidate_access',
                'created_at'        => date("Y-m-d h:i:s"),
                'updated_at'        => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 3,
                'title'      => 'permission_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 4,
                'title'      => 'role_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 5,
                'title'      => 'hr_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 6,
                'title'      => 'vendor_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 7,
                'title'      => 'hr_manager_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],



            [
                'id'         => 8,
                'title'      => 'job_create',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 9,
                'title'      => 'job_edit',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 10,
                'title'      => 'job_show',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 11,
                'title'      => 'job_delete',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 12,
                'title'      => 'job_approved',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 13,
                'title'      => 'job_unapproved',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 14,
                'title'      => 'job_shortlist_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 15,
                'title'      => 'job_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],


            [
                'id'         => 16,
                'title'      => 'configuration_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 17,
                'title'      => 'department_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 18,
                'title'      => 'designation_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 19,
                'title'      => 'job_type_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ],
            [
                'id'         => 20,
                'title'      => 'location_access',
                'created_at'     => date("Y-m-d h:i:s"),
                'updated_at'     => date("Y-m-d h:i:s"),
            ]
        ];

        Permission::insert($permissions);
    }
}
