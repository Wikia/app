/**
 * JavaScript for SRF gallery overlay/fancybox module
 * @see http://www.semantic-mediawiki.org/wiki/Help:Gallery format
 *
 * There is a method ImageGallery->add which allows to override the
 * image url but this feature is only introduced in MW 1.20 therefore
 * we have to catch the "real" image location url from the api
 *
 * @since 1.8
 * @version 0.4
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
		redirect: function( context ) {
			var type = context.data( 'redirect-type' );
			return context.find( '.gallerybox' ).each( function() {
				var $this = $( this ),
					h = mw.html,
					image = $this.find( 'a.image' );

				// Avoid undefined error
				if ( image.attr( 'href' ) === undefined ) {
					$this.html( h.element( 'span', { 'class': 'error' }, mw.message( 'srf-gallery-image-url-error' ).escaped() ) );
				} else {

					// Per convention "alt" attribute contains the redirect title
					var titleAlt = image.find( 'img' ).attr( 'alt' ),
						titleStatus = titleAlt !== undefined && titleAlt.length > 0,
						imageSource = image.attr( 'href' );

					// Prepare and hide the redirect icon placeholder
					image.before( h.element( 'a', { 'class': 'redirecticon', 'href': imageSource }, null ) );
					var redirect = $this.find( '.redirecticon' ).hide();

					if ( type === '_uri' && titleStatus ) {
						// Direct assign redirect url
						image.attr( 'href', titleAlt );
						redirect.show();
					} else if ( titleStatus ) {
						// Assign redirect article url
						// Show image spinner while fetching the URL
						util.spinner.create( { context: $this, selector: 'img' } );

						util.getTitleURL( { 'title': titleAlt },
							function( url ) { if ( url === false ) {
								image.attr( 'href', '' );
								// Release thumb image
								util.spinner.replace( { context: $this, selector: 'img' } );
							} else {
								image.attr( 'href', url );
								// Release thumb image
								util.spinner.replace( { context: $this, selector: 'img' } );
								// Release redirect icon
								redirect.show();
							}
						} );
					}
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
		$( '.srf-redirect' ).each(function() {
			gallery.redirect( $( this ) );
		} );
	} );
} )( jQuery, mediaWiki, semanticFormats );