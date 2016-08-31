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
		views = {};

	recircExperiment.forEach(function(experiment, index) {
		var helperString = 'ext.wikia.recirculation.helpers.' + experiment.helper;

		views[experiment.placement] = views[experiment.placement] || [];

		require([helperString], function (helper) {
			var promise = helper(experiment.options).loadData();

			views[experiment.placement].push(promise);
		});
	});

	$.each(views, function (key, value) {
		var viewString = 'ext.wikia.recirculation.views.' + key;

		require([viewString], function (view) {
			$.when.apply($, value)
				.then(function () {
					var args = Array.prototype.slice.call(arguments),
						data = {
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
