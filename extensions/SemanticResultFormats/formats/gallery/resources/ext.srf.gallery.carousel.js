/**
 * JavaScript for SRF Gallery jcarousel module
 * @see http://www.semantic-mediawiki.org/wiki/Help:Gallery format
 *
 * @since 1.8
 * @release 0.3
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( $, mw, srf ) {
	'use strict';

	/*global mediaWiki:true semanticFormats:true */
	/**
	 * Module for formats extensions
	 * @since 1.8
	 * @type Object
	 */
	srf.formats = srf.formats || {};

	/**
	 * Base constructor for objects representing a gallery instance
	 * @since 1.8
	 * @type Object
	 */
	srf.formats.gallery = function() {};

	srf.formats.gallery.prototype = {
		/**
		 *
		 * data-scroll Number of items to be scrolled
		 * data-visible Calculated and set visible elements
		 * data-wrap Options are "first", "last", "both" or "circular"
		 * data-vertical Whether the carousel appears in horizontal or vertical orientation
		 * data-rtl Directionality
		 *
		 * @since 1.8
		 * @type Object
		 */
		carousel: function( context ) {
			return context.each( function() {
				var $this = $( this ),
					carousel = $this.find( '.jcarousel' );

					util.spinner.hide( { context: $this } );

					carousel.each( function() {
						$( this ).show();
						$( this ).jcarousel( {
							scroll:  parseInt( $( this ).attr( 'data-scroll' ), 10 ),
							visible: parseInt( $( this ).attr( 'data-visible' ), 10 ),
							wrap: $( this ).attr( 'data-wrap' ),
							vertical: $( this ).attr( 'data-vertical' ) === 'true',
							rtl: $( this ).attr( 'data-rtl' ) === 'true'
						} );
					} );
			} );
		}
	};

	/**
	 * Implementation representing a gallery instance
	 * @since 1.8
	 * @type Object
	 */
	var gallery = new srf.formats.gallery();
	var util = new srf.util();

	$( document ).ready( function() {
		$( '.srf-gallery-carousel' ).each(function() {
			gallery.carousel( $( this ) );
		} );
	} );
} )( jQuery, mediaWiki, semanticFormats  );