@extends($layout)

@section('content')
<?php
$modal_data = [
    'apiHelper' => $apiHelper,
    'item' => $model,
    'fields' => $instance->getFillable(),
    'done' => 'window.location.reload()',
];

$create_data = $modal_data;
$edit_data = $modal_data;
$delete_data = $modal_data;
?>
    @include('crudapi::admin.bs4.modals.createItem._modal', $create_data)
    @include('crudapi::admin.bs4.modals.editItem._modal', $edit_data)
    @include('crudapi::admin.bs4.modals.deleteItem._modal', $delete_data)
<?php
    $displayName = $apiHelper->getModelDisplayName();
    $lastCharacter = substr($displayName, -1);
if ($lastCharacter !== 's' && $lastCharacter !== 'S') {
    $displayName .= 's';
}
?>
    <h3>{{ $displayName }} @include('crudapi::admin.bs4.modals.createItem._button', ['classes' => 'pull-right'])</h3>

    @if(count($results) > 0)
        <table class="table">
            <thead>
            <tr>
                {{ $apiHelper->renderFields('table-headings') }}
                <th>Actions</th>
            </tr>
            </thead>
            @foreach($results as $r)
                <tr>
                    <?php
                    $apiHelper
                        ->setInstance($r)
                        ->renderFields('table-content');
                    ?>
                    <td>
                        @include('crudapi::admin.bs4.modals.editItem._button', $edit_data)
                        @include('crudapi::admin.bs4.modals.deleteItem._button', $delete_data)
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        No {{ $displayName }} Found
    @endif
@endsection

@section('scripts')
    @include('crudapi::admin.bs4.modals.createItem._js', $create_data)
    @include('crudapi::admin.bs4.modals.editItem._js', $edit_data)
    @include('crudapi::admin.bs4.modals.deleteItem._js', $delete_data)
@endsection
