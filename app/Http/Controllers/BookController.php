<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use App\Genre;
use App\Picture;
use App\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('authors', 'genre')->paginate(8);

        return view('back.book.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // permet de récupérer une collection type array avec la clé id => name
        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.create', ['authors' => $authors, 'genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dump($request->all());

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer | distinct', // pour vérifier un tableau d'entiers il faut mettre authors.*
            'status' => 'in:published,unpublished',
            'picture' => 'image|max:3600',
        ]);
        // dump($request->all());
        $book = Book::create($request->all());
        $book->authors()->attach($request->authors);

        Statistic::first()->increment('nbBook', 1);

        $img = $request->file('picture');

        if (!empty($img)) {
            $link = $request->file('picture')->store('images');

            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image ?? $request->title
            ]);
        }

        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);

        return view('back.book.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        $authors = Author::pluck('name', 'id')->all();
        $genres = Genre::pluck('name', 'id')->all();

        return view('back.book.edit', ['book' => $book, 'authors' => $authors, 'genres' => $genres]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer',
            'status' => 'in:published,unpublished',
        ]);

        $book = Book::find($id);

        $book->update($request->all()); // mettre à jour les données d'un livre

        $book->authors()->sync($request->authors); // synchroniser les données de la table de liaison

        // image
        $img = $request->file('picture');

        // si on associe une image à un book
        if (!empty($img)) {

            $link = $request->file('picture')->store('images');

            if (!is_null($book->picture)) {
                Storage::disk('local')->delete($book->picture->link);
                $book->picture()->delete();
            }

            $book->picture()->create([
                'link' => $link,
                'title' => $request->title_image ?? $request->title
            ]);
        }

        if (Cache::has('bookhome')) {
            Cache::pull('bookhome');
        }

        return redirect()->route('book.index')->with('message', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $pictures = Picture::all()->where('book_id', $book->id);
        foreach ($pictures as $picture) {
            $picture->delete();
        }
        $book->delete();
        Statistic::first()->decrement('nbBook', 1);
        return redirect()->route('book.index')->with('message', 'success');
    }
}
