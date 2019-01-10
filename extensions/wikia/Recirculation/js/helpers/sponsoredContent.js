define('ext.wikia.recirculation.helpers.sponsoredContent', [
	'jquery',
	'wikia.window'
], function ($, w) {
	'use strict';

	var userGeo = Geo.getCountryCode();
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
				deferred.reject(err);
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

	function getApplicableContent(sponsoredContent) {
		return sponsoredContent.filter(function (el) {
			return !el.geos.length || el.geos.indexOf(userGeo) !== -1;
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
