@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {!! trans('words.phone') !!}
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {!! trans('words.home') !!}</a></li>
            <li><a href="{!! route('root.phones.index') !!}"><i class="fa fa-key"></i> {!! trans('words.phones') !!}</a></li>
            <li class="active">{!! trans('words.edit') !!}</li>
        </ol>
   </section>
   <div class="content">

       <div class="box panel card box-primary panel-primary card-primary">
           <div class="box-body panel-body card-body">
               <div class="row">

                   @include('layouts.partials.message')

                   {!! Form::model($phone, ['route' => ['phones.update', $phone->id], 'method' => 'patch']) !!}

                        @include('root.phones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection