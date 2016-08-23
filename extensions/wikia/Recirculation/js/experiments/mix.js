/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.views.rail',
	'ext.wikia.recirculation.views.scroller',
	'ext.wikia.recirculation.views.impactFooter',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.data',
	'ext.wikia.recirculation.helpers.curatedContent',
	'ext.wikia.adEngine.taboolaHelper',
	require.optional('videosmodule.controllers.rail')
], function(
	$,
	w,
	abTest,
	log,
	tracker,
	utils,
	railView,
	scrollerView,
	impactFooterView,
	contentLinksHelper,
	fandomHelper,
	dataHelper,
	curatedHelper,
	videosModule
) {
	var experimentName = 'RECIRCULATION_MIX',
		logGroup = 'ext.wikia.recirculation.experiments.mix',
		group = abTest.getGroup(experimentName);

	var queue = {
		rail: [],
		scroller: [],
		impactFooter: []
	};

	var views = {
		rail: {
			controller: railView,
			queue: []
		},
		scroller: {
			controller: scrollerView,
			queue: []
		},
		impactFooter: {
			controller: impactFooterView,
			queue: []
		}
	};

	var helpers = {
		fandom: fandomHelper,
		wiki: contentLinksHelper,
		data: dataHelper
	};

	if (!recircExperiment) {
		return;
	}

	recircExperiment.forEach(function(experiment, index) {
		var promise = helpers[experiment.source](experiment.options).loadData();

		views[experiment.placement].queue.push(promise);
	});

	$.each(views, function(key, value) {
		$.when.apply($, value.queue)
			.then(function() {
				var args = Array.prototype.slice.call(arguments),
					data = {
						title: args[0].title,
						items: []
					};

				args.forEach(function(promise, index) {
					data.items = data.items.concat(promise.items);
				});

				data.items = utils.ditherResults(data.items, 4);

				value.controller().render(data);
			});
	});
});
