<div class="modal fade" id="{{ $apiHelper->modal('delete')->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                <button type="button" id="modalItemDeleteButton" class="btn btn-danger" onclick="return {{ $apiHelper->jsMethodName('delete') }}();">Delete {{ $apiHelper->getModelDisplayName() }}</button>
            </div>
        </div>
    </div>
</div>