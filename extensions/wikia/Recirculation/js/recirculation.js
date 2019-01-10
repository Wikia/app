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
             discussions,
             oldDiscussions,
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
			getPopularPages(),
			discussions.prepare()
		];
		$.when.apply($, mixedContentFooterData).done(function (nsItems, wikiItems, discussions) {
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					nsItems: nsItems,
					wikiItems: wikiItems,
					discussions: discussions
				});
			});
		});
	}

	function prepareInternationalRecirculation() {
		var mixedContentFooterData = [
			getPopularPages(),
			discussions.prepare()
		];
		$.when.apply($, mixedContentFooterData).done(function (wikiItems, discussions) {
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				viewFactory().render({
					wikiItems: wikiItems,
					discussions: discussions
				});
			});
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
	});
});
