@extends('layouts.master')

@section('content')
    <button type="button" class="btn btn-primary">
        <a style="color:white" href="{{route('book.create')}}">Ajouter un livre</a>
    </button>
    {{$books->links()}}
    @include('back.book.partials.flash')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Authors</th>
            <th scope="col">Genre</th>
            <th scope="col">Date de publication</th>
            <th scope="col">Status</th>
            <th scope="col">Edit</th>
            <th scope="col">Show</th>
            <th scope="col">Delete</th>
        </tr>
        </thead>
        <tbody>
        @forelse($books as $book)
            <tr>
                <td>{{$book->title}}</td>
                <td>
                    @forelse($book->authors as $author)
                        {{$author->name}},
                    @empty
                        Aucun auteur
                    @endforelse
                </td>
                <td>{{$book->genre->name?? 'aucun genre' }}</td>
                <td>{{$book->created_at}}</td>
                <td><button class="btn btn-{{($book->status == 'published') ? 'success' : 'warning'}}">{{$book->status}}</button></td>
                <td><a href="{{route('book.edit', $book->id)}}">Éditer</a></td>
                <td><a href="{{route('book.show', $book->id)}}">Voir</a></td>
                <td>
                    <form class="delete" action="{{ route('book.destroy', $book->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{method_field('DELETE')}}
                        <button type="submit" class="delete btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <li>Désole pour l'instant aucun livre n'est publié sur le site</li>
        @endforelse
        </tbody>
    </table>
@endsection
@section('scripts')
    @parent
    <script src="{{asset('js/confirm.js')}}"></script>
@endsection