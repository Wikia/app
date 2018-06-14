/*global define*/
define('wikia.cmp', [
	'wikia.consentFrameworkVendorList',
	'wikia.consentStringLibrary',
	'wikia.cookies',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.trackingOptIn',
	'wikia.window'
], function (
	vendorList,
	consentStringLibrary,
	cookies,
	geo,
	instantGlobals,
	log,
	trackingOptIn,
	win
) {
	var isModuleEnabled = geo.isProperGeo(instantGlobals.wgEnableCMPCountries),
		logGroup = 'wikia.cmp',
		consentStringCookie = 'consent-string',
		cookieExpireDays = 604800000, // 7 days in milliseconds
		// take all purposes...
		allowedPurposesList = vendorList.purposes.map(function (purpose) {
			return purpose.id;
		}),
		// ...and all vendors
		allowedVendorsList = vendorList.vendors.map(function (vendor) {
			return vendor.id;
		});

	function getConsentString(optIn) {
		var cookie = cookies.get(consentStringCookie),
			consentData,
			consentString;

		cookie = cookie ? cookie.split('...') : cookie;

		if (cookie && (cookie[0] === '1') === optIn && cookie[1] !== undefined) {
			log('Retrieving consent string from the cookie', log.levels.debug, logGroup);

			return cookie[1];
		}

		consentData = new consentStringLibrary.ConsentString();

		consentData.setGlobalVendorList(vendorList);
		consentData.setPurposesAllowed(optIn ? allowedPurposesList : []);
		consentData.setVendorsAllowed(optIn ? allowedVendorsList : []);

		consentString = consentData.getConsentString();

		cookies.set(consentStringCookie, (optIn ? '1...' : '0...') + consentString, {
			path: '/',
			domain: window.wgCookieDomain || '.wikia.com',
			expires: cookieExpireDays
		});

		log('Consent string saved to the cookie', log.levels.debug, logGroup);

		return consentString;
	}

	function getGdprApplies() {
		return trackingOptIn.geoRequiresTrackingConsent();
	}

	function init(optIn) {
		log('Initializing module', log.levels.debug, logGroup);
		log(['Allowed vendors:', vendorList.vendors.map(function (vendor) {
			return vendor.name;
		})], log.levels.debug, logGroup);

		win.__cmp = function __cmp(command, parameter, callback) {
			var iabConsentData = getConsentString(optIn),
				gdprApplies = getGdprApplies(),
				success,
				ret;

			switch (true) {
				case (command === 'getConsentData'):
					ret = {
						consentData: iabConsentData,
						gdprApplies: gdprApplies
					};
					success = true;
					break;
				case (command === 'getVendorConsents'):
					ret = {
						metadata: iabConsentData,
						gdprApplies: gdprApplies
					};
					success = true;
					break;
				default:
					log('Unknown command ' + command, log.levels.debug, logGroup);
					ret = {};
					success = false;
			}

			log(
				[
					'__cmp call',
					'command: ' + command,
					'parameter: ' + parameter,
					'returnValue: ' + JSON.stringify(ret),
					'success: ' + success
				],
				log.levels.debug,
				logGroup
			);

			callback(ret, success);
		};
	}

	if (isModuleEnabled) {
		win.__cmp = function __cmp(command, version, callback) {
			log(['__cmp call', 'CMP module is not initialized'], log.levels.debug, logGroup);
			callback({}, false);
		};
		win.addEventListener('message', function (event) {
			try {
				var call = event.data.__cmpCall;

				if (call) {
					win.__cmp(call.command, call.parameter, function(retValue, success) {
						var returnMsg = {
							__cmpReturn: {
								returnValue: retValue, success: success, callId: call.callId
							}
						};
						event.source.postMessage(returnMsg, '*');
					});
				}
			} catch (e) { void(0); } // do nothing
		});
		trackingOptIn.pushToUserConsentQueue(init);
	} else {
		log('Module is not enabled', log.levels.debug, logGroup);
	}

	return {
		getConsentString: getConsentString,
		getGdprApplies: getGdprApplies
	};
});
