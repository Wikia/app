require([
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.discussions',
	'ext.wikia.recirculation.helpers.liftigniter',
	require.optional('videosmodule.controllers.rail')
], function (
	$,
	w,
	log,
	utils,
	discussions,
	liftigniter,
	videosModule
) {
	/**
	 *
	 * This test is setup using the AB testing tool.
	 * We inject a variable called recircExperiment that dictates which content
	 * gets rendered in which placement. The structure of the variable is:
	 *
	 *  var recircExperiment = [
	 *  	{
	 *  		id: 'unique identifier - only used if you want to use data across multiple views',
	 *  		source: 'the id you want to use for data - only used if you want to use data across multiple views',
	 *  		placement: 'name of the view',
	 *  		helper: 'name of the helper',
	 *  		options: {
	 *  			any options to pass to the helper
	 *  		}
	 *  	}
	 *  ];
	 *
	 */
	'use strict';

	var recircExperiment = w.recircExperiment || false,
		experimentName = 'RECIRCULATION_MIX',
		logGroup = 'ext.wikia.recirculation.experiments.mix',
		views = {}, // Each view holds an array of promises used to gather data for that view
		saved = {}, // Saved data to be used across multiple views
		completed = [], // An array of promises to keep track of which views have completed rendering
		liftigniterHelpers = {};

	if (!recircExperiment || w.wgContentLanguage !== 'en') {
		if (videosModule) {
			videosModule('#RECIRCULATION_RAIL');
		}
		discussions(experimentName);
		return;
	}

	recircExperiment.forEach(function (experiment) {
		var deferred = $.Deferred();

		if (experiment.id) {
			saved[experiment.id] = deferred;
		}

		if (experiment.helper) {
			var helperString = 'ext.wikia.recirculation.helpers.' + experiment.helper;

			require([helperString], function (helper) {
				var configuredHelper = helper(experiment.options);
				configuredHelper.loadData()
					.done(function (data) {
						deferred.resolve(data);
					})
					.fail(function (err) {
						deferred.reject(err);
					});

				if (experiment.helper === 'liftigniter') {
					// We need to keep track of the liftigniter helpers so we can setup tracking for them
					liftigniterHelpers[experiment.id] = configuredHelper;
				}
			});
		}

		if (experiment.source && saved[experiment.source]) {
			saved[experiment.source]
				.done(function (data) {
					var start = experiment.options.offset || 0,
						end = experiment.options.limit || data.items.length,
						items = data.items.slice(start).slice(0, end);

					deferred.resolve({
						title: data.title,
						items: items
					});
				})
				.fail(function (err) {
					deferred.reject(err);
				});
		}

		if (experiment.placement) {
			views[experiment.placement] = views[experiment.placement] || [];
			views[experiment.placement].push(deferred);
		}
	});

	$.each(views, function (key, promises) {
		var viewString = 'ext.wikia.recirculation.views.' + key,
			deferred = $.Deferred();

		completed.push(deferred);

		log('Initializing View: ' + key, 'info', logGroup);
		require([viewString], function (viewFactory) {
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
						.then(view.setupTracking(experimentName))
						.then(deferred.resolve);
				})
				.fail(handleError(key), function () {
					deferred.reject(key);
				});
		});
	});

	$.when.apply($, completed)
		.done(function () {
			log('Finished rendering recirculation', 'info', logGroup);

			$.each(liftigniterHelpers, function (key, helper) {
				helper.setupTracking();
			});
		})
		.fail(function (placement) {
			log('Error running recirc at: ' + placement, 'info', logGroup);
		});

	function handleError (placement) {
		return function (errorMessage) {
			log(errorMessage, 'info', logGroup);

			if (placement === 'rail') {
				require([
					'ext.wikia.recirculation.helpers.fandom',
					'ext.wikia.recirculation.views.rail'
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

	if (!views.impactFooter) {
		discussions(experimentName);
	}
});
