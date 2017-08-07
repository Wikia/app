require([
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.discussions',
	'ext.wikia.recirculation.helpers.liftigniter',
	require.optional('videosmodule.controllers.rail')
], function ($,
             w,
             log,
             utils,
             discussions,
             liftigniter,
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

	var recircModules = [
			{
				id: 'LI_rail',
				viewModule: 'ext.wikia.recirculation.views.premiumRail',
				options: {
					max: 5,
					widget: 'wikia-rail',
					source: 'fandom',
					opts: {
						resultType: 'cross-domain',
						domainType: 'fandom.wikia.com'
					}
				}
			},
			// TODO - remove old recirculation footers
			// {
			// 	id: 'LI_impactFooter',
			// 	viewModule: 'ext.wikia.recirculation.views.impactFooter',
			// 	options: {
			// 		max: 9,
			// 		widget: 'wikia-impactfooter',
			// 		source: 'fandom',
			// 		opts: {
			// 			resultType: 'cross-domain',
			// 			domainType: 'fandom.wikia.com'
			// 		}
			// 	}
			// },
			// {
			// 	id: 'LI_footer',
			// 	viewModule: 'ext.wikia.recirculation.views.footer',
			// 	options: {
			// 		max: 3,
			// 		widget: 'wikia-footer-wiki-rec',
			// 		source: 'wiki',
			// 		title: 'Discover New Wikis',
			// 		width: 332,
			// 		height: 187,
			// 		flush: true,
			// 		opts: {
			// 			resultType: 'subdomain',
			// 			domainType: 'fandom.wikia.com'
			// 		}
			// 	}
			// }
		],
		logGroup = 'ext.wikia.recirculation.experiments.mix',
		// Each view holds an array of promises used to gather data for that view
		views = {},
		// An array of promises to keep track of which views have completed rendering
		completed = [],
		liftigniterHelpers = {};

	if (w.wgContentLanguage === 'en') {
		if (videosModule) {
			videosModule('#recirculation-rail');
		}
		discussions();
		return;
	}

	recircModules.forEach(function (recircModule) {
		var deferred = $.Deferred();

		var configuredHelper = liftigniter(recircModule.options);
		configuredHelper.loadData()
			.done(function (data) {
				deferred.resolve(data);
			})
			.fail(function (err) {
				deferred.reject(err);
			});

		// We need to keep track of the liftigniter helpers so we can setup tracking for them
		liftigniterHelpers[recircModule.id] = configuredHelper;

		if (recircModule.viewModule) {
			views[recircModule.viewModule] = views[recircModule.viewModule] || [];
			views[recircModule.viewModule].push(deferred);
		}
	});

	$.each(views, function (viewModule, promises) {
		var deferred = $.Deferred();

		completed.push(deferred);

		log('Initializing View: ' + viewModule, 'info', logGroup);
		require([viewModule], function (viewFactory) {
			$.when.apply($, promises)
				.done(function () {
					var view = viewFactory(),
						args = Array.prototype.slice.call(arguments),
						data = {
							title: '',
							items: []
						};

					log(args, 'info', logGroup);

					args.forEach(function (result) {
						if (!result) {
							return;
						}

						if (result.title && data.title.length === 0) {
							data.title = result.title;
						}

						data.items = data.items.concat(result.items);
					});

					view.render(data)
						.then(view.setupTracking())
						.then(deferred.resolve);
				})
				.fail(handleError(viewModule), function () {
					deferred.reject(viewModule);
				});
		});
	});

	$.when.apply($, completed)
		.done(function () {
			log('Finished rendering recirculation', 'info', logGroup);

			$.each(liftigniterHelpers, function (viewModule, helper) {
				helper.setupTracking();
			});
		})
		.fail(function (viewModule) {
			log('Error running recirc at: ' + viewModule, 'info', logGroup);
		});

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
});
