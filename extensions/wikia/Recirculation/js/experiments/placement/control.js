/*global define*/
define('ext.wikia.recirculation.experiments.placement.CONTROL', [
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
			limit: 5
		}).loadData()
			.then(curated.injectContent)
			.then(utils.waitForRail)
			.then(view.render)
			.then(view.setupTracking(experimentName))
			.then(curated.setupTracking);
	}

	return {
		run: run
	}

});
