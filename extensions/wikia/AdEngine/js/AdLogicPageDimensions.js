/*jshint camelcase:false, maxdepth:4*/
/*global define*/
define('ext.wikia.adEngine.adLogicPageDimensions', [
	'ext.wikia.adEngine.slotTweaker',
	'wikia.document',
	'wikia.log',
	'wikia.throttle',
	'wikia.window'
], function (slotTweaker, doc, log, throttle, win) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adLogicPageDimensions',
		initCalled = false,
		wrappedAds = {},

		/**
		 * Slots based on screen width for responsive design
		 *
		 * @see skins/oasis/css/core/responsive-variables.scss
		 * @see skins/oasis/css/core/responsive-background.scss
		 */
		slotsToHideOnMediaQuery = {
			TOP_RIGHT_BOXAD:         'oneColumn',
			INCONTENT_BOXAD_1:       'oneColumn'
		},
		mediaQueriesToCheck = {
			twoColumns: 'screen and (min-width: 1024px)',
			oneColumn: 'screen and (max-width: 1023px)',
			noTopButton: 'screen and (max-width: 1063px)',
		},
		mediaQueriesMet,
		matchMedia;

	function matchMediaMoz(query) {
		return win.matchMedia(query).matches;
	}

	function matchMediaIe(query) {
		return win.styleMedia.matchMedium(query);
	}

	// Chose proper implementation of machMedia
	matchMedia = win.matchMedia && matchMediaMoz;
	matchMedia = matchMedia || (win.styleMedia && win.styleMedia.matchMedium && matchMediaIe);
	matchMedia = matchMedia || (win.media && win.media.matchMedium);

	if (!matchMedia) {
		log('No working matchMedia implementation found', 'user', logGroup);
	}

	/**
	 * Logic to check for given slot on every window resize
	 *
	 * @param {string} slotname
	 * @returns {boolean}
	 */
	function shouldBeShown(slotname) {
		var wideEnough = false,
			conflictingMediaQuery;

		if (mediaQueriesMet) {
			if (slotsToHideOnMediaQuery[slotname]) {
				conflictingMediaQuery = slotsToHideOnMediaQuery[slotname];
				wideEnough = !mediaQueriesMet[conflictingMediaQuery];
			} else {
				wideEnough = true;
			}
		}

		return wideEnough;
	}

	/**
	 * Refresh an ad and show/hide based on the changed window size
	 * Logging on state changes only, it needs to be super fast
	 *
	 * @param {object} ad one of the wrappedAds
	 */
	function refresh(ad) {
		if (shouldBeShown(ad.slotname)) {
			if (ad.state === 'none' || ad.state === 'ready') {
				log(['Loading ad in slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.show(ad.slotname, true);
				ad.loadCallback();
				ad.state = 'shown';

			} else if (ad.state === 'hidden') {
				log(['Reshowing slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.show(ad.slotname, true);
				ad.state = 'shown';
			}
		} else {
			if (ad.state === 'none') {
				log(['Hiding empty slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.hide(ad.slotname);
				slotTweaker.hackChromeRefresh(ad.slotname);
				ad.state = 'ready';

			} else if (ad.state === 'shown') {
				log(['Hiding slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.hide(ad.slotname);
				slotTweaker.hackChromeRefresh(ad.slotname);
				ad.state = 'hidden';
			}
		}
	}

	/**
	 * Update the pageHeight and mediaQueriesMet
	 * No logging here, it needs to be super fast
	 */
	function updateVars() {
		var mediaQueryIndex;

		// All ads should be shown on non-responsive oasis
		if (win.wgOasisResponsive || win.wgOasisBreakpoints) {
			if (matchMedia) {
				mediaQueriesMet = {};
				for (mediaQueryIndex in mediaQueriesToCheck) {
					if (mediaQueriesToCheck.hasOwnProperty(mediaQueryIndex)) {
						mediaQueriesMet[mediaQueryIndex] = matchMedia(mediaQueriesToCheck[mediaQueryIndex]);
					}
				}
			}
		} else {
			mediaQueriesMet = {};
			for (mediaQueryIndex in mediaQueriesToCheck) {
				if (mediaQueriesToCheck.hasOwnProperty(mediaQueryIndex)) {
					mediaQueriesMet[mediaQueryIndex] = false;
				}
			}
		}
	}

	/**
	 * Refresh all ads
	 * No logging here, it needs to be super fast
	 */
	function refreshAll() {
		var slotname;

		for (slotname in wrappedAds) {
			if (wrappedAds.hasOwnProperty(slotname)) {
				refresh(wrappedAds[slotname]);
			}
		}
	}

	/**
	 * Update the pageHeight and trigger refresh of all ads
	 */
	function onResize() {
		updateVars();
		refreshAll();
	}

	/**
	 * If supported, bind to resize event (and fire it once)
	 */
	function init() {
		log('init', 'debug', logGroup);
		if (win.addEventListener) {
			win.addEventListener('orientationchange', throttle(onResize, 100));
			win.addEventListener('resize', throttle(onResize, 100));
		} else {
			log('No support for addEventListener. No dimension-dependent ads will be shown', 'error', logGroup);
		}

		initCalled = true;
	}

	/**
	 * Add an ad to the wrappedAds
	 *
	 * @param {string} slotname
	 * @param {function} loadCallback -- the function to call when an ad shows up the first time
	 */
	function add(slotname, loadCallback) {
		log(['add', slotname, loadCallback], 'debug', logGroup);

		if (!initCalled) {
			init();
		}

		updateVars();

		wrappedAds[slotname] = {
			slotname: slotname,
			state: 'none',
			loadCallback: loadCallback
		};

		refresh(wrappedAds[slotname]);
	}

	/**
	 * Check if window size logic is applicable to the given slot
	 *
	 * @param {string} slotname
	 * @return {boolean}
	 */
	function isApplicable(slotname) {
		log(['isApplicable', slotname], 'debug', logGroup);

		return !!slotsToHideOnMediaQuery[slotname];
	}

	return {
		addSlot: add,
		isApplicable: isApplicable,
		shouldBeShown: shouldBeShown
	};
});
