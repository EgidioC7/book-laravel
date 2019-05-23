<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('books', function () {
    return App\Book::all();
});

Route::get('/', 'FrontController@index');

Route::get('book/{id}', 'FrontController@show')->where(['id' => '[0-9]+']);

Route::get('author/{id}', 'FrontController@showBookByAuthor')->where(['id' => '[0-9]+']);

Route::get('genre/{id}', 'FrontController@genre')->where(['id' => '[0-9]+']);

Route::resource('admin/book', 'BookController')->middleware('auth');

/*Route::get('/', function () {

    return view('welcome');
});*/

/*Route::get('/contact/{name}', 'HomeController@contact');

Route::get('/lesson/{name}', function ($name) {

    return "Hello $name";
});

Route::get('/mention', function () {

    return view('mention');
});
*/

/*Route::get('book/{id}', function ($id) {

    return App\Book::find($id);
});
*/
/*
Route::get('search/{word1}/{word2}', function (string $word1, string $word2) {

    $search = $word1 . " " . $word2;

    $result = App\Book::where('title', 'like', "%$search%")->get();

    if (count($result) == 0) {
        return "sorry not found";
    }

    return $result;

});

Route::get('category/{word?}', function (string $word = null) {

    return "coucou category $word";

});

Route::get('user/{name}/{id}', function (string $name, int $id) {

    return "Nom : $name et identifiant : $id";

})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);;
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
