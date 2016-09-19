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
		saved = {};

	recircExperiment.forEach(function(experiment, index) {
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
