@extends($layout)

@section('content')
    <h2>CrudAPI</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Model</th>
            <th>Namespace</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($models as $m)
            <tr>
                <td><a href="{{ $m['api_url'] }}">{{ $m['model'] }}</a></td>
                <td>{{ $m['namespace'] }}</td>
                <td>{{ $m['status'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection