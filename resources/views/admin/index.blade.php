<?php
    if (!isset($uiframework) || $uiframework == 'bs3') {
        $uiframework = 'bs4';
    }

    $adminIndex = 'crudapi::admin.' . $uiframework . '.index';
?>
@include($adminIndex)