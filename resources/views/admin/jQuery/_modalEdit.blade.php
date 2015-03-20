<script>
function refreshEventHandlers()
    {
        // EDIT
        $( ".editButton" ).button().on( "click", function() {
            var id_string = this.id;
            var id = id_string.substring(5);
            editItem(id);
        });

        // DELETE
        // DELETE
        $( ".deleteButton" ).button().on( "click", function() {
            var confirm = $( "#confirmDelete" ).dialog({
                autoOpen: false,
                height: 300,
                width: 400,
                modal: true,
                buttons: {
                    "Delete": deleteItem,
                    Cancel: function() {
                        confirm.dialog( "close" );
                    }
                },
                close: function() {
                    confirm.dialog( "close" );
                }
            });

            function deleteItem() {
                var id = $(this).data('id');
                
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

            var id_string = this.id;
            var id = id_string.substring(7);
            confirm.data('id', id);
            confirm.dialog( "open" );
        });

        // SAVE
        $( ".saveButton" ).button().on( "click", function() {
            var id_string = this.id;
            var id = id_string.substring(5);
            saveItem(id);
        });

        // CANCEL
        $( ".cancelButton" ).button().on( "click", function() {
            var id_string = this.id;
            var id = id_string.substring(7);
            actionsCancel(id);
        });
    }

    function saveItem(id) {

    }

    function editItem(id) {
        var items = $('#item-' + id + ' .editable');
        return actionsEditing(items, id);
    }

    function actionsEditing(items, id) {
        $.each(items, function() {
            /* get the field name */
            var field = $(this).data("field");
            /* get the value */
            var val = $(this).html();

            var ihtml = '<input type="text" name="'+field+'" id="'+field+'-'+id+'" value="'+val+'" />';
            $(this).html(ihtml);
        });
        
        /* Change Edit and Delete to Save and Cancel */
        saveCancelActions(id);

        refreshEventHandlers();
    }

    function actionsCancel(id)
    {
        /* Reset the table fields */
        var items = $('#item-' + id + ' .editable input');

        /* Reset the TD values */
        $.each(items, function () {
            /* get the input val */
            var val = $(this).val();
            $(this).parent().html(val);
        });

        /* Change the actions */
        defaultActions(id);

        refreshEventHandlers();
    }

    function defaultActions(id)
    {
        /* Change the actions */
        var html = '<button id="edit-'+id+'" class="btn btn-xs btn-info editButton"><i class="fa fa-pencil"></i> Edit</button> <button id="delete-'+id+'" class="btn btn-xs btn-danger deleteButton"><i class="fa fa-times"></i> Delete</button>';
        var actions = $('#actions-' + id);
        actions.html(html);
    }

    function saveCancelActions(id) {
        /* Change the actions */
        var html = '<button id="save-'+id+'" class="btn btn-xs btn-success saveButton"><i class="fa fa-floppy-o"></i> Save</button> <button id="cancel-'+id+'" class="btn btn-xs btn-warning cancelButton"><i class="fa fa-times"></i> Cancel</button>';
        var actions = $('#actions-' + id);
        actions.html('');
        actions.append(html);
    }
$(function() {
    refreshEventHandlers();
});


</script>