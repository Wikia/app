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
             oldDiscussions,
             videosModule) {
	'use strict';

	var $mixedContentFooter = $('#mixed-content-footer'),
		$mixedContentFooterContent = $('.mcf-content'),
		railRecirculation = {
			max: 5,
			widget: 'wikia-rail',
			width: 320,
			height: 180,
			modelName: 'ns',
			title: 'recirculation-fandom-title',
			opts: {
				resultType: 'cross-domain',
				domainType: 'fandom.wikia.com'
			}
		},
		internationalRailRecirculation = {
			max: 5,
			widget: 'wikia-rail-i18n',
			width: 320,
			height: 180,
			modelName: 'wiki',
			title: 'recirculation-trending',
			opts: {
				rule_language: window.wgContentLanguage
			}
		},
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
			wikiItems: {
				max: $mixedContentFooter.data('number-of-wiki-articles'),
				widget: 'wikia-footer-wiki-rec',
				width: 386,
				height: 337,
				modelName: 'wiki',
				opts: {
					rule_language: window.wgContentLanguage
				}
			}
		};

	function prepareRailRecirculation(options) {
		if (mw.config.get('canLoadFeedsAndPosts')) {
			// If Feeds & Posts will load, don't display the rail recirc
			return;
		}

		var request;
		var isRecirculationABTest = window.Wikia.AbTest.inGroup('RIGHT_RAIL_RECIRCULATION_SOURCE', 'TOPIC_FEED') &&
			getCurationCMSTopic();

		if (isRecirculationABTest) {
			request = getDataFromCurationCMS();
		} else {
			request = liftigniter.prepare(options);
		}
		// prepare & render right rail recirculation module
		request.done(function (data) {
			require(['ext.wikia.recirculation.views.premiumRail'], function (viewFactory) {
				var view = viewFactory();
				view.render(data, options.title)
					.then(view.setupTracking())
					.then(function () {
						if (!isRecirculationABTest) {
							liftigniter.setupTracking(view.itemsSelector, options);
						}
					});
			});
		});
	}

	function getNormalizedCurationCMSData(data) {
		var normalizedData = {};
		normalizedData.items = [];

		data.posts.forEach(function (post) {
			normalizedData.items.push({
				title: post.title,
				thumbnail: post.thumbnail.url,
				url: post.url
			});
		});

		return normalizedData;
	}

	function getDataFromCurationCMS() {
		var deferred = $.Deferred();

		nirvana.sendRequest({
			controller: 'RecirculationApi',
			method: 'getFandomPosts',
			format: 'json',
			type: 'get',
			scriptPath: window.wgCdnApiUrl,
			data: {
				type: 'stories',
				slug: getCurationCMSTopic()
			},
			callback: function (data) {
				if (data && data.posts && data.posts.length > 0) {
					deferred.resolve(getNormalizedCurationCMSData(data));
				} else {
					deferred.reject();
				}
			},
			onErrorCallback: function () {
				deferred.reject();
			}
		});

		return deferred;
	}

	function getCurationCMSTopic() {
		var topics = {
			2233: 'marvel',
			147: 'star-wars',
			1071836: 'overwatch',
			3035: 'fallout',
			250551: 'arrowverse',
			13346: 'the-walking-dead',
			410: 'anime',
			1081: 'anime',
		};

		return topics[window.wgCityId];
	}

	function prepareEnglishRecirculation() {
		// prepare & render mixed content footer module
		var mixedContentFooterData = [
			liftigniter.prepare(mixedContentFooter.nsItems),
			liftigniter.prepare(mixedContentFooter.wikiItems),
			discussions.prepare()
		];
		$.when.apply($, mixedContentFooterData).done(function (nsItems, wikiItems, discussions) {
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				var view = viewFactory();
				view.render({
					nsItems: nsItems,
					wikiItems: wikiItems,
					discussions: discussions
				}).then(function () {
					liftigniter.setupTracking(view.nsItemsSelector, mixedContentFooter.nsItems);
					liftigniter.setupTracking(view.wikiItemsSelector, mixedContentFooter.wikiItems);
				});
			});
		});
	}

	function prepareInternationalRecirculation() {
		var mixedContentFooterData = [
			liftigniter.prepare(mixedContentFooter.wikiItems),
			discussions.prepare()
		];
		$.when.apply($, mixedContentFooterData).done(function (wikiItems, discussions) {
			$mixedContentFooterContent.show();
			require(['ext.wikia.recirculation.views.mixedFooter'], function (viewFactory) {
				var view = viewFactory();
				view.render({
					wikiItems: wikiItems,
					discussions: discussions
				}).then(function () {
					liftigniter.setupTracking(view.wikiItemsSelector, mixedContentFooter.wikiItems);
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
			prepareRailRecirculation(railRecirculation);

			// fetch data for all recirculation modules
			liftigniter.fetch('ns');
		} else {
			prepareInternationalRecirculation();

			if (window.wgContentLanguage === 'de') {
				prepareRailRecirculation(internationalRailRecirculation);
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
	});
});
