/**
 * Module used to handle ads on wikiamobile
 * closing it and keeping it on the screen
 *
 * @define ads
 * @require events
 * @require ext.wikia.adEngine.wikiaDartMobileHelper
 * @require domwriter
 * @require cookies
 *
 * @author Jakub Olek
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

/*global window, document, define, require, setTimeout, setInterval, clearInterval, Features, AdConfig*/
define('ads', ['wikia.cookies', 'wikia.window', 'ext.wikia.adEngine.wikiaDartMobileHelper', 'wikia.scriptwriter'], function (ck, window, dartHelper, scriptWriter) {
	'use strict';

	var STOP_COOKIE_NAME = 'wkStopAd',
		ID_COOKIE_NAME = 'wikia_mobile_id';

	/**
	 * Stops ads requests from being made for a specific amount of time
	 *
	 * @private
	 *
	 * @param {Number} time An amount of time in seconds, bigger than 0
	 */
	function stop(time) {
		ck.set(STOP_COOKIE_NAME, 1, {expires: time * 1000});
	}

	function shouldRequestAd() {
		return (~~(ck.get(STOP_COOKIE_NAME))) !== 1;
	}

	function getUniqueId() {
		var wikiaMobileId = ck.get(ID_COOKIE_NAME);

		if (!wikiaMobileId) {
			wikiaMobileId = Math.round(Math.random() * 23456787654);

			ck.set(ID_COOKIE_NAME, wikiaMobileId, {
				expires: 1000*60*60*24*180, // 3 months
				path: window.wgCookiePath,
				domain: window.wgCookieDomain
			});
		}

		return wikiaMobileId;
	}

	/**
	 * Sets up the slot, this function is called
	 * usually from an AdEngine provider
	 *
	 * @public
	 *
	 * @param {Object} options options to be passed to dart helper
	 * 		name - name of ad slot
	 * 		size - size of the ad slot
	 * 		wrapper - html element
	 * 		init - function to be called
	 */
	function setupSlot( options ) {
		if ( shouldRequestAd() ) {
			scriptWriter.injectScriptByUrl(
				options.wrapper,
				dartHelper.getMobileUrl({
					slotname: options.name,
					size: options.size,
					uniqueId: getUniqueId()
				}),
				findAd( options.wrapper, options.init )
			);
		}
	}

	/**
	 * Tries to identify the Ad content and triggers the
	 * expected position/behaviour accordingly
	 *
	 * @private
	 *
	 * @return function - callback for postscribe
	 */
	function findAd( wrapper, init ) {
		return function(){
			if ( wrapper ) {
				var i,
					imgs,
					width,
					height,
					x,
					y;

				//search for any real ad content
				//unfortunately some iframes can be empty
				//but we have no access to them
				var found = (wrapper.getElementsByTagName( 'iframe' ).length > 0 ||
					wrapper.getElementsByTagName( 'video' ).length > 0 ||
					wrapper.getElementsByTagName( 'object' ).length > 0 ||
					wrapper.getElementsByTagName( 'embed' ).length > 0 ||
					wrapper.querySelector( 'script[src*="/ads.saymedia.com/"]' ) ||
					wrapper.querySelector( 'script[src*="/native.sharethrough.com/"]' ) ||
					wrapper.querySelector( 'script[src$="/mmadlib.js"]' ) ||
					wrapper.getElementsByClassName( 'celtra-ad-v3' ).length > 0);

				//despite the above check's result, run this anyways
				//as it also takes care of hiding tracking pixels
				if ( ( imgs = wrapper.getElementsByTagName( 'img' ) ).length > 0 ) {
					for (x = 0, y = imgs.length; x < y; x += 1) {
						i = imgs[x];
						width = i.getAttribute( 'width' );
						height = i.getAttribute( 'height' );

						//try calculating the size if there were no attributes
						//this is expensive, so attributes were checked first
						if ( !width ) {
							width = i.clientWidth;
						}

						if ( !height ) {
							height = i.clientHeight;
						}

						if ( width > 1 && height > 1 ) {
							//if image is not a tracking pixel
							found = true;
							break;
						} else {
							//hide tracking pixels, sometimes
							//they're not set this way and
							//inflate the size of the slot
							i.style.display = 'none';
						}
					}
				}

				if( typeof init == 'function' ) {
					init( found )
				}
			}
		}
	}

	//global shortcut to be used directly
	//inside DART creatives
	//it also return it for AMD modules
	return window.MobileAd = {
		setupSlot: setupSlot,
		shouldRequestAd: shouldRequestAd,
		init: function(name, options){
			if( options && options.hasOwnProperty( 'stop' ) ){
				stop( options.stop );
			}
		},
		stop: stop
	};
});
