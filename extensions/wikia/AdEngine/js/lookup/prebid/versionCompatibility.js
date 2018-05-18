/*global define*/
define('ext.wikia.adEngine.lookup.prebid.versionCompatibility', [
], function () {
	'use strict';

	function toPrebidV0Bid(bid) {
		switch (bid.bidder) {
			case 'indexEchange':
				bid.params.siteID = Number(bid.params.siteId);
				delete bid.params.siteId;
				delete bid.params.size;
				break;
			case 'rubicon':
			case 'rubiconDisplay':
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

			adUnit.bids = adUnit.bids.map(toPrebidV0Bid);

			return adUnit;
		};
	}

	function toVersion0GetAliases(getAliases) {
		return function () {
			var newAliasesObj = {},
				aliasesObj;

			if (!getAliases) {
				return newAliasesObj;
			}

			aliasesObj = getAliases.apply(null, arguments);

			Object.keys(aliases).forEach(function (bidder) {
				var aliases = aliasesObj[bidder];

				switch (true) {
					case (bidder === 'appnexus' && aliases[0] === 'appnexusWebAds'):
						newAliasesObj['appnexusAst'] = ['appnexusWebAds'];
						break;
					case (bidder === 'appnexus' && aliases[0] === 'appnexusAst'):
						break;
					case (bidder === 'ix' && aliases[0] === 'indexExchange'):
						break;
					default:
						return aliasesObj;
				}
			});

			return newAliasesObj;
		};
	}

	return {
		toVersion0: {
			decoratePrepareAdUnit: toVersion0PrepareAdUnit,
			decorateGetAliases: toVersion0GetAliases
		}
	};
});
