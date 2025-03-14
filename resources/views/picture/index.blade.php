@extends('base')
@section('title', 'Picture - List')
@section('content')
    <div class="container">
        <h1 class="text-center text-primary text mt-2">Picture gallery</h1>
        <div style="width: fit-content" class="d-block mb-2 me-0 ms-auto">
            <a type="button" class="btn btn-primary" href="{{ route('picture.create') }}">Add new Picture</a>
        </div>
        @if (session('message'))
          <div class="alert alert-success">
              {{ session('message') }}
          </div>
        @endif
        @if ($pictureList->count() > 0)
            <div class="d-flex flex-wrap justify-content-between">
                @foreach ( $pictureList as $picture )
                    <div class="card mb-2 border-none" style="width: 18rem;">
                        <img src="{{ asset('storage/' . $picture->picture_url) }}" class="card-img-top" alt="{{ $picture->name }}">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <a href="{{ route('picture.edit', ['id' => $picture->id]) }}" class="btn btn-outline-primary w-25 mx-auto">Edit</a>
                            {!! Form::open([
                                'url' => route('picture.destroy', ['id' => $picture->id]),
                                'method' => 'DELETE',
                                'onsubmit' => "return confirm('Are you sure you want to delete this picture? This action cannot be undone.')",
                                'class' => "w-50 mx-auto"
                              ]) !!}
                                <button type="submit" class="btn btn-outline-danger w-100">Delete</button>
                              {!! Form::close() !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                There is no data!
            </div>
        @endif
    </div>
@endsection