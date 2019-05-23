<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Genre::create([
            'name' => 'science'
        ]);

        App\Genre::create([
            'name' => 'maths'
        ]);

        App\Genre::create([
            'name' => 'cookbook'
        ]);

        Storage::disk('local')->delete(Storage::allFiles());

        // Création de 30 livres à partir de la factory
        factory(App\Book::class, 30)->create()->each(function ($book) {
            //association un genre à un livre que nous venons de créer
            $genre = App\Genre::find(rand(1, 3));

            $link = Str::random(12) . '.jpg';
            $file = file_get_contents('http://loremflickr.com/250/250/' . rand(1, 9)); // flux
            Storage::disk('local')->put($link, $file);

            $book->picture()->create([
                'title' => 'Default', // Valeur par défaut
                'link' => $link
            ]);

            // pour chaque $book on lui associe un genre en particulier
            $book->genre()->associate($genre);
            $book->save(); // il faut sauvegarder l'association pour faire persister en base de données


            $authors = App\Author::pluck('id')->shuffle()->slice(0, rand(1, 3))->all();

            // $book->authors()->attach($authors);

            // $book->authors()->attach([1], ['note' =>15.5]);

            /* $book->authors()->attach([
                 1 => ['note' => 15.5],
                 2 => ['note' => 12.7]
             ]); */

            $relationPivotAuthor = [];

            foreach ($authors as $id) {

                $relationPivotAuthor[$id] = ['note' => rand(5, 19) + rand(0, 9) / 10];
            }

            $book->authors()->attach($relationPivotAuthor);

        });
    }
}
