/**
 * Module used to handle ads on wikiamobile
 * closing it and keeping it on the screen
 *
 * @define ads
 * @require events
 * @require dartmobilehelper
 * @require domwriter
 * @require cookies
 * @require track
 * @require log
 *
 * @author Jakub Olek
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

/*global window, document, define, require, setTimeout, setInterval, clearInterval, Features, AdConfig*/
define('ads', ['domwriter', 'wikia.cookies', 'track', 'wikia.log', 'wikia.window', 'wikia.utils', 'wikia.dartmobilehelper'], function (dw, ck, track, log, window, $, dartHelper) {
	'use strict';

	var AD_TYPES = {
			/**
			 * Allowed types of Ad,
			 * DART can invoke them but they need to be defined here first
			 */
			footer: 1,
			interstitial: 1,
			top_leaderboard: 1,
			in_content: 1
		},
		STOP_COOKIE_NAME = 'wkStopAd',
		adSlots,
		d = window.document,
		found = false,
		fixed = false;

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
		var wikia_mobile_id = ck.get('wikia_mobile_id');
		if (!wikia_mobile_id) {
			wikia_mobile_id = Math.round(Math.random() * 23456787654);
			ck.set('wikia_mobile_id', wikia_mobile_id, {
				expires: 1000*60*60*24*180, // 3 months
				path: window.wgCookiePath,
				domain: window.wgCookieDomain
			});
		}
		return wikia_mobile_id;
	}

	/**
	 * Sets up the slot, this function is called
	 * usually from an AdEngine provider
	 *
	 * @public
	 *
	 * @param {String} name The slot name
	 * @param {String} size The size of the slot (e.g. 5x5)
	 */
	function setupSlot(options) {

		if (shouldRequestAd()) {
			var url = dartHelper.getMobileUrl({
					slotname: options.name,
					size: options.size,
					uniqueId: getUniqueId()
				}),
				s = d.createElement('script');

			adSlots[options.name] = options.wrapper;

			//bind DOMwriter to the wrapper
			dw.target(options.wrapper);
			s.src = url;
			options.wrapper.appendChild(s);

			dw.addEventListener('idle', findAd);
		}
	}

	/**
	 * Intitializes the Ad slot, this is called from a DART-hosted script usually
	 *
	 * @public
	 *
	 * @param {String} adType The type of ad, at the moment only 'footer' is supported
	 */
	function init(adType, options) {
		//just do the necessary setup
		//binding findAd to domwriter's
		//idle event will do the rest,
		//no more need for timers & co :)
		if (adSlot && AD_TYPES.hasOwnProperty(adType)) {
			//if the slot was already initialized once
			//then do some cleanup
			if (inited) {
				for (var t in AD_TYPES) {
					if (AD_TYPES.hasOwnProperty(t)) {
						$.removeClass(adSlot, [AD_TYPES[t]]);
					}
				}
			}

			//used in other parts to check what kind of Ad we've been served
			type = adType;
			inited = true;
			$.addClass(adSlot, [adType]);

			//process any option passed in
			if (options) {
				//option to stop showing ads for X seconds
				if (typeof options.stop === 'number') {
					stop(options.stop);
				}

				//more options checks should go here
			}
		}
	}

	/**
	 * Moves the slot at the bottom of the viewport
	 * used when Modernizr.positionfixed is false
	 * and we need to take care of emulating it in JS
	 * (iOS < 5 and Android < 3)
	 *
	 * @param {mixed} plus An offset to consider when calculating the position
	 *
	 * @private
	 */
	function moveSlot(plus) {
		if (fixed) {
			adSlotStyle.top = Math.min(
				(window.pageYOffset + window.innerHeight - 50 + ~~plus),
				ftr.offsetTop + 160
			) + 'px';
		}
	}



	/**
	 * Tries to identify the Ad content and triggers the
	 * expected position/behaviour accordingly
	 *
	 * @private
	 */
	function findAd(wrapper) {
		if (wrapper) {
			var i,
				imgs,
				width,
				height,
				x,
				y;

			//search for any real ad content
			//unfortunately some iframes can be empty
			//but we have no access to them
			found = (wrapper.getElementsByTagName('iframe').length > 0 ||
				wrapper.getElementsByTagName('video').length > 0 ||
				wrapper.getElementsByTagName('object').length > 0 ||
				wrapper.getElementsByTagName('embed').length > 0);

			//despite the above check's result, run this anyways
			//as it also takes care of hiding tracking pixels
			if ((imgs = wrapper.getElementsByTagName('img')).length > 0) {
				for (x = 0, y = imgs.length; x < y; x += 1) {
					i = imgs[x];
					width = i.getAttribute('width');
					height = i.getAttribute('height');

					//try calculating the size if there were no attributes
					//this is expensive, so attributes were checked first
					if (!width) {
						width = i.clientWidth;
					}

					if (!height) {
						height = i.clientHeight;
					}

					if (width > 1 && height > 1) {
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

			if (found) {
				//if the slot was not initialized and Ads where found
				//then force the default, i.e. a footer Ad
				if (!inited) {
					init('footer');
				}

				if (type === AD_TYPES.footer) {
					if (!positionfixed) {
						window.addEventListener('scroll', moveSlot);
					}
				}

				dw.removeEventListener('idle', findAd);
				$.addClass(adSlot, ['show']);
				fix();
			}
		}
	}

	/**
	 * Module initialization
	 */
	$(function () {
//		adSlot = d.getElementsByClassName('wkAdPlc');
//
//		if (adSlot) {
//			//bind findAd to when DOMwriter goes idle
//			//DOMwriter is initialized in AdProviderDARTMobile.php
//			//@see init
//			dw.addEventListener('idle', findAd);
//		}
	});

	//global shortcut to be used directly
	//inside DART creatives
	window.MobileAd = {
		setupSlot: setupSlot,
		fix: fix,
		unfix: unfix,
		shouldRequestAd: shouldRequestAd
	};

	return window.MobileAd;
});
