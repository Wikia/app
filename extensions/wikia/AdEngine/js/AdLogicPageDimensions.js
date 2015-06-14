/*jshint camelcase:false, maxdepth:4*/
/*global define*/
define('ext.wikia.adEngine.adLogicPageDimensions', [
	'wikia.window',
	'wikia.document',
	'wikia.log',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.adHelper'
], function (win, doc, log, slotTweaker, adHelper) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adLogicPageDimensions',
		initCalled = false,
		wrappedAds = {},

		/**
		 * Slots based on page length
		 */
		preFootersThreshold = 1500,
		slotsOnlyOnLongPages = {
			LEFT_SKYSCRAPER_2: 2400,
			LEFT_SKYSCRAPER_3: 4000,
			PREFOOTER_LEFT_BOXAD: preFootersThreshold,
			PREFOOTER_RIGHT_BOXAD: preFootersThreshold
		},
		pageHeight,

		/**
		 * Slots based on whether there's a right rail on page or not
		 */
		slotsOnlyWithRail = {
			LEFT_SKYSCRAPER_3: true
		},
		slotsToHideOnMediaQuery = {
			VIRTUAL_INCONTENT:       'twoColumns', // "virtual" slot to launch INCONTENT_* slots
			INCONTENT_1A:            'twoColumns',
			INCONTENT_1B:            'twoColumns',
			INCONTENT_1C:            'twoColumns',
			INCONTENT_LEADERBOARD_1: 'twoColumns',
			TOP_BUTTON_WIDE:         'noTopButton',
			'TOP_BUTTON_WIDE.force': 'noTopButton',
			TOP_RIGHT_BOXAD:         'oneColumn',
			HOME_TOP_RIGHT_BOXAD:    'oneColumn',
			LEFT_SKYSCRAPER_2:       'oneColumn',
			LEFT_SKYSCRAPER_3:       'oneColumn',
			INCONTENT_BOXAD_1:       'oneColumn',
			INCONTENT_PLAYER:        'oneColumn',
			INVISIBLE_SKIN:          'noSkins'
		},
		/**
		 * Slots based on screen width for responsive
		 *
		 * @see skins/oasis/css/core/responsive-variables.scss
		 * @see skins/oasis/css/core/responsive-background.scss
		 */
		mediaQueriesToCheck = {
			twoColumns: 'screen and (min-width: 1024px)',
			oneColumn: 'screen and (max-width: 1023px)',
			noTopButton: 'screen and (max-width: 1063px)',
			noSkins: 'screen and (max-width: 1260px)'
		},
		mediaQueriesMet,
		matchMedia;

	function isRightRailPresent() {
		return !!doc.getElementById('WikiaRail');
	}

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
		var longEnough = false,
			wideEnough = false,
			conflictingMediaQuery;

		if (pageHeight) {
			longEnough = !slotsOnlyOnLongPages[slotname] || pageHeight > slotsOnlyOnLongPages[slotname];
		}
		if (mediaQueriesMet) {
			if (slotsToHideOnMediaQuery[slotname]) {
				conflictingMediaQuery = slotsToHideOnMediaQuery[slotname];
				wideEnough = !mediaQueriesMet[conflictingMediaQuery];
			} else {
				wideEnough = true;
			}
		}

		if (!longEnough || !wideEnough) {
			return false;
		}

		if (slotsOnlyWithRail[slotname]) {
			if (!isRightRailPresent()) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Refresh an ad and show/hide based on the changed window size
	 * No logging here, it needs to be super fast
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
	 * Update the pageHeight and trigger refresh of all ads.
	 * No logging here, it needs to be super fast
	 */
	function onResize() {
		var slotname,
			mediaQueryIndex;

		pageHeight = doc.documentElement.scrollHeight;

		// All ads should be shown on non-responsive oasis and venus
		if ((win.wgOasisResponsive || win.wgOasisBreakpoints) && win.skin !== 'venus') {
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

		for (slotname in wrappedAds) {
			if (wrappedAds.hasOwnProperty(slotname)) {
				refresh(wrappedAds[slotname]);
			}
		}
	}

	/**
	 * If supported, bind to resize event (and fire it once)
	 */
	function init() {
		log('init', 'debug', logGroup);
		if (win.addEventListener) {
			onResize();
			win.addEventListener('orientationchange', adHelper.throttle(onResize, 100));
			win.addEventListener('resize', adHelper.throttle(onResize, 100));
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

		return !!(
			slotsOnlyOnLongPages[slotname] ||
			slotsToHideOnMediaQuery[slotname] ||
			slotsOnlyWithRail[slotname]
		);
	}

	return {
		isApplicable: isApplicable,
		addSlot: add
	};
});
