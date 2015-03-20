<?php // CONFIRMATION DIALOG ?>
<div id="confirmDelete" title="Delete {{ $model }}" style="display: none;">
    This action <em>cannot</em> be undone.

    Are you sure you want to delete this {{ $model }}?
</div>

<?php // SCRIPT ?>
<script>
$(function() {

    var form = $("deleteItem")

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
        id = $(this).data('id');
        
        jQuery.ajax({
            url: "{{ url('api/' . $model) }}/" + id,
            type: "POST",
            data: {
                '_token': "{{ csrf_token() }}",
                '_method': "DELETE"
            },
            success: function (response) {
                    window.location.reload();
            },
        });
    }

    // Add button click handler
    $( ".deleteButton" ).button().on( "click", function() {
        var id_string = this.id;
        id = id_string.substring(7);
        confirm.data('id', id)
        confirm.dialog( "open" );
    });
});
</script>