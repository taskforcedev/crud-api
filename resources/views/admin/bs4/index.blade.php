@extends($layout)

@section('content')
<h1>{{ $model }} <button class="btn btn-sm btn-success pull-xs-right" data-toggle="modal" data-target="#create{{ $model }}Modal"><i class="fa fa-plus"></i> Insert {{ $model }}</button></h1>

<table class="table table-striped">
    <thead>
    <tr>
        <th class="hidden-xs">Id</th>
        @foreach($fields as $f)
            @if ($f !== 'password')
                <th>{{ ucfirst($f) }}</th>
            @endif
        @endforeach
        @if (isset($timestamps) && $timestamps)
            <th class="hidden-xs">Created At</th>
            <th class="hidden-xs">Updated At</th>
        @endif
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($items))
        @foreach($items as $item)
            <?php
                $data_attributes = ' data-id="'. $item->id .'" ';
                foreach ($fields as $f) {
                    $data_attributes .= ' data-'. $f .'="'. $item->$f .'" ';
                }
            ?>
            <tr id="item-{{ $item->id }}">
                <td class="hidden-xs">{{ $item->id }}</td>
                @foreach($fields as $f)
                    @if ($f !== 'password')
                        <td>{{ $item->$f }}</td>
                    @endif
                @endforeach
                @if (isset($timestamps) && $timestamps)
                    <td class="hidden-xs">{{ $item->created_at }}</td>
                    <td class="hidden-xs">{{ $item->updated_at }}</td>
                @endif
                <td id="actions-{{ $item->id }}">
                    <button class="btn btn-xs btn-info" data-toggle="modal"
                            data-target="#edit{{ $model }}Modal"
                            {!! $data_attributes !!}
                    ><i class="fa fa-pencil"></i> Edit</button>
                    <button class="btn btn-xs btn-danger" data-toggle="modal"
                            data-target="#delete{{ $model }}Modal"
                            {!! $data_attributes !!}
                    ><i class="fa fa-times"></i> Delete</button>
                </td>
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

@section('scripts')
    @include('crudapi::admin.bs4._createModal', [ 'item' => $model, 'fields' => $fields, 'done' => 'location.reload()' ])
    @include('crudapi::admin.bs4._editModal',   [ 'item' => $model, 'fields' => $fields, 'done' => 'location.reload()' ])
    @include('crudapi::admin.bs4._deleteModal', [ 'item' => $model, 'fields' => $fields, 'done' => "$('#item-' + id).remove()" ])
@stop
