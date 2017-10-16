/**
 * @define lazyload
 *
 * Image lazy loading
 */
/*global define*/
define( 'lazyload', ['wikia.thumbnailer', 'jquery', 'wikia.window'], function ( thumbnailer, $, window ) {
	'use strict';

	var d = document,
		pageContent = (d.getElementById( 'mw-content-text' ) || d.getElementById( 'wkMainCnt' )),
		pageWidth = pageContent.offsetWidth;

	window.addEventListener( 'viewportsize', function ( ev ) {
		pageWidth = pageContent.offsetWidth;
	} );

	function onLoad ( img, background ) {
		return function () {
			var url = this.src;
			img.className += ' load';

			setTimeout( function () {
				displayImage( img, url, background );
			}, 250 );
		};
	}

	function displayImage ( img, url, background ) {
		if ( background ) {
			img.style.backgroundImage = 'url(' + url + ')';
		} else {
			img.src = url;
		}

		img.className += ' loaded';
	}

	function lazyload ( elements, background ) {
		var i = 0,
			elm,
			img,
			src;

		elements = $.makeArray( elements );

		while ( elm = elements[i++] ) {
			img = new window.Image();
			src = elm.getAttribute( 'data-src' );

			if ( src ) {
				if ( elm.className.indexOf( 'getThumb' ) > -1 && !thumbnailer.isThumbUrl( src ) ) {
					src = thumbnailer.getThumbURL( src, 'nocrop', 660, 330 );
				}

				img.src = src;

				//don't do any animation if image is already loaded
				if ( img.complete ) {
					displayImage( elm, src, background );
				} else {
					img.onload = onLoad( elm, background );
				}
			}
		}
	}

	lazyload.fixSizes = function ( elements ) {
		var i = 0,
			elm,
			imageWidth;

		elements = $.makeArray( elements );

		while ( elm = elements[i++] ) {
			imageWidth = ~~elm.getAttribute( 'width' );

			if ( pageWidth < imageWidth ) {
				elm.setAttribute( 'height', Math.round( elm.width * ( ~~elm.getAttribute( 'height' ) / imageWidth) ) );
			}
		}
	};

	return lazyload;
} );
