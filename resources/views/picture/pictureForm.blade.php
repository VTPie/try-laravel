@extends('base')
@section('title', $pageTitle)
@section('content')
    <div class="container w-50">
        <h1 class="text-center text-primary text mt-2">{{ $pageName }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::open([
            'url' => $targetRoute,
            'method' => $method ?? 'POST',
            'files' => true
        ]) !!}
            <div class="form-group mb-3">
                {!! Form::label('name', 'Picture name', ['class' => "mb-1"]) !!}
                {!! Form::text( 'name', $pictureInfo->name ?? null, ['class' => "form-control", 'id' => "name", 'aria-describedby' => "name", 'placeholder' => "Enter new picture name"]) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::label('file', 'Upload picture', ['class' => "mb-1"]) !!}
                <br>
                {!! Form::file( 'file' ) !!}
            </div>
            @if (isset($pictureInfo->picture_url))
                <div class="form-group mb-3">
                    <img src="{{ asset('storage/' . $pictureInfo->picture_url) }}" alt="{{ $pictureInfo->name }}"> 
                </div>
            @endif
            <div style="width: fit-content" class="d-block mb-3 me-auto ms-auto">
                <a class="btn btn-secondary px-4" href="{{ route('picture.index') }}">Back</a>
                {!! Form::submit('Submit', ['class' => "btn btn-primary px-4"]) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection