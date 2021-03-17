@extends('layouts.page')

@section('title', 'Phones')

@section('content_header')
    <h1>Phones</h1>
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
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif

  @include('telefonica::admin.phones.table', ['phones' => $phones])
  
<div>
@endsection