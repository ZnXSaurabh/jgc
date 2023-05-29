<?php

use App\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $superadmin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($superadmin_permissions->pluck('id'));

        $admin_permissions = $superadmin_permissions->filter(function ($permission) {
            return $permission->title != 'user_management_access'
                && $permission->title != 'candidate_access'
                && $permission->title != 'hr_access'
                && $permission->title != 'vendor_access'
                && $permission->title != 'hr_manager_access'
                && $permission->title != 'job_shortlist_access'
                && $permission->title != 'configuration_access'
                && $permission->title != 'department_access'
                && $permission->title != 'designation_access'
                && $permission->title != 'job_type_access'
                && $permission->title != 'location_access'
                && $permission->title != 'job_create'
                && $permission->title != 'job_edit'
                && $permission->title != 'job_delete'
                && $permission->title != 'job_approved'
                && $permission->title != 'job_unapproved'
                && $permission->title != 'job_access';
        });
        Role::findOrFail(2)->permissions()->sync($admin_permissions);

        $candidate_permissions = $superadmin_permissions->filter(function ($permission) {
            return $permission->title != 'user_management_access';
        });
        Role::findOrFail(3)->permissions()->sync($candidate_permissions);

        $hrManager_permissions = $superadmin_permissions->filter(function ($permission) {
            return $permission->title != 'hr_access'
                && $permission->title != 'vendor_access'
                && $permission->title != 'job_create'
                && $permission->title != 'job_edit'
                && $permission->title != 'job_delete'
                && $permission->title != 'job_approved'
                && $permission->title != 'job_unapproved'
                && $permission->title != 'job_access';
                // && substr($permission->title, 0, 4) != 'job_';
        });
        Role::findOrFail(4)->permissions()->sync($hrManager_permissions);

        $hr_permissions = $superadmin_permissions->filter(function ($permission) {
            return  $permission->title != 'job_create'
            && $permission->title != 'job_edit'
            && $permission->title != 'job_delete'
            && $permission->title != 'job_shortlist_access'
            && $permission->title != 'job_access';
                // && substr($permission->title, 0, 4) != 'job_';
        });
        Role::findOrFail(5)->permissions()->sync($hr_permissions);

        $vendor_permissions = $superadmin_permissions->filter(function ($permission) {
            return $permission->title != 'candidate_access';
                // && substr($permission->title, 0, 4) != 'job_';
        });
        Role::findOrFail(6)->permissions()->sync($vendor_permissions);
    }
}