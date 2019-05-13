define('ext.wikia.recirculation.helpers.sponsoredContent', [
	'jquery',
	'wikia.window',
	'wikia.geo',
	'wikia.log'
], function ($, w, geo, log) {
	'use strict';

	var userGeo = geo.getCountryCode();
	var hasFetched = false;
	var deferred = $.Deferred();

	function fetch() {
		if (!hasFetched) {
			hasFetched = true;

			$.ajax({
				url: w.wgServicesExternalDomain + 'wiki-recommendations/sponsored-articles/',
			}).done(function (result) {
				deferred.resolve(result);
			}).fail(function (err) {
				log('Failed to fetch Sponsored content data' + err, log.levels.error);
				// don't block rendering of rail/MCF
				deferred.resolve([]);
			});
		}

		return deferred.promise();
	}

	function getSponsoredItem(sponsoredContent) {
		var applicableContent = getApplicableContent(sponsoredContent);
		var sumOfWeights = getWeightsSum(applicableContent);
		var ranges = getMaxRanges(applicableContent, sumOfWeights);
		var applicableRanges = getApplicableRanges(ranges, Math.random());
		var firstApplicableIndex = applicableContent.length - applicableRanges.length;

		return applicableContent[firstApplicableIndex];
	}

	function applyContentCriteria(sponsoredContent, propName, criteria) {
		return sponsoredContent.filter(function (item) {
			return item[propName].indexOf(criteria) !== -1;
		});
	}

	function getApplicableContent(sponsoredContent) {
		var geoSpecificContent = applyContentCriteria(sponsoredContent, 'geos', userGeo);
		var siteSpecificContent = applyContentCriteria(sponsoredContent, 'wikiIds', w.wgCityId);

		var geoAndSiteSpecificContent = applyContentCriteria(geoSpecificContent, 'wikiIds', w.wgCityId);

		if (geoAndSiteSpecificContent.length) {
			return geoAndSiteSpecificContent;
		}

		if (siteSpecificContent.length) {
			return siteSpecificContent;
		}

		if (geoSpecificContent.length) {
			return geoSpecificContent;
		}

		return sponsoredContent.filter(function (item) {
			return !item.wikiIds.length && !item.geos.length;
		});
	}

	function getWeightsSum(applicableContent) {
		return applicableContent.reduce(function (sum, el) {
			return sum + el.weight;
		}, 0);
	}

	function getMaxRanges(applicableContent, totalSum) {
		return applicableContent.map(function (el, index, arr) {
			var currentSum = getWeightsSum(arr.slice(0, index + 1));

			return currentSum / totalSum;
		});
	}

	function getApplicableRanges(maxRanges, number) {
		return maxRanges.filter(function (el) {
			return el >= number;
		});
	}

	return {
		fetch: fetch,
		getSponsoredItem: getSponsoredItem
	};
});
