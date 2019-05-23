@extends('layouts.master')

@section('content')
    <button class="btn btn-primary"><a style="color:white" href="{{route('book.edit', $book->id)}}">Éditer</a></button>
    <article class="row">
        <div class="col-md-6 col-sm-6">
            <h2>Titre : {{$book->title}}</h2>
            <p>Genre : {{$book->genre->name?? 'aucun genre' }}</p>
            <p>Date de création : {{$book->created_at }}</p>
            <p>Date de mise à jour : {{$book->updated_at }}</p>
            <p>Status : {{$book->status}}</p>
            <h4>Auteur(s) :</h4>
            <ul>
                @forelse($book->authors as $author)
                    <li><a href="{{url('author', $author->id)}}">{{$author->name}},
                            <strong>{{$author->pivot->note ?? 'aucune note'}}</strong></a></li>
                @empty
                    <li>Aucun auteur</li>
                @endforelse
            </ul>
        </div>
        <div class="col-md-6 col-sm-6">
            @if($book->picture)
                <a href="{{ asset('/images/'.$book->picture->link)}}">
                    <img alt="{{$book->picture->title}}" src="{{ asset('/images/'.$book->picture->link)}}"/>
                </a>
            @endif
        </div>
    </article>
@endsection