@extends('layouts.page')

@section('title', 'Phones')

@section('content_header')
    <h1>Phones - Criar</h1>
@stop

@section('css')

@stop

@section('js')

@stop

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Add Phone
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('phones.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Country:</label>
              <input type="text" class="form-control" name="country"/>
          </div>
          <div class="form-group">
              <label for="price">Region :</label>
              <input type="text" class="form-control" name="region"/>
          </div>
          <div class="form-group">
              <label for="quantity">Number:</label>
              <input type="text" class="form-control" name="number"/>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>
@endsection