<?php
// Required Fields: $item (eg Player), $fields[], $url (The url to post items to).
// Optional Fields: $hidden_fields, $modal_id, $flash_id,
$trimmed_item = strpos($item, ' ') !== false ? join('', explode(' ', $item)) : $item;
if (!isset($modal_id)) {
    $modal_id = "delete{$trimmed_item}Modal";
}
$delete_base_url = url("admin/delete/{$item}");
if (!isset($url)) {
    $url = $delete_base_url;
}
?>
<script>
    function delete<?php echo $trimmed_item; ?>(id)
    {
        /* Disable the create project modal button */
        $('.delete-<?php echo lcfirst($trimmed_item); ?>').prop( "disabled", true );

        var url = '{{ $delete_base_url }}';

        var data = {
            "id": id,
            "_method": "DELETE",
            "_token": "{{ csrf_token() }}"
        }

        $('#<?php echo $modal_id;?>').modal('hide');

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
<script>
    $('#<?php echo $modal_id;?>').on('show.bs.modal', function (event) {
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