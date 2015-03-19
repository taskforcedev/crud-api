@extends('crudapi::layouts.master')

@section('content')
    <h1>{{ $model }}<button class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> Insert {{ $model }}</button></h1>

    <table class="table">
    <tr>
        @foreach($fields as $f)
            <th>{{ ucfirst($f) }}</th>
        @endforeach
        <th>Created At</th>
        <th>Updated At</th>
        <th>Actions</th>
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
                    <td><button class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</button></td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>
@stop
