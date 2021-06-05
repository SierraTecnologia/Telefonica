@extends('layouts.page')

@section('title', 'Show Phone')

@section('content_header')
    <h1>Show Phone</h1>
@stop

@section('css')

@stop

@section('js')

@stop

@section('content')

    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2> Show Phone</h2>

            </div>

            <div class="pull-right">

                <a class="btn btn-primary" href="{{ route('admin.phones.index') }}"> Back</a>

            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">
                    Phone Phones
                </h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                @include('admin.root.phones.table', ['phones' => $phone->phones()->paginate()])</h3>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">
                    Phone Customers
                </h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                @include('root.customers.table', ['customers' => $phone->customers()->paginate()])</h3>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
    </div>

    <?php /*
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">
                    CreditCards
                </h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                @include('root.creditCards.table', ['creditCards' => $phone->creditCards()->paginate()])</h3>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
    </div>
    */ ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">


        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">Id</h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                <blockquote>
                    {{ $phone->id }}
                </blockquote>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">country</h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                <blockquote>
                    {{ $phone->country }}
                </blockquote>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">region</h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                <blockquote>
                    {{ $phone->region }}
                </blockquote>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">number</h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                <blockquote>
                    {{ $phone->number }}
                </blockquote>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">created_at</h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                <blockquote>
                    {{ $phone->created_at }}
                </blockquote>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="box card box-solid">
            <div class="box-header card-header with-border">
                <i class="fa fa-text-width"></i>

                <h3 class="box-title">updated_at</h3>
            </div>
            <!-- /.box-header card-header -->
            <div class="box-body card-body">
                <blockquote>
                    {{ $phone->updated_at }}
                </blockquote>
            </div>
            <!-- /.box-body card-body -->
        </div>
        </div>
    </div>

@endsection