@if (!empty($phones) && !$phones->isEmpty())
    @if (method_exists($phones,'onEachSide'))
        {{ $phones->onEachSide(10)->links() }}
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <td>ID</td>
                <td>Contry</td>
                <td>Region</td>
                <td>Number</td>
                <td>Usuários</td>
                <td>Created at</td>
                <td colspan="2">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach($phones as $phone)
            <tr>
                <td>{{$phone->id}}</td>
                <td>{{$phone->contry}}</td>
                <td>{{$phone->region}}</td>
                <td>{{$phone->number}}</td>
                <td>{{$phone->customers()->count()}}</td>
                <td>{{$phone->created_at->format('d/m/Y h:i:s')}}</td>
                <td>
                    <a href="{{ route('phones.show',$phone->id)}}" class="btn btn-primary">Show</a>
                    <!--
                    <a href="{{ route('phones.edit',$phone->id)}}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('phones.destroy', $phone->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>-->
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (method_exists($phones,'onEachSide'))
        {{ $phones->onEachSide(10)->links() }}
    @endif
@endif