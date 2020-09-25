<table class="table table-striped" id="phones-table">
    <thead>
        <th>{!! trans('words.name') !!}</th>
        <th>{!! trans('words.client') !!}</th>
        <th>{!! trans('words.dominio') !!}</th>
        <th>{!! trans('words.category') !!}</th>
        <th colspan="3">{!! trans('words.action') !!}</th>
    </thead>
    <tbody>
        @if (!empty($phones))
            @foreach($phones as $phone)
            <?php dd($phone) ?>
                <tr>
                    <td>{!! $phone->name !!}</td>
                    <td>{!! $phone->clients->name !!}</td>
                    <td>{!! $phone->dominios->name !!}</td>
                    <td>{!! $phone->phoneCategory->name !!}</td>
                    <td>
                        {!! Form::open(['route' => ['root.phones.destroy', $phone->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('root.phones.show', [$phone->id]) !!}" class='btn btn-secondary btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('root.phones.edit', [$phone->id]) !!}" class='btn btn-secondary btn-xs'><i class="fa fa-edit"></i> Edit</a>
                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".trans('phrases.areYouSure')."')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>