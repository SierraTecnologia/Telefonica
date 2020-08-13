@extends('layouts.dashboard')

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('words.email') !!}
        </h1>
    </section>
    <div class="content">

        <div class="box card box-primary">

            <div class="box-body card-body">
                <div class="row">
                    {!! Form::open(['route' => 'emails.store']) !!}

                        @include('root.emails.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
