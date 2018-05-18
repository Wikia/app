/*global define*/
define('ext.wikia.adEngine.lookup.prebid.versionCompatibility', [
], function () {
	'use strict';

	function toPrebidVersion0Bid(bid) {
		switch (bid.bidder) {
			case 'indexExchange':
				bid.params.siteID = Number(bid.params.siteId);
				delete bid.params.siteId;
				delete bid.params.size;
				break;
			case 'rubicon':
			case 'rubicon_display':
				bid.params.accountId = Number(bid.params.accountId);
				bid.params.zoneId = Number(bid.params.zoneId);
				bid.params.siteId = Number(bid.params.siteId);

				if (bid.params.video) {
					bid.params.video.playerWidth = Number(bid.params.video.playerWidth);
					bid.params.video.playerHeight = Number(bid.params.video.playerHeight);
					bid.params.video.size_id = Number(bid.params.video.size_id);

					delete bid.params.video.language;
				}

				break;
			case 'pubmatic':
				bid.params.publisherId = Number(bid.params.publisherId);
				break;
		}

		return bid;
	}

	function toVersion0PrepareAdUnit(prepareAdUnit) {
		return function () {
			var adUnit = prepareAdUnit.apply(null, arguments);

			if (adUnit.mediaTypes.video) {
				adUnit.sizes = adUnit.mediaTypes.video.playerSize;
				adUnit.mediaType = 'video';

				if (adUnit.mediaTypes.video.context) {
					adUnit.mediaType += '-' + adUnit.mediaTypes.video.context;
				}
			}

			if (adUnit.mediaTypes.banner) {
				adUnit.sizes = adUnit.mediaTypes.banner.sizes;
			}

			delete adUnit.mediaTypes;

			adUnit.bids = adUnit.bids.map(toPrebidVersion0Bid);

			return adUnit;
		};
	}

	function toVersion0GetAliases(getAliases) {
		return function () {
			var aliasesObj;

			if (!getAliases) {
				return {};
			}

			aliasesObj = getAliases.apply(null, arguments);

			Object.keys(aliasesObj).forEach(function (bidder) {
				var aliases = aliasesObj[bidder];

				switch (true) {
					case (bidder === 'appnexus' && aliases[0] === 'appnexusWebAds'):
						aliasesObj['appnexusAst'] = ['appnexusWebAds'];
						delete aliasesObj['appnexus'];
						break;
					case (bidder === 'appnexus' && aliases[0] === 'appnexusAst'):
						delete aliasesObj['appnexus'];
						break;
					case (bidder === 'ix' && aliases[0] === 'indexExchange'):
						delete aliasesObj['ix'];
						break;
				}
			});

			return aliasesObj;
		};
	}

	return {
		toVersion0: {
			decoratePrepareAdUnit: toVersion0PrepareAdUnit,
			decorateGetAliases: toVersion0GetAliases
		}
	};
});
