@extends('layouts.app')

@section('content_header')
    <h1 class="float-left">{!! trans('words.emails') !!}</h1>
    <h1 class="float-right">
        <a class="btn btn-primary float-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('root.emails.create') !!}">{!! trans('words.addNew') !!}</a>
    </h1>
@stop

@section('content')
    <div class="clearfix"></div>

    @include('pedreiro::partials.message')

    <div class="clearfix"></div>
    <div class="box panel card box-primary panel-primary card-primary">
        <div class="box-body panel-body card-body">
                @include('root.emails.table')
        </div>
    </div>
@endsection

