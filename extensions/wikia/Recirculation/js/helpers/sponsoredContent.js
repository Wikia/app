define('ext.wikia.recirculation.helpers.sponsoredContent', [
    'jquery',
    'wikia.window'
], function ($, w) {
    'use strict';

    var userGeo = Geo.getCountryCode();
    var hasFetched = false;
    var deferred = $.Deferred();

    function fetch() {
        return deferred.resolve(
            [
                {
                    "id": 25,
                    "url": "http://gameofthrones.wikia.com/wiki/Main_Page",
                    "thumbnailUrl": "https://vignette.wikia.nocookie.net/marveldatabase/images/b/b9/Spider-Man_Main_Page_Icon.jpg/revision/latest?cb=20180216053121",
                    "weight": 2,
                    "geos": [
                        "US",
                        "AU",
                        "PL"
                    ],
                    "title": "SIema",
                    "attribution": "SiemaS",
                    "attributionLabel": "Siema2"
                },
                {
                    "id": 24,
                    "url": "http://rybatest.mateuszr.wikia-dev.pl/wiki/InfoboxEdgecasesWithGalleryWithFeaturedVideo",
                    "thumbnailUrl": "https://vignette.wikia.nocookie.net/marveldatabase/images/b/b9/Spider-Man_Main_Page_Icon.jpg/revision/latest?cb=20180216053121",
                    "weight": 4,
                    "geos": [
                        "US",
                        "DE"
                    ],
                    "title": "1234",
                    "attribution": "asdfss",
                    "attributionLabel": "asdfss"
                },
                {
                    "id": 22,
                    "url": "https://poznan.mateuszr.fandom-dev.pl/pl/wiki/Areszt_śledczy",
                    "thumbnailUrl": "https://vignette.wikia.nocookie.net/marveldatabase/images/b/b9/Spider-Man_Main_Page_Icon.jpg/revision/latest?cb=20180216053121",
                    "weight": 1,
                    "geos": [
                        "AU",
                        "PL"
                    ],
                    "title": "title 1",
                    "attribution": "sponsor 1",
                    "attributionLabel": "powered by"
                }
            ]
        );

        if (!hasFetched) {
            hasFetched = true;

            $
                .ajax({
                    url: 'https://' + w.wgServiceUrl + '/wiki-recommendations/sponsored-articles',
                })
                .done(function (result) {
                    deferred.resolve(result);
                })
                .fail(function (err) {
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
