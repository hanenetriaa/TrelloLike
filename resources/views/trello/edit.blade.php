@extends('layouts.app')

@section('content')

    <form action="{{ route('listes.update', ['id'=>$id ,'idList'=>$list->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <input value="{{ $list->category }}" name="category" type="text" class="form-control" placeholder="Indiquer le titre du post">
        </div>

        <button type="submit" class="btn btn-success">Editer le post</button>
    </form>

    @endsection