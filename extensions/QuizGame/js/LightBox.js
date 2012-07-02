/*
	Lightbox JS: Fullsize Image Overlays
	by Lokesh Dhakar - http://www.huddletogether.com
	For more information on this script, visit:
	http://huddletogether.com/projects/lightbox/
	Licensed under the Creative Commons Attribution 2.5 License - http://creativecommons.org/licenses/by/2.5/
	(basically, do anything you want, just leave my name and link)
	Stripped this down a bit - Ashish
	Rewritten to be more object-oriented by Jack Phoenix <jack@countervandalism.net>
	on 21 June 2011
	This is a copy of the LightBox.js that resides in /extensions/PollNY/ with
	some minor modifications (look for the word "added")
*/
var LightBox = {
	/**
	 * Core code from quirksmode.org
	 * @return Array with x,y page scroll values.
	 */
	getPageScroll: function() {
		var yScroll;

		if ( self.pageYOffset ) {
			yScroll = self.pageYOffset;
		} else if ( document.documentElement && document.documentElement.scrollTop ) { // Explorer 6 Strict
			yScroll = document.documentElement.scrollTop;
		} else if ( document.body ) { // all other Explorers
			yScroll = document.body.scrollTop;
		}

		var arrayPageScroll = new Array( '', yScroll );
		return arrayPageScroll;
	},

	/**
	 * Core code from quirksmode.org
	 * Edit for Firefox by pHaez
	 * @return Array with page width, height and window width, height
	 */
	getPageSize: function() {
		var xScroll, yScroll;

		if ( window.innerHeight && window.scrollMaxY ) {
			xScroll = document.body.scrollWidth;
			yScroll = window.innerHeight + window.scrollMaxY;
		} else if ( document.body.scrollHeight > document.body.offsetHeight ) { // all but Explorer Mac
			xScroll = document.body.scrollWidth;
			yScroll = document.body.scrollHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
			yScroll = document.body.offsetHeight;
		}

		var windowWidth, windowHeight;
		if ( self.innerHeight ) { // all except Explorer
			windowWidth = self.innerWidth;
			windowHeight = self.innerHeight;
		} else if ( document.documentElement && document.documentElement.clientHeight ) { // Explorer 6 Strict Mode
			windowWidth = document.documentElement.clientWidth;
			windowHeight = document.documentElement.clientHeight;
		} else if ( document.body ) { // other Explorers
			windowWidth = document.body.clientWidth;
			windowHeight = document.body.clientHeight;
		}

		// for small pages with total height less then height of the viewport
		var pageHeight, pageWidth;
		if( yScroll < windowHeight ) {
			pageHeight = windowHeight;
		} else {
			pageHeight = yScroll;
		}

		// for small pages with total width less then width of the viewport
		if( xScroll < windowWidth ) {
			pageWidth = windowWidth;
		} else {
			pageWidth = xScroll;
		}

		var arrayPageSize = new Array( pageWidth, pageHeight, windowWidth, windowHeight );
		return arrayPageSize;
	},

	/**
	 * Pauses code execution for specified time. Uses busy code, not good.
	 * Code from http://www.faqts.com/knowledge_base/view.phtml/aid/1602
	 */
	pause: function( numberMillis ) {
		var now = new Date();
		var exitTime = now.getTime() + numberMillis;
		while ( true ) {
			now = new Date();
			if ( now.getTime() > exitTime ) {
				return;
			}
		}
	},

	/**
	 * Preloads images. Places new image in lightbox then centers and displays.
	 */
	show: function( objLink ) {
		// prepare objects
		var objOverlay = document.getElementById( 'overlay' );
		var objLightbox = document.getElementById( 'lightbox' );
		var objImage = document.getElementById( 'lightboxImage' );
		var objLightboxText = document.getElementById( 'lightboxText' );

		var arrayPageSize = LightBox.getPageSize();
		var arrayPageScroll = LightBox.getPageScroll();

		objLightboxText.style.display = 'none';
		// set height of Overlay to take up whole page and show
		objOverlay.style.height = ( arrayPageSize[1] + 'px' );
		objOverlay.style.display = 'block';

		// preload image
		var imgPreload = new Image();

		imgPreload.onload = function() {
			objImage.src = objLink.href;

			// center lightbox and make sure that the top and left values are not negative
			// and the image placed outside the viewport
			var lightboxTop = arrayPageScroll[1] + ( ( arrayPageSize[3] - 35 - imgPreload.height ) / 2 );
			var lightboxLeft = ( ( arrayPageSize[0] - 20 - imgPreload.width ) / 2 );

			//objLightbox.style.top = ( lightboxTop < 0 ) ? '0px' : lightboxTop + 'px';
			//objLightbox.style.left = ( lightboxLeft < 0 ) ? '0px' : lightboxLeft + 'px';

			// A small pause between the image loading and displaying is required with IE,
			// this prevents the previous image displaying for a short burst causing flicker.
			if ( navigator.appVersion.indexOf( 'MSIE' ) != -1 ) {
				LightBox.pause( 250 );
			}

			// Hide select boxes as they will 'peek' through the image in IE
			var selects = document.getElementsByTagName( 'select' );

			for ( var i = 0; i != selects.length; i++ ) {
				selects[i].style.visibility = 'hidden';
			}

			objLightbox.style.display = 'block';
			objImage.style.display = 'block';

			// After image is loaded, update the overlay height as the new image might have
			// increased the overall page height.
			arrayPageSize = LightBox.getPageSize();
			objOverlay.style.height = ( arrayPageSize[1] + 'px' );

			this.onload = function() { return; };
		};

		imgPreload.src = objLink.href;
	},

	hide: function() {
		// get objects
		var objOverlay = document.getElementById( 'overlay' );
		var objLightbox = document.getElementById( 'lightbox' );
		var objLightBoxImg = document.getElementById( 'lightboxImage' );

		// hide lightbox and overlay
		objOverlay.style.display = 'none';
		objLightbox.style.display = 'none';

		objLightBoxImg.style.display = 'none';

		// make select boxes visible
		var selects = document.getElementsByTagName( 'select' );
		for ( var i = 0; i != selects.length; i++ ) {
			selects[i].style.visibility = 'visible';
		}

		// disable keypress listener
		document.onkeypress = '';
	},

	/**
	 * Function runs on window load, going through link tags looking for rel="lightbox".
	 * These links receive onclick events that enable the lightbox display for their targets.
	 * The function also inserts html markup at the top of the page which will be used as a
	 * container for the overlay pattern and the inline image.
	 */
	init: function() {
		if ( !document.getElementsByTagName ) {
			return;
		}

		var objBody = document.getElementsByTagName( 'body' ).item( 0 );

		// create overlay div and hardcode some functional styles
		// (aesthetic styles are in CSS file)
		var objOverlay = document.createElement( 'div' );
		objOverlay.setAttribute( 'id', 'overlay' );
		objOverlay.onclick = function() {
			LightBox.hide();
			return false;
		};
		objOverlay.style.display = 'none';
		objOverlay.style.position = 'absolute';
		objOverlay.style.top = '0';
		objOverlay.style.left = '0';
		objOverlay.style.zIndex = '90';
		objOverlay.style.width = '100%';
		objBody.insertBefore( objOverlay, objBody.firstChild );

		var arrayPageSize = LightBox.getPageSize();
		var arrayPageScroll = LightBox.getPageScroll();

		// preload and create loader image
		var imgPreloader = new Image();

		// create lightbox div, same note about styles as above
		var objLightbox = document.createElement( 'div' );
		objLightbox.setAttribute( 'id', 'lightbox' );
		objLightbox.style.display = 'none';
		objLightbox.style.position = 'absolute';
		objLightbox.style.zIndex = '100';
		objBody.insertBefore( objLightbox, objOverlay.nextSibling );

		// create lightbox div, same note about styles as above
		var objLightboxText = document.createElement( 'div' );
		objLightboxText.setAttribute( 'id', 'lightboxText' );
		objLightboxText.style.display = 'none';
		objLightboxText.style.zIndex = '100';
		objLightboxText.style.textAlign = 'center';
		objLightbox.appendChild( objLightboxText );

		// create image
		var objImage = document.createElement( 'img' );
		objImage.setAttribute( 'id', 'lightboxImage' );
		objImage.style.display = 'none';
		objLightbox.appendChild( objImage );
	},

	setText: function( message ) {
		// prep objects
		var objOverlay = document.getElementById( 'overlay' );
		var objLightbox = document.getElementById( 'lightbox' );
		var objImage = document.getElementById( 'lightboxImage' );
		var objLightboxText = document.getElementById( 'lightboxText' );

		var arrayPageSize = LightBox.getPageSize();
		var arrayPageScroll = LightBox.getPageScroll();

		objImage.style.display = 'none';
		objLightboxText.style.opacity = 0.01; // added
		objLightbox.style.display = 'block';
		objLightboxText.style.display = 'block';
		objLightboxText.innerHTML = message;

		// center lightbox and make sure that the top and left values are not negative
		// and the image placed outside the viewport
		var dimensionsObj = LightBox.getDimensions( objLightboxText );
		var lightboxTop = arrayPageScroll[1] + ( ( arrayPageSize[3] - 35 - dimensionsObj.height ) / 2 );
		var lightboxLeft = ( ( arrayPageSize[0] - 20 - dimensionsObj.width ) / 2 );

		objLightbox.style.top = ( lightboxTop < 0 ) ? '0px' : lightboxTop + 'px';
		objLightbox.style.left = ( lightboxLeft < 0 ) ? '0px' : lightboxLeft + 'px';
		objLightboxText.style.opacity = 1.00; // added
	},

	/**
	 * This function is from the YUI library.
	 *
	 * @param element The element whose width and height we want to get
	 * @return Array
	 */
	getDimensions: function( element ) {
		var display = element.style.display;

		if ( display != 'none' && display !== null ) { // Safari bug
			return {width: element.offsetWidth, height: element.offsetHeight};
		}

		// All *Width and *Height properties give 0 on elements with display none,
		// so enable the element temporarily
		var els = element.style;
		var originalVisibility = els.visibility;
		var originalPosition = els.position;
		var originalDisplay = els.display;
		els.visibility = 'hidden';
		els.position = 'absolute';
		els.display = 'block';

		var originalWidth = element.clientWidth;
		var originalHeight = element.clientHeight;
		els.display = originalDisplay;
		els.position = originalPosition;
		els.visibility = originalVisibility;

		return {width: originalWidth, height: originalHeight};
	}
};

// added
if ( typeof( $ ) == 'function' ) {
	$( LightBox.init );
}