/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.views.incontent',
	'ext.wikia.recirculation.views.rail',
	'ext.wikia.recirculation.views.footer',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.googleMatch',
	'ext.wikia.adEngine.taboolaHelper',
	require.optional('videosmodule.controllers.rail')
], function(
	$,
	w,
	abTest,
	tracker,
	utils,
	incontentView,
	railView,
	footerView,
	contentLinksHelper,
	fandomHelper,
	googleMatchHelper,
	taboolaHelper,
	videosModule
) {
	var experimentName = 'RECIRCULATION_PLACEMENT',
		railContainerId = 'RECIRCULATION_RAIL',
		railSelector = '#' + railContainerId,
		group = abTest.getGroup(experimentName),
		isRail = false,
		footerView,
		view,
		helper;

	if (w.wgContentLanguage !== 'en') {
		if (videosModule) {
			videosModule(railSelector);
		}
		return;
	}

	switch (group) {
		case 'FANDOM_RAIL':
			helper = fandomHelper();
			view = railView();
			isRail = true;
			break;
		case 'FANDOM_INCONTENT':
			helper = fandomHelper();
			view = incontentView();
			break;
		case 'FANDOM_FOOTER':
			helper = fandomHelper();
			view = footerView();
			break;
		case 'LINKS_RAIL':
			helper = contentLinksHelper();
			view = railView();
			isRail = true;
			break;
		case 'LINKS_INCONTENT':
			helper = contentLinksHelper();
			view = incontentView();
			break;
		case 'LINKS_FOOTER':
			helper = contentLinksHelper();
			view = footerView();
			break;
		case 'CONTROL':
			helper = fandomHelper({
				limit: 5
			});
			view = railView();
			isRail = true;
			break;
		case 'GOOGLE_INCONTENT':
			renderGoogleIncontent();
			return;
		case 'TABOOLA':
			renderTaboola();
			return;
		default:
			return;
	}

	if (isRail) {
		afterRailLoads(runExperiment);
	} else {
		runExperiment();
	}

	function afterRailLoads(callback) {
		var $rail = $('#WikiaRail');

		if ($rail.find('.loading').exists()) {
			$rail.one('afterLoad.rail', callback);
		} else {
			callback();
		}
	}

	function runExperiment() {
		helper.loadData()
			.then(view.render)
			.then(view.setupTracking(experimentName))
			.fail(function() {});
	}

	function setupLegacyTracking() {
		tracker.trackVerboseImpression(experimentName, 'rail');
		$(railSelector).on('mousedown', 'a', function() {
			tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'rail'));
		});
	}
});
