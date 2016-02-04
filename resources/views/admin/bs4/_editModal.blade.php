<?php
// Required Fields: $item (eg Player), $fields[], $url (The url to post items to).
// Optional Fields: $hidden_fields, $modal_id, $flash_id,
$trimmed_item = strpos($item, ' ') !== false ? join('', explode(' ', $item)) : $item;

if (!isset($modal_id)) {
    $modal_id = "edit{$trimmed_item}Modal";
}

$edit_base_url = url("api/{$item}");
if (!isset($url)) {
    $url = $edit_base_url;
}
?>
<script>
    function edit<?php echo ucfirst($trimmed_item); ?>(id)
    {
        /* Disable the edit project modal button */
        $('.edit-<?php echo lcfirst($trimmed_item); ?>').prop( "disabled", true );

        var url = '<?php echo $edit_base_url; ?>/' + id;

        var data = {
            @foreach($fields as $f)
            <?php $ucfield = ucfirst($f); ?>
            "{{ $f }}": $('#editItem{{$ucfield}}').val(),
            @endforeach

            "_method": "PATCH",
            "_token": "{{ csrf_token() }}"
        }

        /* Send the post request */
        @if(isset($done))
            $.post( url, data, function() {
            <?php echo $done; ?>
        });
        @else
            $.post( url, data );
        @endif

        /* Enable the button in case of failure */
        //$('.edit-<?php echo lcfirst($trimmed_item); ?>').prop( "disabled", false );
    }
</script>
<div class="modal fade" id="<?=$modal_id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit {{ $item }}</h4>
            </div>
            <div class="modal-body">
                @foreach($fields as $f)
                    <fieldset class="form-group">
                        <label for="{{ $f }}">{{ $f }}</label>
                        <input class="form-control" type="text" id="editItem{{ ucfirst($f) }}" name="{{ $f }}" />
                    </fieldset>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="modalItemEditButton" class="btn btn-primary save-{{ lcfirst($trimmed_item) }}" onclick="return edit<?php echo ucfirst($trimmed_item); ?>();">Save {{ $item }}</button>
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

        <?php
        foreach ($fields as $field) {
            $ucfield = ucfirst($field);
            echo "$('#editItem{$ucfield}').val({$field});\n";
        }
        ?>

        var callback = 'edit<?php echo $trimmed_item; ?>('+id+')';
        $('#modalItemEditButton').attr('onclick', callback);
    })
</script>