<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            CountriesTableSeeder::class,
            RoleUserTableSeeder::class,
            // EducationTableSeeder::class,
            DepartmentTableSeeder::class,
            // DesignationTableSeeder::class,
            // ExperienceTableSeeder::class,
            Job_typeTableSeeder::class,
            ProfileTableSeeder::class,
            LocationsTableSeeder::class,
            // JobsTableSeeder::class,
        ]);
    }
}
