/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.veles', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.lookup.prebid.priceParsingHelper',
	'ext.wikia.adEngine.utils.sampler',
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (adContext, priceParsingHelper, sampler, prebid, vastUrlBuilder, geo, instantGlobals, log, win) {
	'use strict';

	var adxAdSystem = 'AdSense/AdX',
		bidderName = 'veles',
		loggerEndpoint = '/wikia.php?controller=AdEngine2Api&method=postVelesInfo',
		logGroup = 'ext.wikia.adEngine.lookup.prebid.adapters.veles',
		slots = {
			// Order of slots is important - first slot name in group will be used to create ad unit
			oasis: {
				INCONTENT_PLAYER: {
					sizes: [
						[ 640, 480 ]
					]
				},
				INCONTENT_LEADERBOARD: {
					sizes: [
						[ 640, 480 ]
					]
				}
			},
			mercury: {
				MOBILE_IN_CONTENT: {
					sizes: [
						[ 640, 480 ]
					]
				}
			}
		};

	function parseParameters(adParameters) {
		var parameters = {};

		if (adParameters.childNodes.length && adParameters.childNodes[0].nodeValue) {
			adParameters.childNodes[0].nodeValue.split(',').forEach(function (pair) {
				var data = pair.split('=');

				parameters[data[0]] = data[1];
			});
		}

		return parameters;
	}

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

	function getPriceFromTitle(responseXML) {
		var lineItemTitle = responseXML.documentElement.querySelector('AdTitle');

		if (lineItemTitle) {
			return priceParsingHelper.getPriceFromString(lineItemTitle.textContent);
		}
	}

	function getPriceFromConfigId(ad) {
		var adConfigPrice,
			id = ad.getAttribute('id');

		if (id) {
			adConfigPrice = instantGlobals.wgAdDriverVelesBidderConfig[id];
			if (adConfigPrice) {
				return parseInt(adConfigPrice, 10) / 100;
			}
		}
	}

	function getPriceFromConfigAdSystem(ad) {
		var adConfigPrice = instantGlobals.wgAdDriverVelesBidderConfig[adxAdSystem],
			adSystem;

		if (adConfigPrice) {
			adSystem = ad.querySelector('AdSystem');
			if (adSystem && adSystem.textContent === adxAdSystem) {
				return parseInt(adConfigPrice, 10) / 100;
			}
		}
	}

	function getPriceFromAdParameters(responseXML) {
		var parameters = parseParameters(responseXML.documentElement.querySelector('AdParameters'));

		if (parameters.veles) {
			return parseInt(parameters.veles, 10) / 100;
		}
	}

	/**
	 * Process VAST response to get price for this video or 0 if
	 * response invalid or price data couldn't be find.
	 *
	 * @param vastRequest
	 * @returns {number}
	 */
	function fetchPrice(vastRequest) {
		var ad,
			price = 0,
			responseXML = vastRequest.responseXML;

		if (!responseXML) {
			return 0;
		}

		ad = responseXML.documentElement.querySelector('Ad');

		if (ad) {
			price = getPriceFromTitle(responseXML);

			if (!price && instantGlobals.wgAdDriverVelesBidderConfig) {
				var priceFromConfig = getPriceFromConfigId(ad);

				price = priceFromConfig ? priceFromConfig : getPriceFromConfigAdSystem(ad);
			}
		}

		if (!price) {
			price = getPriceFromAdParameters(responseXML);
		}

		// request was invalid - log it to Kibana
		if (!price && ad && geo.isProperGeo(instantGlobals.wgAdDriverVelesVastLoggerCountries)) {
			logVast(vastRequest);
		}

		return price;
	}

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverVelesBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName
				}
			]
		};
	}

	function getSlots(skin) {
		return slots[skin];
	}

	function getName() {
		return bidderName;
	}

	function addEmptyBids(bidderRequest) {
		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(2);

			bidResponse.bidderCode = bidderRequest.bidderCode;
			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function addBids(bidderRequest, vastResponse, price) {
		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(1);

			bidResponse.bidderCode = bidderRequest.bidderCode;
			bidResponse.cpm = price;
			bidResponse.ad = vastResponse;
			bidResponse.width = bid.sizes[0][0];
			bidResponse.height = bid.sizes[0][1];

			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function isValidResponse(status) {
		return status !== 0 && status < 400;
	}

	function onVastResponse(vastRequest, bidderRequest) {
		var price;

		if (isValidResponse(vastRequest.status)) {
			price = fetchPrice(vastRequest);
			addBids(bidderRequest, vastRequest.response, price);
		} else {
			addEmptyBids(bidderRequest);
		}
	}

	function requestVast(bidderRequest) {
		var request = new win.XMLHttpRequest(),
			skin = adContext.getContext().targeting.skin,
			vastUrl = vastUrlBuilder.build(640 / 480, {
				pos: Object.keys(slots[skin]),
				src: 'gpt',
				passback: bidderName
			});

		request.onreadystatechange = function () {
			if (this.readyState === 4) {
				onVastResponse(request, bidderRequest);
			}
		};
		request.open('GET', vastUrl, true);
		request.send();
	}

	function create() {
		return {
			callBids: function (bidderRequest) {
				prebid.push(function () {
					requestVast(bidderRequest);
				});
			}
		};
	}

	return {
		create: create,
		isEnabled: isEnabled,
		getName: getName,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
