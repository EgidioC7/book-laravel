@extends('layouts.master')

@section('content')
    <h1>Tous les livres du genre : <strong> {{$genre->name}}</strong>     </h1>
    {{$books->links()}}
    <ul class="list-group">
        @forelse($books as $book)
            <li class="list-group-item">
                <h2><a href="{{url('book', $book->id)}}">{{$book->title}}</a></h2>
                <div class="container">
                    <div clas="row">
                        <div class="col-sm-6">
                            @if($book->picture)
                                <a href="{{ asset('/images/'.$book->picture->link)}}">
                                    <img alt="{{$book->picture->title}}" src="{{ asset('/images/'.$book->picture->link)}}"/>
                                </a>
                            @endif
                        </div>
                        <div class="col-sm-5">
                            <p>{{$book->description}}</p>
                        </div>
                    </div>
                </div>
                <h3>Auteur(s) :</h3>
                <ul>
                    @forelse($book->authors as $author)
                        <li>{{$author->name}}, <strong>{{$author->pivot->note ?? 'aucune note'}}</strong></li>
                    @empty
                        <li>Aucun auteur</li>
                    @endforelse
                </ul>
            </li>
        @empty
            <li>Désole pour l'instant aucun livre n'est publié sur le site</li>
        @endforelse
    </ul>
@endsection
