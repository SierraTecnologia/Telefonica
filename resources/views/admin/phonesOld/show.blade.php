@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('words.phone') !!}
        </h1>
    </section>
    <div class="content">
        <div class="box panel card box-primary panel-primary card-primary">
            <div class="box-body panel-body card-body">
                <div class="row" style="padding-left: 20px">
                    @include('telefonica::admin.phones.show_fields')
                    <a href="{!! route('root.phones.index') !!}" class="btn btn-secondary">{!! trans('words.back') !!}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
