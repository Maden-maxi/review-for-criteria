/*
(function($) {
    "use strict";
    $(function() {
        // Some code
        // alert(ajaxurl);
        $('#review_storage').keyup(function () {
            var $this = $(this);
            $.ajax({
                url: rfc_reviews.ajaxurl,
                method: 'POST',
                data: {
                    action: 'admin_get_storages_call',
                    security: rfc_reviews.security,
                    s: $(this).val()
                },
                success: function (data, textStatus, jqXHR) {
                    console.log(data, textStatus, jqXHR);
                    $( "#review_storage" ).autocomplete({
                        source: data.data,
                        focus: function( event, ui ) {
                            console.log(ui);
                            $this.val( ui.item.post_name );
                            return false;
                        },
                        select: function( event, ui ) {
                            console.log(ui);
                            $( "#review_storage" ).val( ui.item.post_name );
                            $( "#review_storage_id" ).val( ui.item.ID );

                            return false;
                        }
                    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
                        console.log('start', item);
                        return $( "<li>" )
                            .append( "<div>" + item.post_name + "<br>" + item.ID + "</div>" )
                            .appendTo( ul );
                    };
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        });
    });
}(jQuery));
*/


jQuery( function ($) {

    // create an jq-ui autocomplete on your selected element
    $( '#review_storage_label' ).autocomplete( {
        // use a function for its source, which will return ajax response
        source: function(request, response){

            // well use opts.ajax_url which we enqueued with WP
            $.post( rfc_reviews.ajaxurl, {
                    action: 'admin_get_storages_call',            // our action is called search
                    security: rfc_reviews.security,
                    s: request.term           // and we get the term com jq-ui
                ,
                }, function(data) {
                console.log(data);
                    // when we get data from ajax, we pass it onto jq-ui autocomplete
                    response(data.data);
                }, 'json'
            );
        },
        _renderItem: function( ul, item ) {
            console.log(item);
            return $( "<li>" )
                .attr( "data-value", item.ID )
                .append( item.post_title )
                .appendTo( ul );
        },
        // next, is the select behavioura
        // on select do your action
        select: function(evt, ui) {
            console.log(ui);
            $('#review_storage_value').val(ui.item.value);
            $('#review_storage_label').val(ui.item.label);
            evt.preventDefault();

            // here you can call another AJAX action to save the option
            // or whatever

        },
    } );

    $('#review_tabs').tabs({
        classes:{
            "ui-tabs": "ui-corner-all",
            "ui-tabs-nav": "ui-corner-all",
            "ui-tabs-tab": "ui-corner-top",
            "ui-tabs-panel": "ui-corner-bottom",
            "ui-tabs-active": "nav-tab-active"
        }
    });

} ( jQuery ) );