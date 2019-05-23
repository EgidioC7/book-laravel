<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Genre;
use App\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class FrontController extends Controller
{
    public $paginate = 5;

    public function __construct()
    {
        // méthode pour injecter des données à une vue partielle
        view()->composer('partials.menu', function ($view) {
            $genres = Genre::pluck('name', 'id')->all(); // on récupère un tableau associatif
            $view->with('genres', $genres); // on passe la données à la vue
        });
    }

    /*********
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * select *
    from  ( select book_id, avg(note) as note_avg from author_book group by book_id ) as t2
    where note_avg = ( select max(note_avg) from ( select book_id, avg(note) as note_avg from author_book group by book_id ) as t1  );
     */

    public function index()
    {
        $prefix = request()->page ?? 'home';
        $path = 'book' . $prefix;
        $books = Cache::remember($path, 60 * 24, function () {
            return Book::published()->with('picture', 'authors')->paginate($this->paginate);  //  tous les livres de l'application
        });
        $exist = $books->toArray()['data'];

        if( empty($exist)){
            return view('front.index', ['books' => $books]);
        }
        return view('front.index', ['books' => $this->findBestBook($books)]);
    }

    public static function getNbBook(){
        return Statistic::bookCount();
    }
    public static function getNbAuthor(){
        return Statistic::authorCount();
    }
    public static function getBestNote(){
        return Statistic::bestNote();
    }

    private function findBestBook($books)
    {
        $bestBook = null;
        $bestNote = null;
        foreach ($books as $book) {
            $note = null;
            foreach ($book->authors as $author) {
                $note += $author->pivot->note;
            }
            $note = $note / count($book->authors);
            if ($bestBook == null || $bestNote < $note) {
                $bestBook = $book;
                $bestNote = $note;
            }
        }

        foreach ($books as $key => $value) {
            if ($books[$key]->id == $bestBook->id) {
                $books->forget($key);
            };
        }
        $books->prepend($bestBook, 0);

        return $books;
    }

    public function show(int $id)
    {
        $book = Book::find($id);

        return view('front.show', ['book' => $book]);
    }

    public function showBookByAuthor(int $id)
    {
        $books = Author::find($id)->books()->paginate(5); // on récupère tous les livres d'un auteur

        $author = Author::find($id);

        // que vous passez à une vue
        return view('front.author', ['books' => $books, 'author' => $author]);

    }

    public function genre($id)
    {
        $books = Genre::find($id)->books()->with('authors', 'picture')->paginate(5);

        $genre = Genre::find($id);

        return view('front.genre', ['books' => $this->findBestBook($books), 'genre' => $genre]);
    }

}
