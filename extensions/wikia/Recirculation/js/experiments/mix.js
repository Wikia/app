/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.discussions',
	require.optional('videosmodule.controllers.rail')
], function(
	$,
	w,
	log,
	utils,
	discussions,
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
	 *  		sorce: 'the id you want to use for data - only used if you want to use data across multiple views',
	 *  		placement: 'name of the view',
	 *  		helper: 'name of the helper',
	 *  		options: {
	 *  			any options to pass to the helper
	 *  		}
	 *  	}
	 *  ];
	 *
	 */

	var recircExperiment = w.recircExperiment || false,
		experimentName = 'RECIRCULATION_MIX',
		logGroup = 'ext.wikia.recirculation.experiments.mix',
		views = {},
		saved = {};

	if (!recircExperiment || w.wgContentLanguage !== 'en') {
		if (videosModule) {
			videosModule('#RECIRCULATION_RAIL');
		}
		discussions(experimentName);
		return;
	}

	recircExperiment.forEach(function(experiment) {
		var deferred = $.Deferred();

		views[experiment.placement] = views[experiment.placement] || [];

		if (experiment.id) {
			saved[experiment.id] = deferred;
		}

		if (experiment.helper) {
			var helperString = 'ext.wikia.recirculation.helpers.' + experiment.helper;

			require([helperString], function (helper) {
				helper(experiment.options).loadData()
					.then(function(data) {
						deferred.resolve(data);
					});
			});
		}

		if (experiment.source && saved[experiment.source]) {
			saved[experiment.source].then(function(data) {
				deferred.resolve({
					title: data.title,
					items: data.items.slice(experiment.options.offset)
				});
			});
		}

		views[experiment.placement].push(deferred);
	});

	$.each(views, function (key, value) {
		var viewString = 'ext.wikia.recirculation.views.' + key;

		log('Initializing View: ' + key, 'info', logGroup);
		require([viewString], function (viewFactory) {
			$.when.apply($, value)
				.then(function () {
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

					data.items = utils.ditherResults(data.items, 4);

					view.render(data)
						.then(view.setupTracking(experimentName));
				});
		});
	});

	if (!views.impactFooter) {
		discussions(experimentName);
	}
});
