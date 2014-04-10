/*jshint camelcase:false, maxdepth:4*/
/*global define*/
define('ext.wikia.adEngine.adLogicPageDimensions', [
	'wikia.window',
	'wikia.document',
	'wikia.log',
	'ext.wikia.adEngine.slotTweaker'
], function (window, document, log, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adLogicPageDimensions',
		initCalled = false,
		wrappedAds = {},

		/**
		 * Slots based on page length
		 */
		preFootersThreshold = 2400,
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
		rightRailPresent = !!document.getElementById('WikiaRail'),

		/**
		 * Slots based on screen width
		 *
		 * @see skins/oasis/css/core/responsive-variables.scss
		 * @see skins/oasis/css/core/responsive-background.scss
		 */
		mediaQueriesToCheck = {
			oneColumn: 'screen and (max-width: 1023px)',
			noTopButton: 'screen and (max-width: 1030px)',
			noSkins: 'screen and (max-width: 1260px)'
		},
		slotsToHideOnMediaQuery = {
			TOP_BUTTON_WIDE: 'noTopButton',
			'TOP_BUTTON_WIDE.force': 'noTopButton',
			TOP_RIGHT_BOXAD: 'oneColumn',
			HOME_TOP_RIGHT_BOXAD: 'oneColumn',
			LEFT_SKYSCRAPER_2: 'oneColumn',
			LEFT_SKYSCRAPER_3: 'oneColumn',
			INCONTENT_BOXAD_1: 'oneColumn',
			INVISIBLE_SKIN: 'noSkins'
		},
		mediaQueriesMet,
		matchMedia;

	function matchMediaMoz(query) {
		return window.matchMedia(query).matches;
	}

	function matchMediaIe(query) {
		return window.styleMedia.matchMedium(query);
	}

	// Chose proper implementation of machMedia
	matchMedia = window.matchMedia && matchMediaMoz;
	matchMedia = matchMedia || (window.styleMedia && window.styleMedia.matchMedium && matchMediaIe);
	matchMedia = matchMedia || (window.media && window.media.matchMedium);

	if (!matchMedia) {
		log('No working matchMedia implementation found', 'user', logGroup);
	}

	/**
	 * Logic to check for given slot on every window resize
	 *
	 * @param slotname
	 * @returns {boolean}
	 */
	function shouldBeShown(slotname) {
		var longEnough = false,
			wideEnough = false,
			conflictingMediaQuery;

		if (slotsOnlyWithRail[slotname]) {
			if (!rightRailPresent) {
				return false;
			}
		}
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

		return longEnough && wideEnough;
	}

	/**
	 * Refresh an ad and show/hide based on the changed window size
	 * No logging here, it needs to be super fast
	 *
	 * @param ad one of the wrappedAds
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
				ad.state = 'ready';

			} else if (ad.state === 'shown') {
				log(['Hiding slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.hide(ad.slotname);
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

		pageHeight = document.documentElement.scrollHeight;

		if (window.wgOasisResponsive) {
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
		if (window.addEventListener) {
			onResize();
			window.addEventListener('resize', onResize);
		} else {
			log('No support for addEventListener. No dimension-dependent ads will be shown', 'error', logGroup);
		}
	}

	/**
	 * Add an ad to the wrappedAds
	 *
	 * @param slotname
	 * @param loadCallback -- the function to call when an ad shows up the first time
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
	 * Check if page should have prefooters (note it can change later)
	 *
	 * @returns {boolean}
	 */
	function hasPreFooters() {
		log('hasPreFooters', 'debug', logGroup);
		pageHeight = document.documentElement.scrollHeight;
		log(['hasPreFooters', {pageHeight: pageHeight, preFootersThreshold: preFootersThreshold}], 'debug', logGroup);
		return pageHeight > preFootersThreshold;
	}

	/**
	 * Check if window size logic is applicable to the given slot
	 *
	 * @param slotname
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
		addSlot: add,
		hasPreFooters: hasPreFooters
	};
});
