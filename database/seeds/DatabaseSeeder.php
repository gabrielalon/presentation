<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(WarehousesSeeder::class);
        $this->call(WarehouseItemsSeeder::class);
        $this->call(WarehouseStatesSeeder::class);
    }
}
