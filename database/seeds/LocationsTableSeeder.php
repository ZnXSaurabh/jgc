<?php

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Locations = [
            [
                'id'             =>  1,
                'name'           =>  'Al-Khobar',
                'created_at'     =>  date("Y-m-d h:i:s"),
                'updated_at'     =>  date("Y-m-d h:i:s"),
            ],
            [
                'id'             =>  2,
                'name'           =>  'Baharin',
                'created_at'     =>  date("Y-m-d h:i:s"),
                'updated_at'     =>  date("Y-m-d h:i:s"),
            ],
              
        ];

        Location::insert($Locations);
    }
}
