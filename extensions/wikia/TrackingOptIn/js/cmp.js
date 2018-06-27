/*global define,require*/
define('wikia.cmp', [
	'wikia.consentFrameworkVendorList',
	'wikia.consentStringLibrary',
	'wikia.cookies',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.trackingOptIn',
	require.optional('wikia.trackingOptInModal'),
	'wikia.window'
], function (
	staticVendorList,
	cs,
	cookies,
	geo,
	instantGlobals,
	lazyQueue,
	log,
	trackingOptIn,
	trackingOptInModal,
	win
) {
	var isModuleEnabled = geo.isProperGeo(instantGlobals.wgEnableCMPCountries),
		logGroup = 'wikia.cmp',
		fandomCmpId = 141,
		vendorConsentCookieName = 'euconsent',
		hasGlobalScope = false,
		cookieExpireMillis = 33696000000, // this represents thirteen 30-day months
		cmpQueue = [],
		allowedVendorsList = [
			10, // Index Exchange, Inc.
			11, // Quantcast International Limited
			32, // AppNexus Inc.
			52, // The Rubicon Project, Limited
			69, // OpenX Software Ltd. and its affiliates
			76, // PubMatic, Inc.
		],
		vendorConsent,
		vendorConsentString,
		cmpCommands;

	function init(optIn) {
		log('Initializing module', log.levels.debug, logGroup);

		vendorConsentString = cookies.get(vendorConsentCookieName);

		if (vendorConsentString) {
			log(['Retrieving consent string from the cookie', vendorConsentString], log.levels.debug, logGroup);
			vendorConsent = new cs.ConsentString(vendorConsentString);
			win.__cmp = __cmp;
			cmpQueue.start();
		} else {
			__cmp('getVendorList', null, function (vendorList, success) {
				var allowedPurposesList;

				vendorList = success ? vendorList : staticVendorList;
				allowedPurposesList = vendorList.purposes.map(function (purpose) {
					return purpose.id;
				});

				vendorConsent = new cs.ConsentString();
				vendorConsent.setCmpId(fandomCmpId);
				vendorConsent.setCmpVersion(1);
				vendorConsent.setConsentScreen(1);
				vendorConsent.setConsentLanguage((geo.getCountryCode() || 'en').toLowerCase());
				vendorConsent.setGlobalVendorList(vendorList);
				vendorConsent.setPurposesAllowed(optIn ? allowedPurposesList : []);
				vendorConsent.setVendorsAllowed(optIn ? allowedVendorsList : []);

				vendorConsentString = vendorConsent.getConsentString();

				cookies.set(vendorConsentCookieName, vendorConsentString, {
					path: '/',
					domain: win.wgCookieDomain || '.wikia.com',
					expires: cookieExpireMillis
				});

				log('Consent string saved to the cookie', log.levels.debug, logGroup);

				win.__cmp = __cmp;
				cmpQueue.start();
			});
		}
	}

	function fetchVendorList(callback, version) {
		var versionString = version ? ('v-' + version + '/') : '',
			url = 'https://vendorlist.consensu.org/' + versionString + 'vendorlist.json',
			req = new win.XMLHttpRequest();

		req.open('GET', url, true);
		req.onload = function () {
			var response;

			try {
				response = JSON.parse(this.responseText);
			} catch (e) {
				response = null;
			}

			callback(response);
		};
		req.onerror = function () {
			callback(null);
		};
		req.send(null);
	}

	function __cmpStub(commandName, parameter, callback) {
		if (commandName === 'ping') {
			callback({
				gdprAppliesGlobally: hasGlobalScope,
				cmpLoaded: false
			}, true);
		} else {
			log([
				'__cmpStub call',
				'adding command ' + commandName +' to the queue'
			], log.levels.debug, logGroup);
			cmpQueue.push([commandName, parameter, callback]);
		}
	}

	function __cmp(commandName, parameter, callback) {
		if (hasCommand(commandName)) {
			cmpCommands[commandName](parameter, function (value, success) {
				log(
					[
						'__cmp call',
						'command: ' + commandName,
						'parameter: ' + parameter,
						'returnValue: ' + JSON.stringify(value),
						'success: ' + !!success
					],
					log.levels.debug,
					logGroup
				);

				callback(value, !!success);
			});
		} else {
			callback(null, false);
			log('Unknown command ' + commandName, log.levels.debug, logGroup);
		}
	}

	function getGdprApplies() {
		return trackingOptIn.geoRequiresTrackingConsent();
	}

	function callCmp() {
		if (isEnabled()) {
			return win.__cmp.apply(null, arguments);
		} else {
			log(['callCmp', 'module is not enabled'], log.levels.debug, logGroup);
		}
	}

	function createIdArray(maxId) {
		var array = Array.apply(null, {length: maxId + 1}).map(Number.call, Number);

		delete array[0];

		return array;
	}

	function hasCommand(commandName) {
		return (typeof cmpCommands[commandName] === 'function');
	}

	function reset() {
		cookies.set(vendorConsentCookieName, null, {
			path: '/',
			domain: win.wgCookieDomain || '.wikia.com'
		});
	}

	function isEnabled() {
		return isModuleEnabled;
	}

	cmpCommands = {
		getVendorConsents: function (vendorIds, callback) {
			var vendors = (vendorIds && vendorIds.length) ? vendorIds : (
					vendorConsent.maxVendorId ?
					createIdArray(vendorConsent.maxVendorId) :
					vendorConsent.vendorList.vendors.map(function (vendor) {
						return vendor.id;
					})
				),
				maxPurposeId = Math.max.apply(null, vendorConsent.getPurposesAllowed()),
				purposes = createIdArray(maxPurposeId);

			callback({
				metadata: vendorConsent.getMetadataString(),
				gdprApplies: getGdprApplies(),
				hasGlobalScope: hasGlobalScope,
				purposeConsents: purposes.reduce(function (obj, id) {
					obj[id] = vendorConsent.isPurposeAllowed(id);
					return obj;
				}, {}),
				vendorConsents: vendors.reduce(function (obj, id) {
					obj[id] = vendorConsent.isVendorAllowed(id);
					return obj;
				}, {})
			}, true);
		},
		getConsentData: function (version, callback) {
			if (!version || Number(version) === vendorConsent.getVersion()) {
				callback({
					consentData: vendorConsentString,
					gdprApplies: getGdprApplies(),
					hasGlobalScope: hasGlobalScope
				}, true);
			} else {
				callback(null, false);
			}
		},
		getVendorList: function (version, callback) {
			if (!version && vendorConsent) {
				version = vendorConsent.getVendorListVersion();
			}

			fetchVendorList(function (vendorList) {
				callback(vendorList, !!vendorList);
			}, version);
		},
		ping: function (parameter, callback) {
			callback({
				gdprAppliesGlobally: hasGlobalScope,
				cmpLoaded: true
			}, true);
		},
		displayConsentUi: trackingOptInModal ? function () {
			reset();
			trackingOptInModal.init({ zIndex: 9999999 }).reset();
		} : undefined
	};

	if (isEnabled()) {
		lazyQueue.makeQueue(cmpQueue, function (args) {
			win.__cmp.apply(null, args);
		});
		win.__cmp = __cmpStub;
		win.addEventListener('message', function (event) {
			try {
				var call = event.data.__cmpCall;

				if (call) {
					win.__cmp(call.command, call.parameter, function (retValue, success) {
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
		getGdprApplies: getGdprApplies,
		callCmp: callCmp,
		isEnabled: isEnabled,
		reset: reset
	};
});
