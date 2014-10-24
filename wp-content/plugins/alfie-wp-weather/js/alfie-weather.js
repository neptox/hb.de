/*

 ============ appcuarium ============

 Alfie ® Platform JS SDK

 ====== Apps outside the box.® ======

 ------------------------------------
 Copyright © 2012-2014 Appcuarium
 ------------------------------------

 apps@appcuarium.com
 @author Sorin Gheata
 @version 1.2.13

 ====================================

 Alfie Weather Javascript Loader

 */

(function ($, window, document, undefined) {

    var $body = $('body');

    $body.on('click', '.city-woeid',function (e) {
        var woeid = $(this).attr('rel');
        $('#widgets-right .alfie-woeid').val(woeid);
        $('#widgets-right #cities').empty();
        $('#widgets-right #location-input').hide();
        $('#widgets-right .search_woeid').show();
        $('#widgets-right #search-location').val('');
        e.preventDefault();
    }).on('click', '.search_woeid.enabled', function (e) {

        var $me = $(this);
        $me.hide();
        $('#widgets-right #location-input').show();
        $me.alfie({
            action: {
                searchDelayed: function (response) {
                }
            }
        });

        e.preventDefault();
    });

    $( 'body' ).on('change', 'input[value="manual_location"]', function(){

        $('input[value="automatic_location"]' ).attr('checked', false );
        make_editable( $(this) );

    });

    $('body' ).on('change', 'input[value="automatic_location"]', function(){

        $('input[value="manual_location"]' ).attr('checked', false );
        make_read_only( $(this));

    });

    function make_read_only( element ) {
        element.parent().next().find('input' ).each(function(){
            $(this).attr('readonly', true);
        });

        element.parent().next().find('.search_woeid' ).removeClass('enabled' ).addClass('disabled');

    }

    function make_editable( element ) {

        element.parent().next().find('input' ).each(function(){
            $(this).attr('readonly', false);
        });

        element.parent().next().find('.search_woeid' ).removeClass('disabled' ).addClass('enabled');
    }

    $( function(){
        $('input[value="manual_location"]' ).each( function(){
            var $me = $( this );

            if ( $me.attr('checked') == 'checked' ) {
                make_editable( $me );
            }
        });

        $('input[value="automatic_location"]' ).each( function(){
            var $me = $( this );

            if ( $me.attr('checked') == 'checked' ) {
                make_read_only( $me );
            }
        });
    });
})(jQuery, window, document);