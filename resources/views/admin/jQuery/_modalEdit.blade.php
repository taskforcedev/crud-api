<script>
$(function() {

    //var id;

    function editItem(id) {
        var items = $('#item-' + id + ' .editable');
        actionsEditing(items, id);
    }

    function actionsEditing(items, id)
    {
        $.each(items, function() {
            /* get the field name */
            var field = $(this).data("field");
            /* get the value */
            val = $(this).html();

            $(this).html('<input type="text" name="'+field+'" id="'+field+'" value="'+val+'" />');
        });
        
        /* Change Edit and Delete to Save and Cancel */
        saveCancelActions(id);
    }

    function defaultActions(id)
    {
        var html = '<button id="edit-'+id+'" class="btn btn-xs btn-info editButton"><i class="fa fa-pencil"></i> Edit</button> <button id="delete-'+id+'" class="btn btn-xs btn-danger deleteButton"><i class="fa fa-times"></i> Delete</button>';
        var actions = $('#actions-' + id);
        actions.html(html);
    }

    function saveCancelActions(id)
    {
        var html = '<button id="save-'+id+'" class="btn btn-xs btn-success saveButton"><i class="fa fa-floppy-o"></i> Save</button> <button id="cancel-'+id+'" class="btn btn-xs btn-warning cancelButton"><i class="fa fa-times"></i> Cancel</button>';
        var actions = $('#actions-' + id);
        actions.html(html);
        console.log(actions);
    }

    // Add button click handler
    $( ".editButton" ).button().on( "click", function() {
        console.log(this);
        var id_string = this.id;
        id = id_string.substring(5);
        editItem(id);
    });
});
</script>