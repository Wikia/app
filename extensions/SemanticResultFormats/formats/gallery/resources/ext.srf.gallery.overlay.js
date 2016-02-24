/**
 * JavaScript for SRF gallery overlay/fancybox module
 * @see http://www.semantic-mediawiki.org/wiki/Help:Gallery format
 *
 * There is a method ImageGallery->add which allows to override the
 * image url but this feature is only introduced in MW 1.20 therefore
 * we have to catch the "real" image location url from the api to be able
 * to display the image in the fancybox
 *
 * @since 1.8
 * @version 0.3
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
		overlay: function( context ) {
			return context.each( function() {
				var $this = $( this ),
					galleryID = $this.attr( 'id' ),
					srfPath = mw.config.get( 'srf.options' ).srfgScriptPath;

				// Loop over all relevant gallery items
				$this.find( '.gallerybox' ).each( function () {
					var $this = $( this ),
						h = mw.html,
						image = $this.find( 'a.image' ),
						imageText = $this.find( '.gallerytext p' ).html();

					// Group images
					image.attr( 'rel', image.has( 'img' ).length ? galleryID : '' );

					// Copy text information for image text display
					imageText = imageText !== null ? imageText :  image.find( 'img' ).attr( 'alt' );
					image.attr( 'title', imageText );

					// Avoid undefined error
					if ( image.attr( 'href' ) === undefined ) {
						$this.html( '<span class="error">' + mw.message( 'srf-gallery-image-url-error' ).escaped() + '</span>' );
					} else {

						// There should be a better way to find the title object but there isn't
						var title = image.attr( 'href' ).replace(/.+?\File:(.*)$/, "$1" ).replace( "%27", "\'" ),
							imageSource = image.attr( 'href' );

						// Prepare overlay icon placeholder
						image.before( h.element( 'a', { 'class': 'overlayicon', 'href': imageSource }, null ) );
						var overlay = $this.find( '.overlayicon' ).hide();

						// Add spinner while fetching the URL
						util.spinner.create( { context: $this, selector: 'img' } );

						// Re-assign image url
						util.getImageURL( { 'title': 'File:' + title },
							function( url ) { if ( url === false ) {
								image.attr( 'href', '' );
								// Release thumb image
								util.spinner.replace( { context: $this, selector: 'img' } );
							} else {
								image.attr( 'href', url );
								// Release thumb image
								util.spinner.replace( { context: $this, selector: 'img' } );
								// Release overlay icon
								overlay.show();
							}
						} );
					}
				} );

				// Formatting the title
				function formatTitle( title, currentArray, currentIndex /*,currentOpts*/ ) {
					return '<div class="srf-fancybox-title"><span class="button"><a href="javascript:;" onclick="$.fancybox.close();"><img src=' +  srfPath + '/resources/jquery.fancybox/closelabel.gif' + '></a></span>' + (title && title.length ? '<b>' + title : '' ) + '<span class="count"> (' +  mw.msg( 'srf-gallery-overlay-count', (currentIndex + 1) , currentArray.length ) + ')</span></div>';
				}

				// Display all images related to a group
				$this.find( "a[rel^=" + galleryID + "]" ).fancybox( {
					'showCloseButton' : false,
					'titlePosition'   : 'inside',
					'titleFormat'     : formatTitle
				} );
		} );
		}
	};

	/**
	 * Implementation representing a slideshow instance
	 * @since 1.8
	 * @type Object
	 */
	var gallery = new srf.formats.gallery();
	var util = new srf.util();

	$( document ).ready( function() {
		$( '.srf-overlay' ).each(function() {
			gallery.overlay( $( this ) );
		} );
	} );
} )( jQuery, mediaWiki, semanticFormats  );