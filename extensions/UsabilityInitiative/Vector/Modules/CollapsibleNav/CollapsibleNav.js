/* Prototype code to show collapsing left nav options */
/* First draft and will be changing greatly */

$j(document).ready( function() {
	if( !wgVectorEnabledModules.collapsiblenav ) {
		return true;
	}
	$j( '#mw-panel' ).addClass( 'collapsible-nav' );
	// Always show the first portal
	$j( '#mw-panel > div.portal:first' )
		.addClass( 'expanded' )
		.find( 'div.body' )
		.show();
	// Remember which portals to hide and show
	$j( '#mw-panel > div.portal:not(:first)' )
		.each( function() {
			if ( $j.cookie( 'vector-nav-' + $j(this).attr( 'id' ) ) == 'true' ) {
				$j(this)
					.addClass( 'expanded' )
					.find( 'div.body' )
					.show();
			} else {
				$j(this).addClass( 'collapsed' );
			}
		} );
	// Toggle the selected menu's class and expand or collapse the menu
	$j( '#mw-panel > div.portal > h5' ).click( function() {
		$j.cookie( 'vector-nav-' + $j(this).parent().attr( 'id' ), $j(this).parent().is( '.collapsed' ) );
		$j(this)
			.parent()
			.toggleClass( 'expanded' )
			.toggleClass( 'collapsed' )
			.find( 'div.body' )
			.slideToggle( 'fast' );
		return false;
	} );
} );
