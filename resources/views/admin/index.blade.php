@extends('crudapi::layouts.master')

@section('content')
    <h1>{{ $model }}</h1>

    <table class="table">
    <tr>
        @foreach($fields as $f)
            <th>{{ ucfirst($f) }}</th>
        @endforeach
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    <tbody>
        @if(isset($items))
            @foreach($items as $item)
                <tr>
                @foreach($fields as $f)
                    <td>{{ $item->$f }}</td>
                @endforeach
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
@stop
