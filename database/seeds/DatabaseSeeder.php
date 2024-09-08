<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'                  => 'Alex Hurtado',
            'email'                 => 'alex@email.com',
            'password'              => bcrypt('Alex2022'),
        ]);

        User::create([
            'name'                  => 'Carlos Roger',
            'email'                 => 'carlos@email.com',
            'password'              => bcrypt('Carlos2024'),
        ]);
    }
}
