/*
 * Expandable search for Vector
 */
jQuery( document ).ready( function( $ ) {
	
	/* Browser Support */

	var map = {
		// Left-to-right languages
		'ltr': {
			// Collapsible Nav is broken in Opera < 9.6 and Konqueror < 4
			'msie': [['>=', 8]],
			'blackberry': false,
			'ipod': false,
			'iphone': false,
			'ps3': false
		},
		// Right-to-left languages
		'rtl': {
			'msie': [['>=', 8]],
			'blackberry': false,
			'ipod': false,
			'iphone': false,
			'ps3': false
		}
	};
	if ( !$.client.test( map ) ) {
		return true;
	}
	
	$( '#searchInput' )
		.expandableField( { 
			'beforeExpand': function( context ) {
				// animate the containers border
				$( this )
					.parent()
					.animate( {
						'borderTopColor': '#a0d8ff',
						'borderLeftColor': '#a0d8ff',
						'borderRightColor': '#a0d8ff',
						'borderBottomColor': '#a0d8ff' }, 'fast' );
			},
			'beforeCondense': function( context ) {
				// animate the containers border
				$( this )
					.parent()
					.animate( {
						'borderTopColor': '#aaaaaa',
						'borderLeftColor': '#aaaaaa',
						'borderRightColor': '#aaaaaa',
						'borderBottomColor': '#aaaaaa' }, 'fast' );
			},
			'afterExpand': function( context ) {
				//trigger the collapsible tabs resize handler
				if ( typeof $.collapsibleTabs != 'undefined' ){
					$.collapsibleTabs.handleResize();
				}
			},
			'afterCondense': function( context ) {
				//trigger the collapsible tabs resize handler
				if ( typeof $.collapsibleTabs != 'undefined' ){
					$.collapsibleTabs.handleResize();
				}
			},
			'expandToLeft': ! $( 'body' ).is( '.rtl' )
		} )
		.css( 'float', $( 'body' ).is( '.rtl' ) ? 'right' : 'left' )
		.siblings( 'button' )
		.css( 'float', $( 'body' ).is( '.rtl' ) ? 'right' : 'left' );
} );
