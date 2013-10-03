var AdLogicPageDimensions = function (window, document, log, slotTweaker) {
	'use strict';

	var logGroup = 'ext.wikia.adengine.logic.shortpage',
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
		 * Slots based on screen width
		 *
		 * @see skins/oasis/css/core/responsive.scss
		 */
		mediaQueriesToCheck = {
			oneColumn: 'screen and (max-width: 1023px)',
			noTopButton: 'screen and (max-width: 1030px)'
		},
		slotsToHideOnMediaQuery = {
			TOP_BUTTON_WIDE: 'noTopButton',
			'TOP_BUTTON_WIDE.force': 'noTopButton',
			TOP_RIGHT_BOXAD: 'oneColumn',
			HOME_TOP_RIGHT_BOXAD: 'oneColumn',
			LEFT_SKYSCRAPER_2: 'oneColumn',
			LEFT_SKYSCRAPER_3: 'oneColumn',
			INCONTENT_BOXAD_1: 'oneColumn'
		},
		mediaQueriesMet,
		// ABTesting: DAR-1859: START
		notInAbTestRightRailPositionStatic,
		// ABTesting: DAR-1859: END
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

		if (pageHeight) {
			longEnough = !slotsOnlyOnLongPages[slotname] || pageHeight > slotsOnlyOnLongPages[slotname];
		}
		if (mediaQueriesMet) {
			if (slotsToHideOnMediaQuery[slotname]) {
				// ABTesting: DAR-1859: START
				if ((slotsToHideOnMediaQuery[slotname] == 'oneColumn') && notInAbTestRightRailPositionStatic) {
					wideEnough = true;
				} else {
				// ABTesting: DAR-1859: END
					conflictingMediaQuery = slotsToHideOnMediaQuery[slotname];
					wideEnough = !mediaQueriesMet[conflictingMediaQuery];
				// ABTesting: DAR-1859: START
				}
				// ABTesting: DAR-1859: END
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
				ad.provider.fillInSlot(ad.slotinfo);
				ad.state = 'shown';

			} else if (ad.state === 'hidden') {
				log(['Reshowing slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.show(ad.slotname, true);
				ad.state = 'shown';
			}
		} else {
			if (ad.state === 'none') {
				log(['Hiding empty slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.hide(ad.slotname, true);
				ad.state = 'ready';

			} else if (ad.state === 'shown') {
				log(['Hiding slot ' + ad.slotname, ad], 'info', logGroup);

				slotTweaker.hide(ad.slotname, true);
				ad.state = 'hidden';
			}
		}
	}

	/**
	 * Add an ad to the wrappedAds
	 *
	 * @param slotname
	 * @param slotinfo -- the info you pass to fillInSlot
	 * @param provider -- the original provider for the slot
	 */
	function add(slotname, slotinfo, provider) {
		log(['add', slotname, slotinfo, provider], 'debug', logGroup);

		wrappedAds[slotname] = {
			slotname: slotname,
			state: 'none',
			slotinfo: slotinfo,
			provider: provider
		};

		refresh(wrappedAds[slotname]);
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
		// ABTesting: DAR-1859: START
		notInAbTestRightRailPositionStatic = window.Wikia && window.Wikia.AbTest && (Wikia.AbTest.getGroup( "DAR_RIGHTRAILPOSITION" ) == 'STATIC');
		// ABTesting: DAR-1859: END

		log('init', 'debug', logGroup);
		if (window.addEventListener) {
			onResize();
			window.addEventListener('resize', onResize);
		} else {
			log('No support for addEventListener. No dimension-dependent ads will be shown', 'error', logGroup);
		}
	}

	/**
	 * Check if window size logic is applicable to the given slot
	 *
	 * @param slotinfo
	 * @return {boolean}
	 */
	function isApplicable(slotinfo) {
		log(['isApplicable', slotinfo], 'debug', logGroup);

		var slotname = slotinfo[0];
		return !!(slotsOnlyOnLongPages[slotname] || slotsToHideOnMediaQuery[slotname]);
	}

	/**
	 * Check if page should have prefooters (note it can change later)
	 *
	 * @returns {boolean}
	 */
	function hasPreFooters() {
		log('hasPreFooters', 'debug', logGroup);
		return pageHeight < preFootersThreshold;
	}

	/**
	 * Get proxy for given provider delaying fillInSlot to the time screen dimensions criteria
	 * are met. It'll hide and reshow the slots when screen dimensions change in case it affects
	 * their desired presence
	 *
	 * @param provider
	 * @returns {{name: string, wrappedProvider: *, canHandleSlot: Function, fillInSlot: Function}}
	 */
	function getProxy(provider) {
		log(['getProxy', provider], 'debug', logGroup);

		function canHandleSlot(slotinfo) {
			log(['canHandleSlot', slotinfo, provider], 'debug', logGroup);
			return provider.canHandleSlot(slotinfo);
		}

		function fillInSlot(slotinfo) {
			log(['fillInSlot', slotinfo, provider], 'debug', logGroup);

			var slotname = slotinfo[0];
			add(slotname, slotinfo, provider);
		}

		// Init once
		if (!initCalled) {
			initCalled = true;
			init();
		}

		// Return the provider interface
		return {
			name: 'WindowSizeProviderProxy',
			wrappedProvider: provider,
			canHandleSlot: canHandleSlot,
			fillInSlot: fillInSlot
		};
	}

	return {
		isApplicable: isApplicable,
		hasPreFooters: hasPreFooters,
		getProxy: getProxy
	};
};
