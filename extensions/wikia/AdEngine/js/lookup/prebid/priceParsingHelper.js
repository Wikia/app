/*global define*/
define('ext.wikia.adEngine.lookup.prebid.priceParsingHelper', [
	'ext.wikia.adEngine.utils.sampler',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (sampler, geo, instantGlobals, log, win) {
	'use strict';

	/**
	 * @typedef {Object} VelesParams
	 * @property {string} position - allowed values 'LB', 'IC' and 'XX'
	 * @property {number} price
	 * @property {boolean} valid
	 */

	var adxAdSystem = 'AdSense/AdX',
		defaults = {
			position: 'IC',
			price: 0
		},
		invalidResult = {
			moatTracking: 1,
			position: defaults.position,
			price: defaults.price,
			valid: false
		},
		loggerEndpoint = '/wikia.php?controller=AdEngine2Api&method=postVelesInfo',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.veles',
		validPositions = ['LB', 'IC', 'XX'];

	function sendRequest(vast) {
		var request = new win.XMLHttpRequest();

		request.open('POST', loggerEndpoint, true);
		request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		request.send('vast=' + encodeURIComponent(vast));
	}

	function logVast(vastRequest) {
		log(['logVast', vastRequest], log.levels.debug, logGroup);
		if (sampler.sample('velesLog', 1, 100)) {
			sendRequest(vastRequest.response);
		}
	}

	/**
	 * From the string in the form of numbers only that represents
	 * the amount of cents, return number that represents the amount of $.
	 *
	 * @param numberString
	 * @returns {number}
	 */
	function getPriceInDollars(numberString) {
		return numberString ? parseInt(numberString, 10) / 100 : null;
	}

	function extractPriceFrom(regexpResult) {
		return regexpResult ? getPriceInDollars(regexpResult[1]) : null;
	}

	function extractPositionFrom(regexpResult) {
		var position = regexpResult && regexpResult[2];

		if (position) {
			position = position.toUpperCase();

			if (validPositions.indexOf(position) < 0) {
				position = defaults.position;
			}
		} else {
			position = defaults.position;
		}

		log(['extractPositionFrom', position], log.levels.debug, logGroup);

		return position;
	}

	function extractMoatTrackingSampling(input) {
		return input.indexOf('+100%') !== -1 ? 100 : 1;
	}

	/**
	 * For given input, if contains string in form like:
	 * ve6749ic
	 * ve3150LB
	 * ve0321xx
	 * returns object containing information about position, price and validity
	 *
	 * @param string input
	 * @returns {VelesParams}
	 */
	function parse(input) {
		var re = new RegExp('ve([0-9]{4})(xx|ic|lb)', 'i'),
			regexpResult,
			price,
			result = invalidResult;

		if (input) {
			regexpResult = re.exec(input);
			price = extractPriceFrom(regexpResult);

			result = {
				moatTracking: extractMoatTrackingSampling(input),
				position: extractPositionFrom(regexpResult),
				price: price,
				valid: Boolean(price)
			};
		}

		return result;
	}

	// config format 'wgAdDriverVelesBidderConfig' => ['353663292' => 've1500XX', 'AdSense/AdX'=> 've1123LB'],
	function analyzeConfigFor(id) {
		var result = invalidResult;

		if (id && instantGlobals.wgAdDriverVelesBidderConfig[id]) {
			result = parse(instantGlobals.wgAdDriverVelesBidderConfig[id]);
		}

		log(['analyzeConfigFor', id, result], log.levels.debug, logGroup);

		return result;
	}

	function analyzeConfigForAdSystemIn(adSystem) {
		var adConfigPrice = instantGlobals.wgAdDriverVelesBidderConfig[adxAdSystem],
			result = invalidResult;

		if (adConfigPrice && adSystem === adxAdSystem) {
			result = parse(adConfigPrice);
		}

		return result;
	}

	// response was invalid - log it to Kibana
	function logInvalidResponse(result, vastRequest) {
		var ad = vastRequest.responseXML.documentElement.querySelector('Ad');

		if (!result.valid && ad && geo.isProperGeo(instantGlobals.wgAdDriverVelesVastLoggerCountries)) {
			logVast(vastRequest);
		}
	}

	function analyzeResponse(vastInfo) {
		var result = invalidResult;

		if (vastInfo.id && instantGlobals.wgAdDriverVelesBidderConfig) {
			result = analyzeConfigFor(vastInfo.id);

			if (!result.valid) {
				result = analyzeConfigForAdSystemIn(vastInfo.adSystem);
			}
		}

		return result;
	}

	function getVastId(responseXML) {
		var ad = responseXML.documentElement.querySelector('Ad'),
			adSystem,
			vastInfo = {};

		if (ad) {
			vastInfo.id = ad.getAttribute('id');

			adSystem = ad.querySelector('AdSystem');
			if (adSystem) {
				vastInfo.adSystem = adSystem.textContent;
			}
		}

		return vastInfo;
	}

	/**
	 * Process VAST response to get price and position for this video. If is response is invalid or price
	 * data couldn't be find set price to 0, and set valid as false..
	 *
	 * @param vastRequest
	 * @returns {VelesParams}
	 */
	function analyze(vastRequest) {
		var result = invalidResult,
			vastInfo;

		if (vastRequest.responseXML) {
			vastInfo = getVastId(vastRequest.responseXML);
			result = analyzeResponse(vastInfo);
			result.vastId = [
				vastInfo.adSystem,
				vastInfo.id
			].join(':');
			result.vastUrl = vastRequest.responseURL;

			logInvalidResponse(result, vastRequest);
		}

		return result;
	}

	return {
		analyze: analyze
	};
});
