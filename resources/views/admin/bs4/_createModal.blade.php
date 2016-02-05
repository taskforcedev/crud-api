<?php
// Required Fields: $item (eg Player), $fields[], $url (The url to post items to).
// Optional Fields: $hidden_fields, $modal_id, $flash_id, $title

$trimmed_item = strpos($item, ' ') !== false ? join('', explode(' ', $item)) : $item;

if (!isset($modal_id)) {
    $modal_id = "create{$trimmed_item}Modal";
}

if (!isset($title)) {
    $title = 'Create ' . $item;
}

if (!isset($url)) {
    $url = route('crudapi.store', $item);
}
?>
<script>
    function create<?php echo ucfirst($trimmed_item); ?>()
    {
        /* Disable the create project modal button */
        $('.create-<?php echo lcfirst($trimmed_item); ?>').prop( "disabled", true );

        var data = {
            @foreach($fields as $f)
            "{{ $f }}": $('#{{$f}}').val(),
            @endforeach

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
        //$('.create-<?php echo lcfirst($trimmed_item); ?>').prop( "disabled", false );
    }
</script>
<div class="modal fade" id="<?=$modal_id;?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $title }}</h4>
            </div>
            <div class="modal-body">
                @if (isset($flash_id))
                    <div id="{{ $flash_id }}" class="alert" style="display: none;"></div>
                @endif

                @if(isset($content))
                    <?php echo $content; ?>
                @endif

                @foreach($fields as $f)

                    @if (is_array($f))

                            <?php if (!array_key_exists('type', $f)) {
                                $f['type'] = 'text';
                            } ?>
                            @if(in_array($f['type'], ['text', 'url', 'date', 'datetime', 'time', 'email', 'number']))
                                <div class="input-group">
                                    <label for="{{ $f['name'] }}">{{ $f['label'] or ucfirst($f['name']) }}</label>
                                    <input class="form-control" id="{{ $f['name'] }}" <?php if(isset($f['value'])) { echo 'value="'. $f['value'] .'" '; } ?>type="{{ $f['type'] }}" placeholder="{{ $f['name'] }}" <?php if(isset($f['required']) && $f['required']) { echo 'required'; } ?> />
                                </div>
                            @elseif(in_array($f['type'], ['select']))
                                <div class="input-group">
                                    <label for="{{ $f['name'] }}">{{ $f['label'] or ucfirst($f['name']) }}</label>
                                    <select id="{{ $f['name'] }}" class="form-control">
                                        <?php $optionField = $f['field'];
                                        if (strpos($optionField, '.') !== false) {
                                            $optionFields = explode('.', $optionField);
                                        }
                                        ?>
                                        @foreach($f['options'] as $option)
                                            @if (method_exists($option, 'toOption'))
                                                <?php echo $option->toOption(); ?>
                                            @elseif (isset($optionFields))
                                                <option value="{{ $option->id }}">{{ $option->$optionFields[0]->$optionFields[1] }}</option>
                                            @else
                                                <option value="{{ $option->id }}">{{ $option->$optionField }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                    @else
                        <div class="input-group">
                            <label for="{{ $f }}">{{ $f }}</label>
                            <input class="form-control" id="{{ $f }}" type="text" placeholder="{{ $f }}" />
                        </div>
                    @endif

                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary create-{{ lcfirst($trimmed_item) }}" onclick="return create<?php echo ucfirst($trimmed_item); ?>();">Create {{ $item }}</button>
            </div>
        </div>
    </div>
</div>
