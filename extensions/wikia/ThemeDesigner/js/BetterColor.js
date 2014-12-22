'use strict';
var BetterColor = (function () {
    function BetterColor() {}

    BetterColor.init = function () {
        var $fix = $('');

        // Find elements to fix
        $( '#mw-content-text *' ).each( function ( i, el ) {
            var style = $( this ).attr( 'style' ),
                styles = [],
                properties = [];

            if (style) {
                styles = style.split( ';' );
                $.each( styles, function( index, value ) {
                    properties.push( value.trim().split( ':' )[0] );
                } );
                if ( properties.indexOf( 'background-color' ) !== -1 && properties.indexOf( 'color' ) === -1 ) {
                    $fix = $fix.add( el );
                }
            }
        });

        if ( $fix.length ) {
            $fix.css( 'color', 'black' );
        }
    }

    return BetterColor;
})();

//$( BetterColor.init );
