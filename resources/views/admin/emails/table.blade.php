<table class="table table-striped" id="emails-table">
    <thead>
        <th>{!! trans('words.email') !!}</th>
        <th>{!! trans('words.client') !!}</th>
        <th colspan="3">{!! trans('words.action') !!}</th>
    </thead>
    <tbody>
        @if (!empty($emails))
    @foreach($emails as $email)
        <tr>
            <td>{!! $email->name !!}</td>
            <td>{!! $email->clients->name !!}</td>
            <td>
                {!! Form::open(['route' => ['root.emails.destroy', $email->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('root.emails.show', [$email->id]) !!}" class='btn btn-secondary btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('root.emails.edit', [$email->id]) !!}" class='btn btn-secondary btn-xs'><i class="fa fa-edit"></i> Edit</a>
                    {!! Form::button('<i class="fa fa-trash"></i> Delete', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('".trans('phrases.areYouSure')."')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    @endif
    </tbody>
</table>