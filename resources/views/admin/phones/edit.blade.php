@extends('layouts.page')

@section('title', 'Phones')

@section('content_header')
    <h1>Phones - Editar</h1>
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
    Edit Phone
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
      <form method="post" action="{{ route('phones.update', $phone->id) }}">
        @method('PATCH')
        @csrf
        <div class="form-group">
          <label for="name">Phone Country:</label>
          <input type="text" class="form-control" name="country" value={{ $phone->country }} />
        </div>
        <div class="form-group">
          <label for="price">Phone Region:</label>
          <input type="text" class="form-control" name="region" value={{ $phone->region }} />
        </div>
        <div class="form-group">
          <label for="quantity">Phone Number:</label>
          <input type="text" class="form-control" name="number" value={{ $phone->number }} />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</div>
@endsection