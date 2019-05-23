@extends('layouts.master')

@section('content')

    <article class="row">
        <div class="col-sm-12">
            <h2>{{$book->title}}</h2>
            <div class="row list-group-item">
                <div class="col-md-6 col-sm-12">
                    @if($book->picture)
                        <a  href="{{ asset('/images/'.$book->picture->link)}}"><img alt="{{$book->picture->title}}" src="{{ asset('/images/'.$book->picture->link)}}"/></a>
                    @endif
                </div>
            </div>

            <h3>Description :</h3>
            <p>{{$book->description}}</p>
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


    </article>
@endsection