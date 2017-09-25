/*global define*/
define('ext.wikia.adEngine.ml.hivi.leaderboardInputParser', [
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.lookup.services',
	'wikia.log'
], function (pageParams, lookupServices, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.ml.hivi.leaderboardInputParser',
		slotName = 'TOP_LEADERBOARD';

	function getBidderPrice(bidderName, prices) {
		var price = prices[bidderName];

		return price || 0;
	}

	function getData() {
		var articleHeight,
			data,
			hour = (new Date()).getHours(),
			params = pageParams.getPageLevelParams(),
			prices = lookupServices.getDfpSlotPrices(slotName);

		articleHeight = Math.min(parseInt(params.ah || 0, 10), 15000) / 15000;

		data = [
			Math.min(parseInt(params.pv || 1, 10), 30) / 30,			// PV
			hour / 23,													// Hour
			params.s2 === 'article' ? 1 : 0,							// Is article page?
			params.s2 === 'home' ? 1 : 0,								// Is home page?
			params.s2 === 'file' ? 1 : 0,								// Is file page?
			params.s2 === 'search' ? 1 : 0,								// Is search page?
			params.s2 === 'forum' ? 1 : 0,								// Is forum page?
			params.s2 === 'extra' ? 1 : 0,								// Is extra page?
			params.s2 === 'special' ? 1 : 0,							// Is special page?
			params.esrb === 'ec' ? 1 : 0,								// Is esrb ec?
			params.esrb === 'teen' ? 1 : 0,								// Is esrb teen?
			params.esrb === 'everyone' ? 1 : 0,							// Is esrb everyone?
			params.esrb === 'mature' ? 1 : 0,							// Is esrb mature?
			params.esrb === 'e10' ? 1 : 0,								// Is esrb e10?
			params.ref === 'direct' ? 1 : 0,							// Is direct traffic?
			params.ref.indexOf('external') !== -1 ? 1 : 0,				// Is external traffic?
			params.ref.indexOf('wiki') !== -1 ? 1 : 0,					// Is wiki traffic?
			params.top === '1k' ? 1 : 0,								// TOP1k wiki
			articleHeight,												// Article height
			getBidderPrice('indexExchange', prices),					// IndexExchange
			getBidderPrice('appnexus', prices),							// AppNexus
			'DEPRECATED',												// Rubicon Fastlane
			'DEPRECATED',												// Rubicon Fastlane private
			getBidderPrice('aol', prices),								// AOL
			getBidderPrice('openx', prices)								// OpenX
		];

		log(['Leaderboard data', data], log.levels.debug, logGroup);

		return data;
	}

	return {
		getData: getData
	};
});
