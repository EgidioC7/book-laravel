@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h2>Edit book :</h2>
                <form method="POST" action="{{route('book.update', $book->id)}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" value="{{$book->title}}" name="title"
                               placeholder="Titre du livre">
                    </div>
                    @if($errors->has('title')) <span class="error bg-warning text-warning">{{$errors->first('title')}}</span>@endif
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"
                                  rows="3">{{$book->description}}</textarea>
                    </div>
                    @if($errors->has('description')) <span class="error bg-warning text-warning">{{$errors->first('description')}}</span> @endif
                    <br>
                    <select class="form-control form-control-lg" name="genre_id">
                        <option id="0" value="" {{ is_null($book->genre_id) ? 'selected' : '' }}>No genre</option>
                        @forelse($genres as $id => $name)
                            <option id="{{$id}}"
                                    value="{{$id}}" {{ ($book->genre_id == $id ) ? 'selected' : '' }}>{{$name}}</option>
                        @empty
                            <option>Aucun genre</option>
                        @endforelse
                    </select>

                    @forelse($authors as $id => $name)
                        <label class="control-label" for="author{{$id}}">{{$name}}</label>
                        <input name="authors[]" value="{{$id}}" type="checkbox" class="form-control"
                               id="author{{$id}}" {{ ( $book->isAuthor($id) )? 'checked' : ''  }}>
                    @empty
                        <option>Aucun auteur</option>
                    @endforelse
                    <h2>Status</h2>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="published" value="published"
                               {{($book->status == 'published' ? 'checked' : '') }} checked>
                        <label class="form-check-label" for="published">
                            Publier
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="unpublished"
                               value="unpublished" {{($book->status == 'unpublished' ? 'checked' : '') }}>
                        <label class="form-check-label" for="unpublished">
                            Dépublier
                        </label>
                    </div>
                    <h2>File : </h2>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="picture">
                    @if($errors->has('picture')) <span class="error bg-warning text-warning">{{$errors->first('picture')}}</span> @endif
                    </div>
                    <div class="form-group">
                        <h2>Image associée :</h2>
                        <img src="{{asset("images/".$book->picture->link)}}" title="{{$book->picture->title}}"/>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-6 col-sm-6">
            </div>
        </div>
    </div>
@endsection