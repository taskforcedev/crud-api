@extends('crudapi::layouts.master')

@section('content')
    <h1>{{ $model }}</h1>

    <table class="table">
    <tr>
        @foreach($fields as $f)
            <th>{{ ucfirst($f) }}</th>
        @endforeach
    </tr>
    <tbody>
        @if(isset($items))
            @foreach($items as $item)
                <tr>
                @foreach($fields as $f)
                    <td>{{ $item->$f }}</td>
                @endforeach
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
@stop
