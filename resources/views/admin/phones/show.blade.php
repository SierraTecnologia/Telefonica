@extends('layouts.dashboard')

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('words.phone') !!}
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('root.phones.show_fields')
                    <a href="{!! route('root.phones.index') !!}" class="btn btn-default">{!! trans('words.back') !!}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
