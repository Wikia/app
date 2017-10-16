/**
 * JavaScript for SRF gallery slides module
 * @see http://www.semantic-mediawiki.org/wiki/Help:Gallery format
 *
 * @since 1.8
 * @release 0.2
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
		slideshow: function( context ) {
			return context.each( function() {
				var $this = $( this );
				var maxHeight = 0;
				var gallery   = $this.find( 'ul' );
				var galleryId = "#" + gallery.attr( 'id' );
				var previous  = $this.prev( 'p' ).children( 'br' );

				// The gallery parser comes with a preceding empty <p> element
				// this is a work-around to avoid
				if ( previous.length == 1 ) {
					previous.hide();
				}

				// Make elements visible / hide
				util.spinner.hide( { context: $this } );
				gallery.show();

				// Loop over all the gallery items
				gallery.find( 'li' ).each( function () {

					// Text elements can vary in there height therefore determine max height
					// for all images used in the same instance
					if($(this).height() > maxHeight ) {
						maxHeight = $( this ).height();
					}
				} );

				// Set max height in order for all elements to be positioned equally
				gallery.height( maxHeight );

				if( !gallery.responsiveSlides({
					pauseControls: gallery.attr( 'data-nav-control' ) === 'auto',
					prevText: mw.msg( 'srf-gallery-navigation-previous' ),
					nextText: mw.msg( 'srf-gallery-navigation-next' ),
					auto:  gallery.attr( 'data-nav-control' ) === 'auto',
					pause: gallery.attr( 'data-nav-control' ) === 'auto',
					pager: gallery.attr( 'data-nav-control' ) === 'pager',
					nav:   gallery.attr( 'data-nav-control' ) === 'nav'
				} ) ) {
					// something went wrong, hide the canvas container
					$this.find( galleryId ).hide();
				}
		} );
		}
	};

	/**
	 * Implementation and representation of the gallery instance
	 * @since 1.8
	 * @type Object
	 */
	var gallery = new srf.formats.gallery();
	var util = new srf.util();

	$( document ).ready( function() {
		$( '.srf-gallery-slideshow' ).each(function() {
			gallery.slideshow( $( this ) );
		} );
	} );
} )( jQuery, mediaWiki, semanticFormats );