/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.wikia',[
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.babDetection',
	'ext.wikia.adEngine.wrappers.prebid',
	'wikia.document',
	'wikia.querystring'
], function (adContext, babDetection, prebid, doc, QueryString) {
	'use strict';

	var bidderName = 'wikia',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90]
					]
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250]
					]
				},
				INCONTENT_BOXAD_1: {
					sizes: [
						[300, 250]
					]
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[728, 90]
					]
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					]
				},
				MOBILE_IN_CONTENT: {
					sizes: [
						[300, 250]
					]
				},
				BOTTOM_LEADERBOARD: {
					sizes: [
						[300, 250]
					]
				}
			}
		},
		qs = new QueryString();

	function getPrice() {
		var price = qs.getVal('wikia_adapter', 0);

		return parseInt(price, 10) / 100;
	}

	function isEnabled() {
		return qs.getVal('wikia_adapter', false) !== false && !babDetection.isBlocking();
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			mediaTypes: {
				banner: {
					sizes: config.sizes
				}
			},
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

	function getCreative(price, size) {
		var creative = doc.createElement('div'),
			details = doc.createElement('small'),
			title = doc.createElement('p');

		creative.style.background = '#00b7e0';
		creative.style.color = '#fff';
		creative.style.fontFamily = 'sans-serif';
		creative.style.height = '100%';
		creative.style.textAlign = 'center';
		creative.style.width = '100%';

		title.innerText = 'Wikia Creative';
		title.style.fontWeight = 'bold';
		title.style.margin = '0';
		title.style.paddingTop = '10px';

		details.innerText = 'price: ' + price + ', size: ' + size.join('x');

		creative.appendChild(title);
		creative.appendChild(details);

		return creative.outerHTML;
	}

	function addBids(bidRequest, addBidResponse, done) {
		bidRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(1),
				price = getPrice();

			bidResponse.ad = getCreative(price, bid.sizes[0]);
			bidResponse.bidderCode = bidRequest.bidderCode;
			bidResponse.cpm = price;
			bidResponse.ttl = 300;
			bidResponse.mediaType = 'banner';
			bidResponse.width = bid.sizes[0][0];
			bidResponse.height = bid.sizes[0][1];

			addBidResponse(bid.adUnitCode, bidResponse);
			done();
		});
	}

	function create() {
		return {
			callBids: function (bidRequest, addBidResponse, done) {
				prebid.push(function () {
					addBids(bidRequest, addBidResponse, done);
				});
			},
			getSpec: function () {
				return {
					code: getName(),
					supportedMediaTypes: ['banner']
				};
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
