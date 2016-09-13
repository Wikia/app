/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.adEngine.taboolaHelper',
	require.optional('videosmodule.controllers.rail')
], function(
	$,
	w,
	abTest,
	log,
	tracker,
	utils,
	videosModule
) {
	if (!recircExperiment) {
		return;
	}

	var experimentName = 'RECIRCULATION_MIX',
		logGroup = 'ext.wikia.recirculation.experiments.mix',
		group = abTest.getGroup(experimentName),
		views = {},
		saved = {},
		savedOptions = {};

	recircExperiment.forEach(function(experiment, index) {
		views[experiment.placement] = views[experiment.placement] || [];

		if (experiment.helper) {
			var helperString = 'ext.wikia.recirculation.helpers.' + experiment.helper;

			require([helperString], function (helper) {
				var promise = helper(experiment.options).loadData();

				views[experiment.placement].push(promise);

				if (experiment.id) {
					saved[experiment.id] = promise;
				}
			});
		}

		if (experiment.source) {
			views[experiment.placement].push(experiment.source);
			savedOptions[experiment.source] = experiment.options;
		}
	});

	$.each(views, function (key, value) {
		var viewString = 'ext.wikia.recirculation.views.' + key;

		require([viewString], function (view) {
			$.when.apply($, value)
				.then(function () {
					var args = Array.prototype.slice.call(arguments);

					$.each(args, function(index, item) {
						if (typeof item === 'string') {
							saved[item].then(function(data) {
								data.items = data.items.slice(savedOptions[item].offset);
								args[index] = data;
							});
						}
					});

					var data = {
							title: args[0].title,
							items: []
						};



					args.forEach(function (promise, index) {
						data.items = data.items.concat(promise.items);
					});

					data.items = utils.ditherResults(data.items, 4);

					view().render(data);
				});
		});
	});
});
