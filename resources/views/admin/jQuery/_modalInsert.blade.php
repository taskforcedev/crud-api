<?php // FORM ?>
<form id="addItem" style="display: none;" title="Add {{ $model }}">
    @foreach($fields as $f)
        <div class="input-group">
            <label for="{{ $f }}">{{ ucfirst($f) }}</label>
        @if (lcfirst($f) == "password")
            <input type="password" id="{{ lcfirst($f) }}" class="form-control" name="{{ $f }}" />
        @else
            <input type="text" id="{{ lcfirst($f) }}" class="form-control" name="{{ $f }}" />
        @endif
        </div>
    @endforeach
</form>


<?php // MODAL ?>
<script>
$(function() {
    var dialog, form,
        <?php // This next block assigns variables to the form inputs // ?>
        @foreach($fields as $f)
            {{ $f }} = $( "#{{ $f }}" ),
        @endforeach

        allFields = $( [] )
            <?php // Add all inputs to allFields // ?>
                @foreach($fields as $f)
                    .add( {{ $f }} )
                @endforeach
        ,
        tips = $( ".validateTips" );

    function addItem() {
        var valid = true;

        if ( valid ) {
            <?php // Assign variables for field values // ?>
            @foreach($fields as $f)
                var a{{ $f }} = {{ $f }}.val();
            @endforeach
            /* POST */
            jQuery.ajax({
                url: "{{ url('api/' . $model) }}",
                type: "POST",
                data: {
                    @foreach($fields as $f)
                        "{{ $f }}": a{{ $f }},
                    @endforeach
                    "_token": "{{ csrf_token() }}"
                },
                success: function (response) {
                    window.location.reload();
                },
                error: function (response) {
                    console.log(response);
                    console.log("failed");
                }
            });
        }
        return valid;
    }

    dialog = $( "#addItem" ).dialog({
        autoOpen: false,
        height: 400,
        width: 300,
        modal: true,
        buttons: {
            "Create": addItem,
            Cancel: function() {
                dialog.dialog( "close" );
            }
        },
        close: function() {
            if (form[0]) {
                form[ 0 ].reset();
            }
            allFields.removeClass( "ui-state-error" );
        }
    });

    // TODO : Edit Above This Line

    // Define the Dialog
    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        addItem();
    });

    // Add button click handler
    $( "#insert-{{ lcfirst($model) }}" ).button().on( "click", function() {
        dialog.dialog( "open" );
    });


});



</script>
