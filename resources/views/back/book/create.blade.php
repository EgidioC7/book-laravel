@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h2>Create book :</h2>
                <form method="POST" action="{{route('book.store')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" value="{{old('title')}}" name="title"
                               placeholder="Titre du livre">
                        @if($errors->has('title')) <span class="error">{{$errors->first('title')}}</span>@endif
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"
                                  rows="3">{{old('description')}}</textarea>
                    </div>
                    @if($errors->has('description')) <span class="error">{{$errors->first('description')}}</span>@endif
                    <br>
                    <select class="form-control form-control-lg" name="genre_id">
                        <option id="0" value="" {{ is_null(old('genre_id')) ? 'selected' : '' }}>No genre</option>
                        @forelse($genres as $id => $name)
                            <option id="{{$id}}"
                                    value="{{$id}}" {{ (old('genre_id') == $id ) ? 'selected' : '' }}>{{$name}}</option>
                        @empty
                            <option>Aucun genre</option>
                        @endforelse
                    </select>
                    @if($errors->has('genre_id')) <span class="error">{{$errors->first('genre_id')}}</span>@endif<br>
                    @forelse($authors as $id => $name)
                        <label class="control-label" for="author{{$id}}">{{$name}}</label>
                        <input name="authors[]" value="{{$id}}" type="checkbox" class="form-control"
                               id="author{{$id}}" {{ ( !empty(old('authors')) and in_array($id, old('authors')) )? 'checked' : ''  }}>
                    @empty
                        <option>Aucun auteur</option>
                    @endforelse
                    <h2>Status</h2>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="published" value="published"
                                {{ (old('status') == 'published' ) ? 'checked' : '' }} checked>
                        <label class="form-check-label" for="published">
                            Publier
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="unpublished"
                               value="unpublished" {{ (old('status') == 'unpublished' ) ? 'checked' : '' }}>
                        <label class="form-check-label" for="unpublished">
                            Dépublier
                        </label>
                    </div>
                    <h2>File : </h2>
                    <div class="form-group">
                        <input type="file" class="form-control-file" id="picture" name="picture">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-6 col-sm-6">
            </div>
        </div>
    </div>
@endsection