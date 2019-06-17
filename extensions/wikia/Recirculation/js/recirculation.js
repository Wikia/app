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
	'ext.wikia.recirculation.helpers.recommendedContent',
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
             recommendedContent,
             oldDiscussions,
             tracker,
             videosModule) {
	'use strict';

	var $mixedContentFooter = $('#mixed-content-footer'),
		$mixedContentFooterContent = $('.mcf-content'),
		numberOfArticleFooterSlots = $mixedContentFooter.data('number-of-wiki-articles'),
		numberOfFandomPostFooterSlots = $mixedContentFooter.data('number-of-ns-articles');

	function getTrendingFandomArticles() {
		return nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getTrendingFandomArticles',
			type: 'get',
			data: {
				limit: numberOfFandomPostFooterSlots,
			}
		}).then(function (data) {
			return data;
		});
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

	function prepareEnglishRecirculation() {
		// prepare & render mixed content footer module
		var mixedContentFooterData = [
			getTrendingFandomArticles(),
			recommendedContent.getRecommendedArticles(),
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

	function insertTrackingPixel(pixelContent, pixelType) {
		var wrapper = document.createElement('span');

		wrapper.className = 'wds-is-hidden';

		if (pixelType === 'url') {
			var tag = document.createElement('img');
			tag.src = pixelContent;
			wrapper.appendChild(tag);
		} else {
			wrapper.innerHTML = pixelContent;
		}

		window.document.body.appendChild(wrapper);
	}

	function prepareInternationalRecirculation() {
		var mixedContentFooterData = [
			recommendedContent.getRecommendedArticles(),
			discussions.prepare(),
			sponsoredContentHelper.fetch()
		];
		$.when.apply($, mixedContentFooterData).done(function (wikiItems, discussions, sponsoredContent) {
			// do not show footer at all if there is not enough elements to display
			if (wikiItems.length < numberOfArticleFooterSlots) {
				return;
			}

			var sponsoredItem = sponsoredContentHelper.getSponsoredItem(sponsoredContent);

			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					wikiItems: wikiItems,
					discussions: discussions,
					sponsoredItem: sponsoredItem
				});

				if (sponsoredItem.pixelContent) {
					insertTrackingPixel(sponsoredItem.pixelContent, sponsoredItem.pixelType);
				}
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

					if (sponsoredItem.pixelContent) {
						insertTrackingPixel(sponsoredItem.pixelContent, sponsoredItem.pixelType);
					}
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
