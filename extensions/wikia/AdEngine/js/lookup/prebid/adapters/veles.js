/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.veles', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.geo',
	'wikia.instantGlobals',
	'wikia.window'
], function (adContext, prebid, vastUrlBuilder, geo, instantGlobals, win) {
	'use strict';

	var bidderName = 'veles',
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

	function fetchPrice(responseXML) {
		var adParameters,
			parameters;

		if (!responseXML) {
			return 0;
		}

		adParameters = responseXML.documentElement.querySelector('AdParameters');
		if (adParameters) {
			parameters = parseParameters(adParameters);

			if (parameters.veles) {
				return parseInt(parameters.veles, 10) / 100;
			}
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

	function onVastResponse(vastRequest, bidderRequest) {
		var price;

		if (vastRequest.status < 400 && vastRequest.status !== 0) {
			price = fetchPrice(vastRequest.responseXML);
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
