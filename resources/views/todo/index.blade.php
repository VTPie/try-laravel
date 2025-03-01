@php
  use App\Helpers\Highlight as Highlight;
  use Collective\Html\FormFacade as Form;

  $priorityList = config("todo.priority");
  $statusList = config("todo.status");
@endphp
@extends('base')
@section('title', 'TODO - List')
@section('content')
  <div class="container">
    <h1 class="text-center text-primary text mt-2">TODO List</h1>
    <div style="width: fit-content" class="d-block mb-2 me-0 ms-auto">
      <a type="button" class="btn btn-primary" href="{{ route('todo.create') }}">Add new TODO</a>
    </div>
    @if (session('message'))
      <div class="alert alert-success">
          {{ session('message') }}
      </div>
    @endif
    @include('todo.searchBox')
    <table class="table text-center">
      <thead class="thead-light">
        <tr>
          <th class="align-middle" scope="col-1">#</th>
          <th class="align-middle" scope="col-4">TODO</th>
          <th class="align-middle" scope="col-1">Priority</th>
          <th class="align-middle" scope="col-2">Deadline</th>
          <th class="align-middle" scope="col-1">Status</th>
          <th class="align-middle" scope="col-3">Action</th>
        </tr>
      </thead>
      <tbody>
        @if ($todoInfos->count() > 0)
          @foreach ($todoInfos as $todoInfo)
            <tr>
              <th class="align-middle" scope="row">{{$todoInfo->id}}</th>
              <td class="align-middle">{!!Highlight::highlight($todoInfo->name, $searchValue)!!}</td>
              <td class="align-middle">{{$priorityList[$todoInfo->priority]}}</td>
              <td class="align-middle">{{$todoInfo->deadline}}</td>
              <td class="align-middle">{{$statusList[$todoInfo->status]}}</td>
              <td class="align-middle">
                  <a type="button" class="btn btn-outline-primary" href="{{ route('todo.edit', ['id' => $todoInfo->id]) }}">Edit</a>
                  {!! Form::open([
                    'url' => route('todo.destroy', ['id' => $todoInfo->id]),
                    'method' => 'DELETE',
                    'onsubmit' => "return confirm('Are you sure you want to delete this TODO? This action cannot be undone.')",
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
    {{ $todoInfos->links('components.pagination', ['items' => $todoInfos]) }}
  </div>
@endsection