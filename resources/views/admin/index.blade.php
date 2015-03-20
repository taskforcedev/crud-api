@extends('crudapi::layouts.master')

@section('content')
    <script>
    function saveCancelActions(id) {
        /* Change the actions */
        var html = '<button class="btn btn-xs btn-success" onclick="saveItem('+id+')"><i class="fa fa-floppy-o"></i> Save</button> <button class="btn btn-xs btn-warning cancelButton" onclick="cancelEdit('+id+')"><i class="fa fa-times"></i> Cancel</button>';
        var actions = $('#actions-' + id);
        actions.html('');
        actions.append(html);
    }

    function cancelEdit(id) {
        var fields = $('#item-' + id + ' .editable');

        /* Set the value back to the original value */
        $.each(fields, function() {
            var original = $(this).data('originalValue');
            $(this).html(original);
        });

        defaultActions(id);
    }

    function defaultActions(id) {
        /* Change the actions */
        var html = '<button class="btn btn-xs btn-info" onclick="editItem('+id+')"><i class="fa fa-pencil"></i> Edit</button> <button class="btn btn-xs btn-danger" onclick="deleteItem(this)"><i class="fa fa-times"></i> Delete</button>';
        var actions = $('#actions-' + id);
        actions.html(html);
    }

    function saveItem(id) {

    }

    function confirmedDelete(id) {
        jQuery.ajax({
            url: "{{ url('api/' . $model) }}/" + id,
            type: "POST",
            data: {
                '_token': "{{ csrf_token() }}",
                '_method': "DELETE"
            },
            success: function () {
                    window.location.reload();
            }
        });
    }

    function deleteItem(btn) {
        var id = $(btn).data('item-id');

        var form = $("deleteItem");

        var confirm = $( "#confirmDelete" ).dialog({
            autoOpen: false,
            height: 300,
            width: 400,
            modal: true,
            buttons: {
                "Delete": function() {
                    confirmedDelete(id);
                },
                Cancel: function() {
                    confirm.dialog( "close" );
                }
            },
            close: function() {
                confirm.dialog( "close" );
            }
        });


        confirm.dialog( "open" )
    }

    function editItem(id) {

        var fields = $('#item-' + id + ' .editable');

        $.each(fields, function() {
            /* get the field name */
            var field = $(this).data("field");

            /* get the value */
            var val = $(this).html();

            var ihtml = '<input type="text" name="'+field+'" id="'+field+'-'+id+'" value="'+val+'" />';
            $(this).html(ihtml);
        });
        
        /* Change Edit and Delete to Save and Cancel */
        saveCancelActions(id);
    }

    </script>
    <h1>{{ $model }}<button class="btn btn-sm btn-success pull-right" id="insert-{{ lcfirst($model) }}"><i class="fa fa-plus"></i> Insert {{ $model }}</button></h1>
    @include('crudapi::admin.jQuery._modalInsert')

    <div id="confirmDelete" title="Delete {{ $model }}" style="display: none;">
    This action <em>cannot</em> be undone.

    Are you sure you want to delete this {{ $model }}?
    </div>


    <table class="table table-responsive table-striped">
    <thead>
        <tr>
            @foreach($fields as $f)
                @if ($f !== 'password')
                    <th>{{ ucfirst($f) }}</th>
                @endif
            @endforeach
            <th class="hidden-xs">Created At</th>
            <th class="hidden-xs">Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($items))
            @foreach($items as $item)
                <tr id="item-{{ $item->id }}">
                @foreach($fields as $f)
                    @if ($f !== 'password')
                        <td class="editable" data-field="{{ $f }}" data-original-value="{{ $item->$f }}">{{ $item->$f }}</td>
                    @endif
                @endforeach
                    <td class="hidden-xs">{{ $item->created_at }}</td>
                    <td class="hidden-xs">{{ $item->updated_at }}</td>
                    <td id="actions-{{ $item->id }}">
                        <button class="btn btn-xs btn-info" onclick="editItem({{ $item->id }});"><i class="fa fa-pencil"></i> Edit</button> 
                        <button class="btn btn-xs btn-danger" onclick="deleteItem(this)" data-item-id="{{ $item->id }}"><i class="fa fa-times"></i> Delete</button>
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
