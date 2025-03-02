@php
    $priorityList = config("todo.priority");
    $statusList = config("todo.status");
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
        {!! Form::open([
            'url' => $targetRoute,
            'method' => $method ?? 'POST',
        ]) !!}
            <div class="form-group mb-3">
                {!! Form::label('name', 'TODO', ['class' => "mb-1"]) !!}
                {!! Form::text( 'name', $todoInfo->name ?? null, ['class' => "form-control", 'id' => "name", 'aria-describedby' => "name", 'placeholder' => "Enter new todo"]) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::label('priority', 'Priority', ['class' => "mb-1"]) !!}
                {!! Form::select('priority', $priorityList, $todoInfo->priority ?? null, ['class' => 'form-select', 'aria-label'=> 'priority', 'id' => 'priority']) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::label('deadline', 'Deadline', ['class' => "d-block mb-1"]) !!}
                {!! Form::date('deadline', $todoInfo->deadline ?? null, ['id' => "deadline", 'class' => 'd-block w-100']) !!}
            </div>
            <div class="form-group mb-3">
                {!! Form::label('status', 'Status', ['class' => "mb-1"]) !!}
                {!! Form::select('status', $statusList, $todoInfo->status ?? null, ['class' => 'form-select', 'aria-label'=> 'status', 'id' => 'status']) !!}
            </div>
            <div style="width: fit-content" class="d-block mb-3 me-auto ms-auto">
                <a class="btn btn-secondary px-4" href="{{ route('todo.index') }}">Back</a>
                {!! Form::submit('Submit', ['class' => "btn btn-primary px-4"]) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
