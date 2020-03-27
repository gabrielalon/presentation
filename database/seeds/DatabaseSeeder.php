<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UsersSeeder::class);
        $this->call(WarehousesSeeder::class);
        $this->call(WarehouseItemsSeeder::class);
        $this->call(WarehouseStatesSeeder::class);
    }
}
