/*global define*/
define('ext.wikia.recirculation.helpers.recommendedContent', [
    'jquery',
    'wikia.window',
    'wikia.nirvana',
    'ext.wikia.recirculation.helpers.blacklist',
    'wikia.log',
    'wikia.eventLogger'
], function ($, w, nirvana, blacklist, log, eventLogger) {
    'use strict';

    var numberOfArticleFooterSlots = $('#mixed-content-footer').data('number-of-wiki-articles');
    var REQUEST_ID;

    function getFilteredItems(response) {
        var blacklistedItems = blacklist.get();

        return response.article_recommendation
            .filter(function (el) {
                return blacklistedItems.indexOf(el.item_id) === -1;
            })
            .concat(response.wiki_recommendation);
    }

    function mapExperimentalDataResponse(response) {
        var filteredItems = getFilteredItems(response);

        REQUEST_ID = response.recommendation_request_id;

        if (filteredItems < numberOfArticleFooterSlots) {
            blacklist.remove(5);

            eventLogger.logError(
                w.wgServicesExternalDomain,
                'Recommendations',
                {
                    reason: 'Not enough non-visited articles fetched from recommendation service',
                    itemId: w.wgCityId + '_' + w.wgArticleId
                }
            );

            filteredItems = getFilteredItems(response);
        }

        return filteredItems
            .map(function (el) {
                return {
                    id: el.item_id,
                    site_name: el.wiki_title,
                    url: el.url,
                    thumbnail: el.thumbnail_url,
                    title: el.article_title || el.wiki_title,
                };
            });
    }

    function getExperimentalRecommendedData() {
        var deferred = $.Deferred();
        var itemId = w.wgCityId + '_' + w.wgArticleId;

        blacklist.update(itemId);

        $.ajax({
            url: w.wgServicesExternalDomain + 'recommendations/recommendations',
            data: {
                wikiId: w.wgCityId,
                articleId: w.wgArticleId,
                beacon: w.beacon_id,
            }
        }).done(function (result) {
            deferred.resolve(mapExperimentalDataResponse(result));
        }).fail(function (err) {
            log('Failed to fetch experimental recommended data, using getPopularPages as backup' + err, log.levels.error);

        });

        return deferred.promise();
    }

    function getPopularPages() {
        return nirvana.sendRequest({
            controller: 'RecirculationApi',
            method: 'getPopularPages',
            type: 'get',
            data: {
                limit: numberOfArticleFooterSlots,
            }
        }).then(function (data) {
            return data;
        });
    }

    function getRecommendedArticles() {
        var shouldUseExperimentalService = window.Wikia.AbTest.inGroup('RECOMMENDATION_SERVICE', 'EXPERIMENTAL');

        return shouldUseExperimentalService ? getExperimentalRecommendedData() : getPopularPages();
    }

    function getRequestId() {
        return REQUEST_ID;
    }

    return {
        getRecommendedArticles: getRecommendedArticles,
        getRequestId: getRequestId
    };
});
