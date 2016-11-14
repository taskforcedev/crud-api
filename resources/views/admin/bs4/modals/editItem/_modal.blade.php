<div class="modal fade" id="{{ $apiHelper->modal('edit')->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $apiHelper->modal('edit')->title }}</h4>
            </div>
            <div class="modal-body">
                {!! $apiHelper->renderFields('form-edit') !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="modalItemEditButton" class="btn btn-primary" onclick="return {!! $apiHelper->jsMethodName('edit') !!}();">Save {{ $apiHelper->getModelDisplayName() }}</button>
            </div>
        </div>
    </div>
</div>