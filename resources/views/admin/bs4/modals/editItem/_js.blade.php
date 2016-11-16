<?php
// Required Fields: $item (eg Player), $fields[], $url (The url to post items to).
// Optional Fields: $hidden_fields, $modal_id, $flash_id,
$url = $apiHelper->modal('edit')->url;
?>
<script>
    function {{ $apiHelper->jsMethodName('edit') }}(id)
    {
        /* Disable the edit project modal button */
        $('.edit-{{ $apiHelper->trimmedModel() }}').prop( "disabled", true );

        var url = '{{ $url }}';

        var data = {
            "id": id,
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
        $('.edit-{{ $apiHelper->trimmedModel() }}').prop( "disabled", false );
    }
</script>
<script>
$('#{{ $apiHelper->modal('edit')->id }}').on('show.bs.modal', function (event) {

var button = $(event.relatedTarget) // Button that triggered the modal

var id = button.data('id');
<?php
foreach ($fields as $field) {
    echo 'var ' . $field . ' = button.data(\'' . $field . '\');' . "\n";
}

foreach ($fields as $field) {
    $ucfield = ucfirst($field);
    if ($apiHelper->fieldHelper->isIdField($field)) {
        echo "$('#editItem{$ucfield} option[value=' +{$field} +']').attr('selected', 'selected'); " . "\n";
    } else {
        echo "$('#editItem{$ucfield}').val({$field});\n";
    }
}
?>

var callback = '{{ $apiHelper->jsMethodName('edit') }}('+id+')';
$('#modalItemEditButton').attr('onclick', callback);
});
</script>