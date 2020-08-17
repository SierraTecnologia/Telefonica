@extends('layouts.app')

@section('content_header')
    <h1 class="pull-left">{!! trans('words.emails') !!}</h1>
    <h1 class="pull-right">
        <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('root.emails.create') !!}">{!! trans('words.addNew') !!}</a>
    </h1>
@stop

@section('content')
    <div class="clearfix"></div>

    @include('layouts.partials.message')

    <div class="clearfix"></div>
    <div class="box card box-primary">
        <div class="box-body card-body">
                @include('root.emails.table')
        </div>
    </div>
@endsection

