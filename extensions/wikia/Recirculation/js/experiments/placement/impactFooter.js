/*global define*/
define('ext.wikia.recirculation.experiments.placement.IMPACT_FOOTER', [
	'jquery',
	'underscore',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.data',
	'ext.wikia.recirculation.views.rail',
	'ext.wikia.recirculation.views.scroller',
	'ext.wikia.recirculation.views.impactFooter'
], function ($, _, ContentLinks, FandomHelper, DataHelper, RailView, ScrollerView, ImpactFooterView) {

	function run(experimentName) {
		var scrollerView = ScrollerView(),
			fandomData = FandomHelper({
			    type: 'community',
				limit: 5,
				ignoreError: true
			}).loadData(),
			linksData = ContentLinks({
				count: 6,
				extra: 6
			}).loadData();

		$.when(fandomData, linksData)
			.then(formatScrollerData)
			.then(scrollerView.render)
			.then(scrollerView.setupTracking(experimentName));

		return DataHelper({}).loadData()
			.then(formatData)
			.then(renderImpactFooter(experimentName))
			.then(renderRail(experimentName));
	}

	function formatData(data) {
		var railData = {
			title: data.fandom.title,
			items: data.fandom.items.splice(0,5)
		};

		return {
			rail: railData,
			footer: data
		};
	}

	function formatScrollerData(fandomData, linksData) {
		var mergedArray = [].concat(fandomData.items, linksData.items);
		var items = linksData.items;
		var count = fandomData.items.length;

		while(count > 0) {
			var rand = Math.floor(Math.random() * items.length);

			items.splice(rand, 0, fandomData.items.shift());

			count --;
		}

		return {
			title: linksData.title,
			items: items
		};
	}

	function renderImpactFooter(experimentName) {
		return function(data) {
			var view = ImpactFooterView();

			view.render(data.footer)
				.then(view.setupTracking(experimentName));

			return data;
		}
	}

	function renderRail(experimentName) {
		return function(data) {
			var view = RailView();

			return view.render(data.rail)
				.then(view.setupTracking(experimentName));
		}
	}

	return {
		run: run
	}

});
