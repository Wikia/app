/*global define*/
define('ext.wikia.recirculation.experiments.placement.FANDOM_TOPIC', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.curatedContent',
	'ext.wikia.recirculation.views.rail'
], function ($, w, utils, FandomHelper, CuratedHelper, RailView) {

	function run(experimentName) {
		var view = RailView(),
			curated = CuratedHelper();

		return FandomHelper({
		    type: 'community',
			limit: 5
		}).loadData()
			.then(curated.injectContent)
			.then(utils.waitForRail)
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
