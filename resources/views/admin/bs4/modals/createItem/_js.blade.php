<?php
    $url = $apiHelper->modal('create')->url;
?>
<script>
    function {{ $apiHelper->jsMethodName('create') }}()
    {
        /* Disable the create project modal button */
        $('.create-{{ $apiHelper->trimmedModel() }}').prop( "disabled", true );

        var data = {
            <?php
            $apiHelper
                ->renderFields('js-modal-create');
            ?>

            "_token": "{{ csrf_token() }}"
        }

        /* Send the post request */
        @if(isset($done))
            $.post( "{{ $url }}", data, function() {
            <?php echo $done; ?>
        });
        @else
            $.post("{{ $url }}", data);
        @endif

        /* Enable the button in case of failure */
        //$('.create-{{ $apiHelper->trimmedModel() }}').prop( "disabled", false );
    }
</script>