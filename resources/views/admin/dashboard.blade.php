@extends($layout)

@section('content')
    <h2>CrudAPI</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Model</th>
            <th>Namespace</th>
            <th>Create</th>
            <th>Read (View)</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($models as $m)
            <tr>
                <td><a href="{{ $m['api_url'] }}">{{ $m['model'] }}</a></td>
                <td>{{ $m['namespace'] }}</td>
                <td>{{ $m['status']['create'] ? 'true' : 'false' }}</td>
                <td>{{ $m['status']['read'] ? 'true' : 'false' }}</td>
                <td>{{ $m['status']['update'] ? 'true' : 'false' }}</td>
                <td>{{ $m['status']['delete'] ? 'true' : 'false' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection