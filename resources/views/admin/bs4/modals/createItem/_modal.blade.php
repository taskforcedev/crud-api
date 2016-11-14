<?php
// Required Fields: $item, $fields[], $url (The url to post items to).
// Optional Fields: $hidden_fields, $flash_id
?>
<div class="modal fade" id="{{ $apiHelper->modal('create')->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $apiHelper->modal('create')->title }}</h4>
            </div>
            <div class="modal-body">
                @if (isset($flash_id))
                    <div id="{{ $flash_id }}" class="alert" style="display: none;"></div>
                @endif

                <?php
                $apiHelper
                    ->renderFields('form-create');
                ?>

                @if(isset($content))
                    <?php echo $content; ?>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create-{{ $apiHelper->trimmedModel() }}" onclick="return {{ $apiHelper->jsMethodName('create') }}();">Create {{ $item }}</button>
            </div>
        </div>
    </div>
</div>
