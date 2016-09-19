/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.discussions',
	'ext.wikia.recirculation.tracker',
	require.optional('videosmodule.controllers.rail')
], function(
	$,
	w,
	abTest,
	log,
	tracker,
	utils,
	discussions,
	tracker,
	videosModule
) {

	var recircExperiment = w.recircExperiment || false;

	if (!recircExperiment || w.wgContentLanguage !== 'en') {
		if (videosModule) {
			videosModule('#RECIRCULATION_RAIL');
		}
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

		require([viewString], function (viewFactory) {
			$.when.apply($, value)
				.then(function () {
					var view = viewFactory(),
						args = Array.prototype.slice.call(arguments),
						data = {
							title: '',
							items: []
						};

					args.forEach(function (result, index) {
						if (typeof result === 'string') {
							saved[result].then(function(savedData) {
								savedData.items = savedData.items.slice(savedOptions[result].offset);
								data.items = data.items.concat(savedData.items);
							});
						} else {
							if (result.title && data.title.length === 0) {
								data.title = result.title;
							}
							data.items = data.items.concat(result.items);
						}

					});

					data.items = utils.ditherResults(data.items, 4);

					view.render(data)
						.then(view.setupTracking(experimentName));
				});
		});
	});

	if (!views.impactFooter) {
		discussions(function () {
			tracker.trackVerboseImpression(experimentName, 'discussions');
			$('.discussion-timestamp').timeago();

			$('.discussion-thread').click(function () {
				var slot = $(this).index() + 1,
					label = 'discussions-tile=slot-' + slot + '=discussions';
				tracker.trackVerboseClick(experimentName, label);
				window.location = $(this).data('link');
			});

			$('.discussion-link').mousedown(function() {
				tracker.trackVerboseClick(experimentName, 'discussions-link');
			});
		});
	}
});
