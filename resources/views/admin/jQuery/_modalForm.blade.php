<?php // FORM ?>
<form id="addItem" style="display: none;" title="Add {{ $model }}">
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
    @foreach($fields as $f)
        <label for="{{ $f }}">{{ ucfirst($f) }}</label>

        @if (lcfirst($f) == "password")
            <input type="password" id="{{ lcfirst($f) }}" name="{{ $f }}" />
        @else
            <input type="text" id="{{ lcfirst($f) }}" name="{{ $f }}" />
        @endif
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