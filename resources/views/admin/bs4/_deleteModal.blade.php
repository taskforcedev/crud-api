<?php
// Required Fields: $item (eg Player), $fields[], $url (The url to post items to).
// Optional Fields: $hidden_fields, $modal_id, $flash_id,
$trimmed_item = strpos($item, ' ') !== false ? join('', explode(' ', $item)) : $item;
if (!isset($modal_id)) {
    $modal_id = "delete{$trimmed_item}Modal";
}
$delete_base_url = url("api/{$item}");
if (!isset($url)) {
    $url = $delete_base_url;
}
?><script>
function delete<?php echo ucfirst($trimmed_item); ?>(id)
{
    /* Disable the create project modal button */
    $('.delete-<?php echo lcfirst($trimmed_item); ?>').prop( "disabled", true );

    var url = '{{ $delete_base_url }}/' + id;

    var data = {
        "_method": "DELETE",
        "_token": "{{ csrf_token() }}"
    }

    $('#<?=$modal_id;?>').modal('hide');

    /* Send the post request */
    @if(isset($done))
        $.post( url, data, function() {
        <?php echo $done; ?>
    });
    @else
        $.post(url, data);
    @endif

    /* Enable the button in case of failure */
    //$('.create-project').prop( "disabled", false );
}
</script>
<div class="modal fade" id="<?=$modal_id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete {{ $item }}</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you wish to delete this {{ $item }}.  This cannot be undone!</p>

                <table class="table">
                <?php
                    foreach ($fields as $field) {
                        echo "<tr><td>{$field}</td><td><span id=\"deletedItem" . ucfirst($field) . "\"></span></td></tr>";
                    }
                ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                <button type="button" id="modalItemDeleteButton" class="btn btn-danger" onclick="return delete<?php echo ucfirst($trimmed_item); ?>();">Delete {{ $item }}</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#<?=$modal_id;?>').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal

    var id = button.data('id');
    <?php
    foreach ($fields as $field) {
        echo 'var ' . $field . ' = button.data(\'' . $field . '\')' . "\n";
    } ?>

    //var recipient = button.data('whatever') // Extract info from data-* attributes

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    var callback = 'delete<?php echo $trimmed_item; ?>('+id+')';
    $('#modalItemDeleteButton').attr('onclick', callback);
    <?php
    foreach ($fields as $field) {
        $ucfield = ucfirst($field);
        echo "modal.find('#deletedItem{$ucfield}').text({$field});\n";
    }
    ?>
})
</script>