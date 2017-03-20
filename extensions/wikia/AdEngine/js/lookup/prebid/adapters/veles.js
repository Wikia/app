/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.veles', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.utils.sampler',
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.log',
	'wikia.window'
], function (adContext, sampler, prebid, vastUrlBuilder, geo, instantGlobals, log, win) {
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

	function fetchPrice(vastRequest) {
		var ad,
			adConfigPrice,
			adParameters,
			adSystem,
			parameters,
			responseXML = vastRequest.responseXML;

		if (!responseXML) {
			return 0;
		}

		ad = responseXML.documentElement.querySelector('Ad');
		if (ad && instantGlobals.wgAdDriverVelesBidderConfig) {
			if (ad.getAttribute('id')) {
				adConfigPrice = instantGlobals.wgAdDriverVelesBidderConfig[ad.getAttribute('id')];
				if (adConfigPrice) {
					return parseInt(adConfigPrice, 10) / 100;
				}
			}

			adConfigPrice = instantGlobals.wgAdDriverVelesBidderConfig[adxAdSystem];
			if (adConfigPrice) {
				adSystem = ad.querySelector('AdSystem');
				if (adSystem && adSystem.textContent === adxAdSystem) {
					return parseInt(adConfigPrice, 10) / 100;
				}
			}
		}

		adParameters = responseXML.documentElement.querySelector('AdParameters');
		if (adParameters) {
			parameters = parseParameters(adParameters);

			if (parameters.veles) {
				return parseInt(parameters.veles, 10) / 100;
			}
		}

		if (ad && geo.isProperGeo(instantGlobals.wgAdDriverVelesVastLoggerCountries)) {
			logVast(vastRequest);
		}

		return 0;
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
