/**
 * Create 'show thumbnail' control, with optional tooltips.  works like the 'remove' control.
 */
( function ( $j ) { 
	$j.fn.showThumbCtrl = function( msgKey, tooltipMsgKey, callback ) {
		var msg = (msgKey === null) ? '' : gM( msgKey );
		return $j( '<div class="mwe-upwiz-show-thumb-ctrl ui-corner-all" />' )
			.attr( 'title', gM( tooltipMsgKey ) )
			.click( function() { $j( this ).removeClass( 'hover' ).addClass( 'disabled' ).unbind( 'mouseenter mouseover mouseleave mouseout mouseup mousedown' ); callback(); } )
			.hover( function() { $j( this ).addClass( 'hover' ); },
				function() { $j( this ).removeClass( 'hover' ); } )
			.append( $j( '<div class="ui-icon ui-icon-image" /><div class="mwe-upwiz-show-thumb-ctrl-msg">' + msg + '</div>' ) );
	};
} )( jQuery );
