/**
 * VisualEditor user interface Frame class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UI Frame.
 *
 * @class
 * @constructor
 */

ve.ui.Frame = function VeUiFrame( config, $container ) {
	// Container must be in the dom already.
	if ( !config || !$container || $container.length === 0 ) {
		return;
	}

	var frame = this;

	// Create Iframe
	this.$frame = $( '<iframe frameborder="0" scrolling="no"></iframe>' )
		.appendTo ( $container );

	// Iframe document
	this.doc = this.$frame.prop( 'contentWindow' ).document;

	// Create an inner frame container ( x-browser iframe append )
	this.doc.write( '<div class="ve-ui-frame-container"></div>' );
	this.doc.close();

	// Iframe inner container
	// Append elements created in the Frame doc scope to instance.$
	this.$ = $( this.doc ).find( '.ve-ui-frame-container' );

	// Base dynamic iframe styles.
	$( 'body', this.doc ).css( {
		'padding': 0,
		'margin': 0
	} );

	// Add each stylesheet
	if ( 'stylesheets' in config ) {
		$.each( config.stylesheets, function( i, path ) {
			frame.loadStylesheet( path );
		} );
	}
};

ve.ui.Frame.prototype.loadStylesheet = function ( path ) {
	var $link =
		$( '<link>', this.doc )
			.attr( {
				'rel': 'stylesheet',
				'type': 'text/css',
				'media': 'screen',
				'href': path
			} );

	// Append style elements to head.
	$( this.doc ).find( 'head' )
		.append( $link );
};
