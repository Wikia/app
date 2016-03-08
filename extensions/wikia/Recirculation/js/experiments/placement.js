/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'ext.wikia.recirculation.views.incontent',
	'ext.wikia.recirculation.views.rail',
	'ext.wikia.recirculation.views.footer',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.adEngine.taboolaHelper',
	require.optional('videosmodule.controllers.rail')
], function($, w, abTest, incontentView, railView, footerView, contentLinksHelper, fandomHelper, taboolaHelper, videosModule) {
	var experimentName = 'RECIRCULATION_PLACEMENT',
		railContainerId = 'RECIRCULATION_RAIL',
		group = abTest.getGroup(experimentName),
		isRail = false,
		footerView,
		view,
		helper;

	if (w.wgContentLanguage !== 'en' && videosModule) {
		videosModule('#' + railContainerId);
		return;
	}

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
			fandomHelper.injectHtml('recent_popular', '#' + railContainerId);
			break;
		case 'TABOOLA':
			taboolaHelper.initializeWidget({
				mode: 'thumbnails-rr2',
				container: railContainerId,
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
