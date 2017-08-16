require([
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.helpers.liftigniter',
	'ext.wikia.recirculation.helpers.discussions',
	'ext.wikia.recirculation.discussions',
	require.optional('videosmodule.controllers.rail')
], function ($,
             w,
             log,
             utils,
             liftigniter,
             discussions,
             oldDiscussions,
             videosModule) {
	/**
	 *
	 *  var recircModules = [
	 *    {
	 *  		id: 'unique identifier - only used if you want to use data across multiple views',
	 *  		viewModule: 'name of the view',
	 *  		options: {
	 *  			any options to pass to the liftigniter helper
	 *  		}
	 *  	}
	 *  ];
	 *
	 */
	'use strict';

	var railRecirculation = {
		max: 5,
		widget: 'wikia-rail',
		modelName: 'ns',
		// source: 'fandom',
		opts: {
			resultType: 'cross-domain',
			domainType: 'fandom.wikia.com'
		}
	};

	var mixedContentFooter = {
		nsItems: {
			max: 9,
			widget: 'wikia-impactfooter',
			// source: 'fandom',
			modelName: 'ns',
			opts: {
				resultType: 'cross-domain',
				domainType: 'fandom.wikia.com'
			}
		},
		wikiItems: {
			max: 3,
			widget: 'wikia-footer-wiki-rec',
			// source: 'wiki',
			// title: 'Discover New Wikis',
			// width: 332,
			// height: 187,
			modelName: 'wiki',
			opts: {
				domainType: 'fandom.wikia.com'
			}
		}
	};

	var logGroup = 'ext.wikia.recirculation.experiments.mix';

	if (w.wgContentLanguage === 'en') {
		if (videosModule) {
			videosModule('#recirculation-rail');
		}
		oldDiscussions();
		return;
	}


	// load news & stories
	liftigniter.prepare(railRecirculation).loadData().done(function (data) {
		require(['ext.wikia.recirculation.views.premiumRail'], function (viewFactory) {
			debugger;
			viewFactory().render(data);
		});
	});

	var mixedContentFooterData = [
		liftigniter.prepare(mixedContentFooter.nsItems).loadData(),
		liftigniter.prepare(mixedContentFooter.wikiItems).loadData(),
		discussions.prepare()
	];
	$.when.apply($, mixedContentFooterData).done(function (nsItems, wikiItems, discussions) {
		require(['ext.wikia.recirculation.views.impactFooter'], function (viewFactory) {
			viewFactory().render({
				nsItems: nsItems,
				wikiItems: wikiItems,
				discussions: discussions
			});
		});
	});

	liftigniter.fetch('ns');
	liftigniter.fetch('wiki');
	discussions.fetch();

	// TODO handle errors
	// TODO LI tracking

	function handleError(viewModule) {
		return function (errorMessage) {
			log(errorMessage, 'info', logGroup);

			if (viewModule === 'ext.wikia.recirculation.views.premiumRail') {
				require([
					'ext.wikia.recirculation.helpers.fandom',
					viewModule
				], function (helper, view) {
					helper({
						type: 'community',
						fill: true,
						limit: 10
					}).loadData()
						.done(function (data) {
							view().render(data);
						});
				});
			}
		};
	}
	fetchFandom();
	function fetchFandom() {
		var deferred = $.Deferred();
		var fandomOptions = {
			max: 17,
			widget: 'wikia-impactfooter',
			source: 'fandom',
			opts: {
				resultType: 'cross-domain',
				domainType: 'fandom.wikia.com'
			}
		};
		var configuredHelper = liftigniter(fandomOptions);
		configuredHelper.loadData()
			.done(function (data) {
				deferred.resolve(data);
				console.log(data);

				var articleCards = $('.mcf-card-wiki-article__title');
				var articleBackgrounds = $('a.mcf-card.mcf-card-wiki-article');
				$.each(articleCards, function (index) {
					this.innerText = data.items[index].title;
				});

				$.each(articleBackgrounds, function (index) {
					$(this).attr('style', 'background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), #000000), url(' + data.items[index].thumbnail +')');
					$(this).attr('href', data.items[index].url)
				});


				console.log(articleBackgrounds);

			})
			.fail(function (err) {
				deferred.reject(err);
			});
	}
});
