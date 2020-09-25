<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', trans('words.email').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Clients Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('clients_id', trans('words.client').':') !!}
    {!! Form::select(
        'clients_id', $clients, null,
        ['class' => 'form-control', 'placeholder' => trans('dashboard/contact.selectClient')]
    ) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('words.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('root.emails.index') !!}" class="btn btn-secondary">{!! trans('words.cancel') !!}</a>
</div>
