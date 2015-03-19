@extends('crudapi::layouts.master')

@section('content')
    <h1>{{ $model }}<button class="btn btn-sm btn-success pull-right" id="insert-{{ lcfirst($model) }}"><i class="fa fa-plus"></i> Insert {{ $model }}</button></h1>
    @include('crudapi::admin.jQuery._modalForm')

    <table class="table table-responsive table-striped">
    <thead>
        <tr>
            @foreach($fields as $f)
                @if ($f !== 'password')
                    <th>{{ ucfirst($f) }}</th>
                @endif
            @endforeach
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($items))
            @foreach($items as $item)
                <tr id="item-{{ $item->id }}">
                @foreach($fields as $f)
                    @if ($f !== 'password')
                        <td class="editable">{{ $item->$f }}</td>
                    @endif
                @endforeach
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td><button class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Delete</button></td>
                </tr>
            @endforeach
        @endif
    </tbody>
    </table>

    <?php
    if (method_exists($items, 'render')) {
        echo $items->render();
    }
    ?>
@stop
