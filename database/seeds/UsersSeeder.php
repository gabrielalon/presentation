<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(['email' => 'rodemarek@gmail.com'], [
            'name' => 'test',
            'password' => '$2y$10$vjpq1HYw8fuRPlfSBFJ/UuflwiKSGYCI/L0z/.zUBBNnOWQ0UMa5.'
        ]);
    }
}
