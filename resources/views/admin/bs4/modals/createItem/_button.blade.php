<?php
if (!isset($classes)) {
    $classes = '';
}
?><button class="btn btn-primary {{ $classes }}" data-toggle="modal" data-target="#create{{$model}}Modal">
    Create {{ $apiHelper->getModelDisplayName() }}
</button>