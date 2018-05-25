define('wikia.trackingOptIn', [
	'wikia.cookies',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.trackingOptInModal'
], function (cookies, instantGlobals, lazyQueue, log, trackingOptInModal) {
	var optIn = false,
		geoRequiresConsent = true,
		instance = null,
		logGroup = 'wikia.trackingOptIn',
		prebidConsentStringCookie = 'prebid-consent-string',
		prebidCookieExpireDays = 604800000, // 7 days in milliseconds
		prebidVendorListUrl = 'https://vendorlist.consensu.org/vendorlist.json',
		prebidPurposesList = [1, 2, 3, 4, 5],
		prebidVendorsList = [
			10, // Index Exchange, Inc.
			32, // AppNexus Inc.
			52, // The Rubicon Project, Limited
			69, // OpenX Software Ltd. and its affiliates
			76, // PubMatic, Inc.
		];

	window.Wikia.consentQueue = window.Wikia.consentQueue || [];

	lazyQueue.makeQueue(window.Wikia.consentQueue, function (callback) {
		callback(optIn);
	});

	function init() {
		if (instantGlobals.wgEnableTrackingOptInModal) {
			log('Using tracking opt in modal', log.levels.info, logGroup);
			instance = trackingOptInModal.init({
				onAcceptTracking: function () {
					optIn = true;
					window.Wikia.consentQueue.start();
					log('User opted in', log.levels.debug, logGroup);
				},
				onRejectTracking: function () {
					window.Wikia.consentQueue.start();
					log('User opted out', log.levels.debug, logGroup);
				},
				zIndex: 9999999
			});
			geoRequiresConsent = instance.geoRequiresTrackingConsent();
		} else {
			optIn = true;
			geoRequiresConsent = false;
			window.Wikia.consentQueue.start();
			log('Running queue without tracking opt in modal', log.levels.info, logGroup);
		}
	}

	function isOptedIn() {
		log(['isOptedIn', optIn], log.levels.info, logGroup);
		return optIn;
	}

	function pushToUserConsentQueue(callback) {
		window.Wikia.consentQueue.push(callback);
	}

	function geoRequiresTrackingConsent() {
		return geoRequiresConsent;
	}

	function getPrebidGlobalVendorList() {
		var request = new XMLHttpRequest();

		log('Requesting IAB Global Vendor List', log.levels.debug, logGroup);

		request.open('GET', prebidVendorListUrl, false);
		request.send(null);

		return JSON.parse(request.responseText);
	}

	function getPrebidConsentString(optIn) {
		var cookie = cookies.get(prebidConsentStringCookie);

		if (cookie) {
			log('Serving consent string from cookie', log.levels.debug, logGroup);
			return cookie;
		}

		var consentString,
			consentData = new trackingOptInModal.ConsentString();

		consentData.setGlobalVendorList(getPrebidGlobalVendorList());
		consentData.setPurposesAllowed(optIn ? prebidPurposesList : []);
		consentData.setVendorsAllowed(optIn ? prebidVendorsList : []);

		consentString = consentData.getConsentString();

		cookies.set(prebidConsentStringCookie, consentString, {
			path: '/',
			domain: window.wgCookieDomain,
			expires: prebidCookieExpireDays
		});

		log('Saving consent string to cookie', log.levels.debug, logGroup);

		return consentString;
	}

	return {
		init: init,
		isOptedIn: isOptedIn,
		pushToUserConsentQueue: pushToUserConsentQueue,
		geoRequiresTrackingConsent: geoRequiresTrackingConsent,
		getPrebidConsentString: getPrebidConsentString
	};
});
