var AdLogicShortPage = function (window, document, log) {
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
		oneColumnMediaQuery = 'screen and (max-width: 1023px)',
		slotsToHideOnOneColumnLayout = {
			TOP_BUTTON_WIDE: true,
			'TOP_BUTTON_WIDE.force': true,
			TOP_RIGHT_BOXAD: true,
			LEFT_SKYSCRAPER_2: true,
			LEFT_SKYSCRAPER_3: true,
			INCONTENT_BOXAD_1: true
		},
		layout, // "oneColumn" or "standard"
		matchMedia;

	function matchMediaMoz(query) {
		return window.matchMedia(query).matches;
	}

	// Chose proper implementation of machMedia
	matchMedia = window.matchMedia && matchMediaMoz;
	matchMedia = matchMedia || (window.styleMedia && window.styleMedia.matchMedium);
	matchMedia = matchMedia || (window.media && window.media.matchMedium);

	/**
	 * Logic to check for given slot on every window resize
	 *
	 * @param slotname
	 * @returns {boolean}
	 */
	function shouldBeShown(slotname) {
		var longEnough = false,
			wideEnough = false;

		if (pageHeight) {
			longEnough = !slotsOnlyOnLongPages[slotname] || pageHeight > slotsOnlyOnLongPages[slotname];
		}
		if (layout) {
			wideEnough = !slotsToHideOnOneColumnLayout[slotname] || layout !== 'oneColumn';
		}

		log(['shouldBeShown', slotname, 'longEnough', longEnough, 'wideEnough', wideEnough], 'debug', logGroup);

		return longEnough && wideEnough;
	}

	/**
	 * Hide an ad
	 *
	 * @param ad one of the wrappedAds
	 */
	function hide(ad) {
		var slot = document.getElementById(ad.slotname),
			slotStyle = slot.style;

		log(['hide', ad], 'info', logGroup);

		ad.lastDisplayValue = slotStyle.display;
		ad.state = 'hidden';

		slotStyle.display = 'none';
	}

	/**
	 * Show an ad
	 *
	 * @param ad one of the wrappedAds
	 */
	function show(ad) {
		log(['show', ad], 'info', logGroup);

		ad.state = 'shown';
		document.getElementById(ad.slotname).style.display = ad.lastDisplayValue;
	}

	/**
	 * Load an ad from the wrapped provider
	 *
	 * @param ad one of the wrappedAds
	 */
	function load(ad) {
		log(['load', ad], 'info', logGroup);

		ad.state = 'shown';
		ad.provider.fillInSlot(ad.slotinfo);
	}

	/**
	 * Refresh an ad and show/hide based on the changed window size
	 * No logging here, it needs to be super fast
	 *
	 * @param ad one of the wrappedAds
	 */
	function refresh(ad) {
		if (shouldBeShown(ad.slotname)) {
			if (ad.state === 'none') {
				load(ad);
			} else if (ad.state === 'hidden') {
				show(ad);
			}
		} else {
			if (ad.state === 'shown') {
				hide(ad);
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
		var slotname;

		pageHeight = document.documentElement.scrollHeight;

		if (window.wgOasisResponsive) {
			if (matchMedia) {
				layout = matchMedia(oneColumnMediaQuery) ? 'oneColumn' : 'standard';
			}
		} else {
			layout = 'standard';
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
	 * Check if window size logic is applicable to the given slot
	 *
	 * @param slotinfo
	 * @return {boolean}
	 */
	function isApplicable(slotinfo) {
		log(['isApplicable', slotinfo], 'debug', logGroup);

		var slotname = slotinfo[0];
		return !!(slotsOnlyOnLongPages[slotname] || slotsToHideOnOneColumnLayout[slotname]);
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
