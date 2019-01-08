define('ext.wikia.recirculation.helpers.sponsoredContent', [], function () {
	'use strict';

	var userGeo = Geo.getCountryCode();

	function fetch() {
		var mock = [
            {
                "id": 0,
                "url": "https://starwars.wikia.com/wiki/Yoda",
                "thumbnailUrl": "https://vignette.wikia.nocookie.net/starwars/images/d/d6/Yoda_SWSB.png/revision/latest/scale-to-width-down/500?cb=20150206140125",
                "weight": 20,
                "geos": [
                    "US"
                ],
                "title": "Yoda",
                "siteName": "Hulu"
            },
            {
                "id": 0,
                "url": "https://muppet.wikia.com/wiki/Elmo",
                "thumbnailUrl": "https://vignette.wikia.nocookie.net/starwars/images/d/d6/Yoda_SWSB.png/revision/latest/scale-to-width-down/500?cb=20150206140125",
                "weight": 25,
                "geos": [],
                "title": "Elmo",
                "siteName": "Hulu"
            },
            {
                "id": 0,
                "url": "https://starwars.wikia.com/wiki/Luke",
                "thumbnailUrl": "https://vignette.wikia.nocookie.net/starwars/images/d/d6/Yoda_SWSB.png/revision/latest/scale-to-width-down/500?cb=20150206140125",
                "weight": 20,
                "geos": [
                    "DE"
                ],
                "title": "Luke",
	            "siteName": "Netflix"
            },
            {
                "id": 0,
                "url": "https://muppet.wikia.com/wiki/Kermit",
                "thumbnailUrl": "https://vignette.wikia.nocookie.net/starwars/images/d/d6/Yoda_SWSB.png/revision/latest/scale-to-width-down/500?cb=20150206140125",
                "weight": 10,
                "geos": [
                    "US",
                    "AU"
                ],
                "title": "Kermit",
                "siteName": "Netflix"
            }
        ];

		return mock;
		// return $.ajax();
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

            return currentSum/totalSum;
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
