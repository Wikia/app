/*global define*/
define('ext.wikia.recirculation.helpers.recommendedContent', [
    'jquery',
    'wikia.window',
    'wikia.nirvana',
    'ext.wikia.recirculation.helpers.recommendationBlacklist',
    'wikia.log',
    'wikia.eventLogger'
], function ($, w, nirvana, recommendationBlacklist, log, eventLogger) {
    'use strict';

    var NUMBER_OF_RECOMMENDATIONS_TO_REMOVE = 5;
    var numberOfArticleFooterSlots = $('#mixed-content-footer').data('number-of-wiki-articles');
    var requestId;

    function getNonBlacklistedRecommendedData(response) {
        var blacklistedItems = recommendationBlacklist.get();

        return response.article_recommendation
            .filter(function (el) {
                return blacklistedItems.indexOf(el.item_id) === -1;
            })
            .concat(response.wiki_recommendation);
    }

    function mapExperimentalDataResponse(response) {
        var filteredItems = getNonBlacklistedRecommendedData(response);

        requestId = response.recommendation_request_id;

        if (filteredItems < numberOfArticleFooterSlots) {
            recommendationBlacklist.remove(NUMBER_OF_RECOMMENDATIONS_TO_REMOVE);

            eventLogger.logError(
                w.wgServicesExternalDomain,
                'Recommendations',
                {
                    reason: 'Not enough non-visited articles fetched from recommendation service',
                    itemId: w.wgCityId + '_' + w.wgArticleId
                }
            );

            filteredItems = getNonBlacklistedRecommendedData(response);
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

    /**
     * Fetch recommendations from service built by Data Engineering Team
     */
    function getExperimentalRecommendedData() {
        var deferred = $.Deferred();
        var itemId = w.wgCityId + '_' + w.wgArticleId;

        recommendationBlacklist.update(itemId);

        $.ajax({
            url: w.wgServicesExternalDomain + 'recommendations/recommendations',
            data: {
                wikiId: w.wgCityId,
                articleId: w.wgArticleId
            },
			headers: {
				'X-Beacon': w.beacon_id
			}
        }).done(function (result) {
            deferred.resolve(mapExperimentalDataResponse(result));
        }).fail(function (err) {
            log('Failed to fetch experimental recommended data, using getPopularPages as a fallback' + err, log.levels.error);

            getPopularPages().then(deferred.resolve);
        });

        return deferred.promise();
    }

    /**
     * A fallback for recommendations service
     */
    function getPopularPages() {
        return nirvana.sendRequest({
            controller: 'RecirculationApi',
            method: 'getPopularPages',
            type: 'get',
            data: {
                limit: numberOfArticleFooterSlots
            }
        }).then(function (data) {
            return data;
        });
    }

    function getRequestId() {
        return requestId;
    }

    return {
        getRecommendedArticles: getExperimentalRecommendedData,
        getRequestId: getRequestId
    };
});
