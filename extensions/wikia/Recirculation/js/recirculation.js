require([
	'jquery',
	'mw',
	'wikia.window',
	'wikia.log',
	'wikia.nirvana',
	'wikia.trackingOptIn',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.views.mixedFooter',
	'ext.wikia.recirculation.helpers.liftigniter',
	'ext.wikia.recirculation.helpers.discussions',
	'ext.wikia.recirculation.helpers.sponsoredContent',
	'ext.wikia.recirculation.discussions',
	require.optional('videosmodule.controllers.rail')
], function ($,
             mw,
             window,
             log,
             nirvana,
             trackingOptIn,
             utils,
             mixedFooter,
             liftigniter,
             discussions,
             sponsoredContentHelper,
             oldDiscussions,
             videosModule) {
	'use strict';

	var $mixedContentFooter = $('#mixed-content-footer'),
		$mixedContentFooterContent = $('.mcf-content'),
		numberOfArticleFooterSlots = $mixedContentFooter.data('number-of-wiki-articles'),
		mixedContentFooter = {
			nsItems: {
				max: $mixedContentFooter.data('number-of-ns-articles'),
				widget: 'wikia-impactfooter',
				width: 386,
				height: 337,
				modelName: 'ns',
				opts: {
					resultType: 'cross-domain',
					domainType: 'fandom.wikia.com'
				}
			},
		};

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

	function getPopularPages() {
		return nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getPopularPages',
			type: 'get',
			data: {
				limit: numberOfArticleFooterSlots,
			}
		});
	}

	function prepareEnglishRecirculation() {
		// prepare & render mixed content footer module
		var mixedContentFooterData = [
			liftigniter.prepare(mixedContentFooter.nsItems),
			getPopularPages(),
			discussions.prepare(),
			sponsoredContentHelper.fetch()
		];
		$.when.apply($, mixedContentFooterData).done(function (nsItems, popularPagesResponse, discussions, sponsoredContent) {
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					nsItems: nsItems,
					wikiItems: popularPagesResponse[0],
					discussions: discussions,
					sponsoredContent: sponsoredContentHelper.getSponsoredItem(sponsoredContent)
				});
			});
		})
			.fail(function (err) {
				log('Failed to fetch MCF data for english recirculation' + err, log.levels.error);
			});
	}

	function prepareInternationalRecirculation() {
		var mixedContentFooterData = [
			getPopularPages(),
			discussions.prepare(),
			sponsoredContentHelper.fetch()
		];
		$.when.apply($, mixedContentFooterData).done(function (popularPagesResponse, discussions, sponsoredContent) {
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					wikiItems: popularPagesResponse[0],
					discussions: discussions,
					sponsoredContent: sponsoredContentHelper.getSponsoredItem(sponsoredContent)
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

			// fetch data for all recirculation modules
			liftigniter.fetch('ns');
		} else {
			prepareInternationalRecirculation();

			if (window.wgContentLanguage === 'de') {
				liftigniter.fetch('wiki');
			}

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
				liftigniter.fetch('wiki');
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
					$firstItem = $rail.find('.premium-recirculation-rail .thumbnails li').first();

				$firstItem.replaceWith(
					utils.renderTemplate(template, sponsoredContentHelper.getSponsoredItem(sponsoredContent))
				);
			})
			.fail(function (err) {
				log('Failed to fetch rail data for recirculation' + err, log.levels.error);
			});
	});
});
