@php
@endphp
@extends('base')
@section('title', $pageTitle)
@section('content')
    <div class="container w-50">
        <h1 class="text-center text-primary text mt-2">{{$pageName}}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        {!! Form::open([
            'url' => $targetRoute,
            'method' => $method ?? 'POST',
        ]) !!}
            <div class="form-group mb-3">
                {!! Form::label('username', 'Username', ['class' => "mb-1"]) !!}
                {!! Form::text( 'username', $userInfo->username ?? null, ['class' => "form-control", 'id' => "username", 'aria-describedby' => "username", 'placeholder' => "Enter username"]) !!}
            </div>
            @if (!empty($method) && $method == 'PUT')
                <div class="form-group mb-3">
                    {!! Form::label('current_password', 'Current password', ['class' => "mb-1"]) !!}
                    {!! Form::password( 'current_password', ['class' => "form-control", 'id' => "current_password", 'aria-describedby' => "current_password", 'placeholder' => "Enter current password"]) !!}
                </div>
            @endif
            <div class="form-group mb-3">
                {!! Form::label('password', 'Password', ['class' => "mb-1"]) !!}
                {!! Form::password( 'password', ['class' => "form-control", 'id' => "password", 'aria-describedby' => "password", 'placeholder' => "Enter password"]) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::label('password_confirmation', 'Confirm password', ['class' => "mb-1"]) !!}
                {!! Form::password( 'password_confirmation', ['class' => "form-control", 'id' => "password_confirmation", 'aria-describedby' => "password_confirmation", 'placeholder' => "Confirm password"]) !!}
            </div>
            {!! Form::hidden( 'id', $userInfo->id ?? null) !!}
            <div style="width: fit-content" class="d-block mb-3 me-auto ms-auto">
                <a class="btn btn-secondary px-4" href="{{ route('user.index') }}">Back</a>
                {!! Form::submit('Submit', ['class' => "btn btn-primary px-4"]) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
