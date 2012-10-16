/**
 * Module used to handle ads on wikiamobile
 * closing it and keeping it on the screen
 *
 * @define ads
 * @require events
 * @require domwriter
 * @require cookies
 *
 * @author Jakub Olek
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

/*global window, document, define, require, setTimeout, setInterval, clearInterval, Features, $, AdConfig*/
define('ads', ['events', 'domwriter', 'cookies', 'track'], function (ev, dw, ck, track) {
	'use strict';

	var AD_TYPES = {
			/**
			 * Allowed types of Ad,
			 * DART can invoke them but they need to be defined here first
			 */
			'footer': 'footer',
			'interstitial': 'interstitial'
		},
		STOP_COOKIE_NAME = 'wkStopAd',
		adSlot,
		adSlotStyle,
		contentWrapper,
		click = ev.click,
		close,
		d = document,
		found = false,
		fixed = false,
		ftr,
		inited,
		positionfixed = Features.positionfixed,
		type,
		w = window;

	/**
	 * @private
	 *
	 * @param {HTMLElement} el
	 * @param {Array} cls
	 */
	function addClass(el, cls) {
		el.className += ((el.className !== '') ? ' ' : '') + cls.join(' ');
	}

	/**
	 * @private
	 *
	 * @param {HTMLElement} el
	 * @param {Array} cls
	 */
	function removeClass(el, cls) {
		el.className = el.className
			.replace(new RegExp('\\b(?:' + cls.join('|') + ')\\b', 'g'), '')
			//trim is supported starting from IE9
			//and that's the least version on WP7
			.trim();
	}

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

	/**
	 * Sets up the slot, this function is called
	 * usually from an AdEngine provider
	 *
	 * @public
	 *
	 * @param {String} name The slot name
	 * @param {String} size The size of the slot (e.g. 5x5)
	 * @param {String} provider The provider name (e.g. DARTMobile)
	 */
	function setupSlot(name, size, provider) {
		if (shouldRequestAd() && AdConfig) {
			var url = AdConfig.DART.getMobileUrl(name, size, true, provider),
				s = d.createElement('script');

			if (contentWrapper) {
				//bind DOMwriter to the wrapper
				dw.target(contentWrapper);
				s.src = url;
				contentWrapper.appendChild(s);
			}
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
				var t;

				for (t in AD_TYPES) {
					if (AD_TYPES.hasOwnProperty(t)) {
						removeClass(adSlot, [AD_TYPES[t]]);
					}
				}
			}

			//used in other parts to check what kind of Ad we've been served
			type = adType;
			inited = true;
			addClass(adSlot, [adType]);

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
				(w.pageYOffset + w.innerHeight - 50 + ~~plus),
				ftr.offsetTop + 160
			) + 'px';
		}
	}

	/**
	 * Handles the positioning of the Ad either via CSS or JS
	 * to make it "float" on the viewport, the position and
	 * behaviour depends on the type of Ad
	 *
	 * @public
	 */
	function fix() {
		fixed = true;

		if (found) {
			addClass(adSlot, ['over']);

			if (type === AD_TYPES.footer) {
				//give the footer space to host the
				//"floating" footer Ad
				addClass(ftr, ['ads']);
				addClass(adSlot, ['fixed']);

				if (!positionfixed) {
					addClass(adSlot, ['jsfix']);
					moveSlot();
				}
			}
		}
	}

	/**
	 * Handles the positioning of the Ad either via CSS or JS
	 * to anchor it back in the original position before
	 * fix was called, the position and
	 * behaviour depends on the type of Ad
	 *
	 * @public
	 */
	function unfix() {
		if (found) {
			removeClass(adSlot, ['over']);

			if (type === AD_TYPES.footer) {
				//remove the extra space from the footer used
				//to host the "floating" footer Ad
				removeClass(ftr, ['ads']);
				removeClass(adSlot, ['fixed']);

				if (!positionfixed) {
					removeClass(adSlot, ['jsfix']);
					moveSlot(ftr.offsetTop);
				}
			}
		}

		//reset fixed after moveSlot has been called
		fixed = false;
	}

	/**
	 * Dismisses the Ad slot and its' contents
	 *
	 * @public
	 */
	function dismiss() {
		if (adSlot) {
			adSlot.parentNode.removeChild(adSlot);

			if (type === AD_TYPES.footer) {
				//remove the extra space from the footer used
				//to host the "floating" footer Ad
				removeClass(ftr, ['ads']);
			}

			type = close = adSlot = contentWrapper = adSlotStyle = undefined;
			found = fixed = inited = false;
		}
	}
	/**
	 * Tries to identify the Ad content and triggers the
	 * expected position/behaviour accordingly
	 *
	 * @private
	 */
	function findAd() {
		if (contentWrapper) {
			var i,
				imgs,
				width,
				height,
				x,
				y;

			//search for any real ad content
			//unfortunately some iframes can be empty
			//but we have no access to them
			if (contentWrapper.getElementsByTagName('iframe').length > 0 ||
					contentWrapper.getElementsByTagName('video').length > 0 ||
					contentWrapper.getElementsByTagName('object').length > 0 ||
					contentWrapper.getElementsByTagName('embed').length > 0) {
				found = true;
			}

			//despite the above check's result, run this anyways
			//as it also takes care of hiding tracking pixels
			if ((imgs = contentWrapper.getElementsByTagName('img')).length > 0) {
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
					close.addEventListener(click, function () {
						track.event('ad', track.CLICK, {label: 'close'});
						addClass(adSlot, ['anim']);

						setTimeout(function () {
							dismiss();
						}, 800);

						if (!positionfixed) {
							w.removeEventListener('scroll', moveSlot);
						}
					}, false);

					if (!positionfixed) {
						w.addEventListener('scroll', moveSlot);
					}
				}

				dw.removeEventListener('idle', findAd);
				addClass(adSlot, ['show']);
				fix();
			}
		}
	}

	/**
	 * Returns the type of the current Ad
	 *
	 * @public
	 *
	 * @return {String} The type of Ad, see the AD_TYPES variable;
	 * undefined if no Ad is being served
	 */
	function getAdType() {
		return type;
	}

	/**
	 * Module initialization
	 */

	window.addEventListener('DOMContentLoaded', function () {
		adSlot = d.getElementById('wkAdPlc');
		contentWrapper = d.getElementById('wkAdWrp');

		if (adSlot) {
			//bind findAd to when DOMwriter goes idle
			//DOMwriter is initialized in AdProviderDARTMobile.php
			//@see init
			dw.addEventListener('idle', findAd);

			adSlotStyle = adSlot.style;
			ftr = d.getElementById('wkFtr');
			close = d.getElementById('wkAdCls');
		}
	});

	//global shortcut to be used directly
	//inside DART creatives
	w.MobileAd = {
		setupSlot: setupSlot,
		init: init,
		fix: fix,
		unfix: unfix,
		getAdType: getAdType,
		dismiss: dismiss,
		shouldRequestAd: shouldRequestAd
	};

	return w.MobileAd;
});
