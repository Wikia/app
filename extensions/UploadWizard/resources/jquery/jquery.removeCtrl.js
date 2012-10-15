/**
 * Create 'remove' control, an X which highlights in some standardized way, with optional tooltips
 */
( function ( $j ) { 
	$j.fn.removeCtrl = function( msgKey, tooltipMsgKey, callback ) {
		var msg = (msgKey === null) ? '' : gM( msgKey );
		return $j( '<div class="mwe-upwiz-remove-ctrl ui-corner-all" />' )
			.attr( 'title', gM( tooltipMsgKey ) )
			.click( callback )
			.hover( function() { $j( this ).addClass( 'hover' ); },
				function() { $j( this ).removeClass( 'hover' ); } )
			.append( $j( '<div class="ui-icon ui-icon-close" /><div class="mwe-upwiz-remove-ctrl-msg">' + msg + '</div>' ) );
	};
} )( jQuery );
