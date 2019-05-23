<?php

use App\Author;
use App\Book;
use App\Statistic;
use Illuminate\Database\Seeder;

class StatisticTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Statistic::create([
            'nbAuthor' => count(Author::all()),
            'nbBook' => count(Book::all()),
        ]);
    }
}
