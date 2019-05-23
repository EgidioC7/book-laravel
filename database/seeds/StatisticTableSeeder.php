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
        $books = Book::all();
        $bestNote = null;
        foreach ($books as $book) {
            $note = null;
            foreach ($book->authors as $author) {
                $note += $author->pivot->note;
            }
            $note = $note / count($book->authors);
            if ($bestNote < $note) {
                $bestNote = $note;
            }
        }

        Statistic::create(
            [
                'nbAuthor' => count(Author::all()),
                'nbBook' => count($books),
                'bestNote' => $bestNote,
            ]
        );
    }
}
