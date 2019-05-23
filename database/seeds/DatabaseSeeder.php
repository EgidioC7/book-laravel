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
        $this->call(UserTableSeeder::class);

        $this->call(AuthorTableSeeder::class);
        $this->call(BookTableSeeder::class);
        $this->call(StatisticTableSeeder::class);



        // appel des autres seeders ici...
    }
}
