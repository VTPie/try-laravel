@php
@endphp
@extends('base')
@section('title', 'User - List')
@section('content')
  <div class="container">
    <h1 class="text-center text-primary text mt-2">User management</h1>
    <div style="width: fit-content" class="d-block mb-2 me-0 ms-auto">
      <a type="button" class="btn btn-primary" href="{{ route('user.create') }}">Add new user</a>
    </div>
    @if (session('message'))
      <div class="alert alert-success">
          {{ session('message') }}
      </div>
    @endif
    <table class="table text-center">
      <thead class="thead-light">
        <tr>
          <th class="align-middle" scope="col-1">#</th>
          <th class="align-middle" scope="col-4">Username</th>
          <th class="align-middle" scope="col-3">Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($usersInfo->count() > 0)
          @foreach ($usersInfo as $userInfo)
            <tr>
              <th class="align-middle" scope="row">{{$userInfo->id}}</th>
              <td class="align-middle">{{$userInfo->username}}</td>
              <td class="align-middle">
                  <a type="button" class="btn btn-outline-primary" href="{{ route('user.edit', ['id' => $userInfo->id]) }}">Edit</a>
                  {!! Form::open([
                    'url' => route('user.destroy', ['id' => $userInfo->id]),
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to delete this user? This action cannot be undone.')",
                    'class' => "d-inline"
                  ]) !!}
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                  {!! Form::close() !!}
              </td>
            </tr>
          @endforeach
        @else
            <tr>
              <td colspan="6">There is no data!</td>
            </tr>
        @endif
      </tbody>
    </table>
  </div>
@endsection