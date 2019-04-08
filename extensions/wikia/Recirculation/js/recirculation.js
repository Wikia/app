require([
	'jquery',
	'mw',
	'wikia.window',
	'wikia.log',
	'wikia.nirvana',
	'wikia.trackingOptIn',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.views.mixedFooter',
	'ext.wikia.recirculation.helpers.discussions',
	'ext.wikia.recirculation.helpers.sponsoredContent',
	'ext.wikia.recirculation.helpers.blacklist',
	'ext.wikia.recirculation.discussions',
	'ext.wikia.recirculation.tracker',
	require.optional('videosmodule.controllers.rail')
], function ($,
             mw,
             window,
             log,
             nirvana,
             trackingOptIn,
             utils,
             mixedFooter,
             discussions,
             sponsoredContentHelper,
             blacklist,
             oldDiscussions,
             tracker,
             videosModule) {
	'use strict';

	var $mixedContentFooter = $('#mixed-content-footer'),
		$mixedContentFooterContent = $('.mcf-content'),
		numberOfArticleFooterSlots = $mixedContentFooter.data('number-of-wiki-articles'),
		numberOfFandomPostFooterSlots = $mixedContentFooter.data('number-of-ns-articles');

	/** Discard redundant data returned by jQuery */
	function mapAjaxCall(data /*, code, jqXHR */) {
		return data;
	}

	function getTrendingFandomArticles() {
		return nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getTrendingFandomArticles',
			type: 'get',
			data: {
				limit: numberOfFandomPostFooterSlots,
			}
		}).then(mapAjaxCall);
	}

	function getFilteredItems(response) {
		var blacklistedItems = blacklist.get();

		return response.article_recommendation
			.concat(response.wiki_recommendation)
			.filter(function (el) {
				return blacklistedItems.indexOf(el.item_id) === -1;
			});
	}

	function mapExperimentalDataResponse(response) {
		var filteredItems = getFilteredItems(response);

		if (filteredItems < numberOfArticleFooterSlots) {
			blacklist.remove(5);

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
		var itemId = window.wgCityId + '_' + window.wgArticleId;

		blacklist.update(itemId);

		$.ajax({
			url: window.wgServicesExternalDomain + 'recommendations/recommendations',
			data: {
				wikiId: window.wgCityId,
				articleId: window.wgArticleId,
				beacon: window.beacon_id,
			}
		}).done(function (result) {
			deferred.resolve(mapExperimentalDataResponse(result));
		}).fail(function (err) {
			log('Failed to fetch experimental recommended data, using getPopularPages as backup' + err, log.levels.error);

			getPopularPages()
				.then(function (response) {
					deferred.resolve(mapAjaxCall(response));
				});
		});

		return deferred.promise();
	}

	function waitForRail() {
		var $rail = $('#WikiaRail'),
			deferred = $.Deferred();

		if ($rail.find('.loading').exists()) {
			$rail.one('afterLoad.rail', function () {
				deferred.resolve();
			});
		} else {
			deferred.resolve();
		}

		return deferred.promise();
	}

	function getRecommendedArticles() {
		var shouldUseExperimentalService = window.Wikia.AbTest.inGroup('RECOMMENDATION_SERVICE', 'EXPERIMENTAL');

		return shouldUseExperimentalService ? getExperimentalRecommendedData() : getPopularPages();
	}

	function getPopularPages() {
		return nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getPopularPages',
			type: 'get',
			data: {
				limit: numberOfArticleFooterSlots,
			}
		}).then(mapAjaxCall);
	}

	function prepareEnglishRecirculation() {
		// prepare & render mixed content footer module
		var mixedContentFooterData = [
			getTrendingFandomArticles(),
			getRecommendedArticles(),
			discussions.prepare(),
			sponsoredContentHelper.fetch()
		];
		$.when.apply($, mixedContentFooterData).done(function (nsItems, wikiItems, discussions, sponsoredContent) {
			// do not show footer at all if there is not enough elements to display
			if (wikiItems.length < numberOfArticleFooterSlots) {
				return;
			}
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					nsItems: nsItems,
					wikiItems: wikiItems,
					discussions: discussions,
					sponsoredItem: sponsoredContentHelper.getSponsoredItem(sponsoredContent)
				});
			});
		})
		.fail(function (err) {
			log('Failed to fetch MCF data for english recirculation' + err, log.levels.error);
		});
	}

	function prepareInternationalRecirculation() {
		var mixedContentFooterData = [
			getRecommendedArticles(),
			discussions.prepare(),
			sponsoredContentHelper.fetch()
		];
		$.when.apply($, mixedContentFooterData).done(function (wikiItems, discussions, sponsoredContent) {
			// do not show footer at all if there is not enough elements to display
			if (wikiItems.length < numberOfArticleFooterSlots) {
				return;
			}
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					wikiItems: wikiItems,
					discussions: discussions,
					sponsoredItem: sponsoredContentHelper.getSponsoredItem(sponsoredContent)
				});
			});
		})
		.fail(function (err) {
			log('Failed to fetch MCF data for international recirculation' + err, log.levels.error);
		});
	}

	trackingOptIn.pushToUserConsentQueue(function (optIn) {
		if (!optIn) {
			$mixedContentFooter.hide();
			return;
		}

		if (window.wgContentLanguage === 'en') {
			prepareEnglishRecirculation();
		} else {
			prepareInternationalRecirculation();

			if (videosModule) {
				videosModule('#recirculation-rail');
			}
		}

		var lazyLoadHandler = $.throttle(50, function () {
			var mcfOffset = $mixedContentFooter.offset().top,
				scrollPosition = $(window).scrollTop(),
				windowInnerHeight = $(window).height(),
				lazyLoadOffset = 500,
				aproachingMCF = scrollPosition > mcfOffset - windowInnerHeight - lazyLoadOffset;

			if (aproachingMCF) {
				discussions.fetch();
				window.removeEventListener('scroll', lazyLoadHandler);
			}
		});

		window.addEventListener('scroll', lazyLoadHandler);
		lazyLoadHandler();

		$.when
			.apply($, [
				sponsoredContentHelper.fetch(),
				utils.loadTemplates(['client/premiumRail_sponsoredContent.mustache']),
				waitForRail()
			])
			.done(function (sponsoredContent, template) {
				var $rail = $('#WikiaRail'),
					$firstItem = $rail.find('.premium-recirculation-rail .thumbnails li').first(),
					sponsoredItem = sponsoredContentHelper.getSponsoredItem(sponsoredContent);

				if (!$firstItem) {
					return;
				}

				if (sponsoredItem) {

					if (sponsoredItem.title && sponsoredItem.title.length > 90) {
						sponsoredItem.shortTitle = sponsoredItem.title.substring(0, 80) + '...';
					} else {
						sponsoredItem.shortTitle = sponsoredItem.title;
					}

					if (sponsoredItem.thumbnailUrl && window.Vignette) {
						sponsoredItem.thumbnailUrl = window.Vignette.getThumbURL(sponsoredItem.thumbnailUrl, {
							mode: window.Vignette.mode.zoomCrop,
							height: 53,
							width: 53
						});
					}

					$firstItem.replaceWith(utils.renderTemplate(template[0], sponsoredItem));
				}

				tracker.trackImpression('rail');

				$rail.on('click', '[data-tracking]', function () {
					var $this = $(this),
						labels = $this.data('tracking').split(','),
						href = $this.attr('href');

					labels.forEach(function (label) {
						tracker.trackClick(label);
					});
					tracker.trackSelect(href);
				});
			})
			.fail(function (err) {
				log('Failed to fetch rail data for recirculation' + err, log.levels.error);
			});
	});
});
