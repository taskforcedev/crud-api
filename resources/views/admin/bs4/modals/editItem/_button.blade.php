<?php
$trimmed_item = strpos($model, ' ') !== false ? join('', explode(' ', $model)) : $model;
?><button
    class="btn btn-sm btn-info"
    data-toggle="modal"
    data-id="{{ $r->id }}"
    <?php
        foreach ($fields as $f) {
            echo "data-{$f}=\"" . $r->$f . "\" ";
        }
    ?>
    data-target="#edit{{$trimmed_item}}Modal">Edit</button>