/*global define*/
define('ext.wikia.adEngine.lookup.prebid.adapters.wikiaVideo',[
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.wad.babDetection',
	'ext.wikia.adEngine.wrappers.prebid',
	'ext.wikia.adEngine.video.vastUrlBuilder',
	'wikia.document',
	'wikia.querystring'
], function (adContext, babDetection, prebid, vastUrlBuilder, doc, QueryString) {
	'use strict';

	var bidderName = 'wikiaVideo',
		slots = {
			oasis: {
				FEATURED: {},
				INCONTENT_PLAYER: {}
			},
			mercury: {
				FEATURED: {},
				MOBILE_IN_CONTENT: {}
			}
		},
		qs = new QueryString();

	function getPrice() {
		var price = qs.getVal('wikia_video_adapter', 0);

		return parseInt(price, 10) / 100;
	}

	function isEnabled() {
		return qs.getVal('wikia_video_adapter', false) !== false && !babDetection.isBlocking();
	}

	function prepareAdUnit(slotName) {
		return {
			code: slotName,
			mediaTypes: {
				video: {
					context: 'outstream',
					playerSize: [640, 480]
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

	function addBids(bidRequest, addBidResponse, done) {
		bidRequest.bids.forEach(function (bid) {
			var bidResponse = prebid.get().createBid(1),
				price = getPrice();

			bidResponse.bidderCode = bidRequest.bidderCode;
			bidResponse.cpm = price;
			bidResponse.creativeId = 'foo123_wikiaVideoCreativeId';
			bidResponse.ttl = 300;
			bidResponse.mediaType = 'video';
			bidResponse.width = bid.sizes[0][0];
			bidResponse.height = bid.sizes[0][1];
			bidResponse.vastUrl = vastUrlBuilder.build(
				bidResponse.width / bidResponse.height,
				{
					src: 'test',
					pos: 'outstream',
					passback: 'wikiaVideo'
				}
			);
			bidResponse.videoCacheKey = '123foo_wikiaVideoCacheKey';

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
					supportedMediaTypes: ['video']
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
