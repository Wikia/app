/*global require*/
require([
	'wikia.abTest',
	'ext.wikia.recirculation.views.incontent',
	'ext.wikia.recirculation.views.rail',
	'ext.wikia.recirculation.views.footer',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.adEngine.taboolaHelper',
], function(abTest, incontentView, railView, footerView, contentLinksHelper, fandomHelper, taboolaHelper) {
	var experimentName = 'RECIRCULATION_PLACEMENT',
		group = abTest.getGroup(experimentName),
		isRail = false,
		footerView,
		view,
		helper;

	switch (group) {
		case 'FANDOM_RAIL':
			helper = fandomHelper;
			view = railView;
			isRail = true;
			break;
		case 'FANDOM_INCONTENT':
			helper = fandomHelper;
			view = incontentView;
			break;
		case 'FANDOM_FOOTER':
			helper = fandomHelper;
			view = footerView;
			break;
		case 'LINKS_RAIL':
			helper = contentLinksHelper;
			view = railView;
			isRail = true;
			break;
		case 'LINKS_INCONTENT':
			helper = contentLinksHelper;
			view = incontentView;
			break;
		case 'LINKS_FOOTER':
			helper = contentLinksHelper;
			view = footerView;
			break;
		case 'CONTROL':

			break;
		case 'TABOOLA':
			taboolaHelper.initializeWidget({
				mode: 'thumbnails-rr2',
				container: 'RECIRCULATION_RAIL',
				placement: 'Right Rail Thumbnails 3rd',
				target_type: 'mix'
			});
			break;
		default:
			return;
	}

	if (isRail) {
		$('#WikiaRail').on('afterLoad.rail', runExperiment);
	} else {
		runExperiment();
	}

	function runExperiment() {
		helper.loadData()
			.then(view.render)
			.then(view.setupTracking(experimentName))
			.fail(function() {});
	}
});
