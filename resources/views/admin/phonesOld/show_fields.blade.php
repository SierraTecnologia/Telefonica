<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', trans('words.id').':') !!}
    <p>{!! $phone->id !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', trans('words.updatedAt').':') !!}
    <p>{!! $phone->updated_at !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', trans('words.createdAt').':') !!}
    <p>{!! $phone->created_at !!}</p>
</div>

<!-- Deleted At Field -->
<div class="form-group">
    {!! Form::label('deleted_at', trans('words.deletedAt').':') !!}
    <p>{!! $phone->deleted_at !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', trans('words.name').':') !!}
    <p>{!! $phone->name !!}</p>
</div>

<!-- Clients Id Field -->
<div class="form-group">
    {!! Form::label('clients_id', trans('words.client').':') !!}
    <p>{!! $phone->clients_id !!}</p>
</div>

<!-- Dominios Id Field -->
<div class="form-group">
    {!! Form::label('dominios_id', trans('words.dominio').':') !!}
    <p>{!! $phone->dominios_id !!}</p>
</div>

<!-- Phone Category Id Field -->
<div class="form-group">
    {!! Form::label('phone_category_id', trans('dashboard.phone.phoneCategoryId').':') !!}
    <p>{!! $phone->phone_category_id !!}</p>
</div>

