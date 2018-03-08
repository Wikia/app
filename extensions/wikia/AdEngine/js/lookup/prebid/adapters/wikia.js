/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.wikia',[
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.aRecoveryEngine.instartLogic.recovery',
	'wikia.document',
	'wikia.querystring'
], function (prebid, instartLogic, doc, QueryString) {
	'use strict';

	var bidderName = 'wikia',
		priorityLevel = 1,
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
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
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
		return qs.getVal('wikia_adapter', false) !== false && !instartLogic.isBlocking();
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

	function getPriority() {
		return priorityLevel;
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

	function addBids(bidderRequest) {
		bidderRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(1),
				price = getPrice();

			bidResponse.bidderCode = bidderRequest.bidderCode;
			bidResponse.cpm = price;
			bidResponse.ad = getCreative(price, bid.sizes[0]);
			bidResponse.width = bid.sizes[0][0];
			bidResponse.height = bid.sizes[0][1];

			prebid.get().addBidResponse(bid.placementCode, bidResponse);
		});
	}

	function create() {
		return {
			callBids: function (bidderRequest) {
				prebid.push(function () {
					addBids(bidderRequest);
				});
			}
		};
	}

	return {
		create: create,
		isEnabled: isEnabled,
		getName: getName,
		getPriority: getPriority,
		getSlots: getSlots,
		prepareAdUnit: prepareAdUnit
	};
});
