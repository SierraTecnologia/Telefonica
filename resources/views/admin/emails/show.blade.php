@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('words.email') !!}
        </h1>
    </section>
    <div class="content">
        <div class="box panel card box-primary panel-primary card-primary">
            <div class="box-body panel-body card-body">
                <div class="row" style="padding-left: 20px">
                    @include('root.emails.show_fields')
                    <a href="{!! route('root.emails.index') !!}" class="btn btn-secondary">{!! trans('words.back') !!}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
