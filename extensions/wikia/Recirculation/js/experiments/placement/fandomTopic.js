/*global define*/
define('ext.wikia.recirculation.experiments.placement.FANDOM_TOPIC', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.curatedContent',
	'ext.wikia.recirculation.views.rail'
], function ($, w, utils, FandomHelper, CuratedHelper, RailView) {

	function isNot(item) {
		return function(element) {
			return element.title !== item.title;
		}
	}

	function loadData() {
		var popular = FandomHelper({
				type: 'community',
				fill: true,
				limit: 10
			}).loadData(),
			recent = FandomHelper({
				type: 'latest',
				limit: 1,
				ignoreError: true
			}).loadData();

		return $.when(popular, recent)
			.then(function(popularData, recentData) {
				var items = utils.ditherResults(popularData.items, 2).slice(0,5),
					mostRecent = recentData.items[0];

				if (mostRecent && items.every(isNot(mostRecent))) {
					items.unshift(mostRecent);
				}

				popularData.items = items.slice(0,5);

				return popularData;
			});
	}

	function run(experimentName) {
		var view = RailView(),
			curated = CuratedHelper();

		return loadData()
			.then(curated.injectContent)
			.then(view.render)
			.then(view.setupTracking(experimentName))
			.then(curated.setupTracking)
			.then(function($html) {
				// FANDOM_TOPIC is our current control group, we want to track this inside of LI
				if (w.$p) {
					var elements = $html.find('.rail-item').get(),
						trackOptions = {
							elements: elements,
							name: 'fandom-rec',
							source: 'base'
						};

					w.$p('track', trackOptions);
				}
			});
	}

	return {
		run: run
	}

});
