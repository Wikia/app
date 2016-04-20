/*global require*/
require([
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.views.incontent',
	'ext.wikia.recirculation.views.rail',
	'ext.wikia.recirculation.views.footer',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.lateral',
	'ext.wikia.recirculation.helpers.googleMatch',
	'ext.wikia.adEngine.taboolaHelper',
	require.optional('videosmodule.controllers.rail')
], function(
	$,
	w,
	abTest,
	log,
	tracker,
	utils,
	incontentView,
	railView,
	footerView,
	contentLinksHelper,
	fandomHelper,
	lateralHelper,
	googleMatchHelper,
	taboolaHelper,
	videosModule
) {
	var experimentName = 'RECIRCULATION_PLACEMENT',
		logGroup = 'ext.wikia.recirculation.experiments.placement',
		railContainerId = 'RECIRCULATION_RAIL',
		railSelector = '#' + railContainerId,
		group = abTest.getGroup(experimentName),
		isRail = false,
		errorHandled = false,
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
		case 'LATERAL_FANDOM':
			helper = lateralHelper();
			view = railView();
			isRail = true;
			break;
		case 'LATERAL_COMMUNITY':
			helper = lateralHelper({
				type: 'community',
				count: 3
			});
			view = incontentView();
			break;
		case 'DESIGN_ONE':
		case 'DESIGN_TWO':
		case 'DESIGN_THREE':
		case 'DESIGN_FIVE':
			helper = fandomHelper({
				limit: 5
			});
			view = railView({
				formatTitle: true
			});
			isRail = true;
			break;
		case 'DESIGN_FOUR':
			helper = fandomHelper({
				limit: 5
			});
			view = railView({
				formatTitle: true,
				before: injectSubtitle
			});
			isRail = true;
			break;
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
		case 'LATERAL_BOTH':
			renderBothLateralExperiments();
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
			.fail(handleError);
	}

	function handleError(err) {
		if (err) {
			log(err, 'info', logGroup);
		}

		// If there is an error somewhere we render the control group with no tracking
		if (errorHandled) {
			return;
		}

		errorHandled = true;
		afterRailLoads(function() {
			var rail = railView();

			fandomHelper({
				limit: 5
			}).loadData()
				.then(rail.render)
				.fail(function(err) {
					// If this doesn't work, log out why. We tried our best.
					if (err) {
						log(err, 'info', logGroup);
					}
				});
		});
	}

	function injectSubtitle($html) {
		var subtitle = $('<h2>').text($.msg('recirculation-fandom-subtitle'));

		$html.find('.trending').after(subtitle);
		return $html;
	}

	function renderBothLateralExperiments() {
		var incontent = incontentView();

		lateralHelper({
			type: 'community',
			count: 3
		}).loadData()
			.then(incontent.render)
			.then(incontent.setupTracking(experimentName))
			.fail(function(err) {
				// We fail silently for the in-content widget
				if (err) {
					log(err, 'info', logGroup);
				}
			});

		afterRailLoads(function() {
			var rail = railView();

			lateralHelper({
				type: 'fandom',
				count: 5
			}).loadData()
				.then(rail.render)
				.then(rail.setupTracking(experimentName))
				.fail(handleError);
		});
	}

	function renderGoogleIncontent() {
		var section = incontentView().findSuitableSection();

		if (section.exists()) {
			googleMatchHelper.injectGoogleMatchedContent(section);
			tracker.trackVerboseImpression(experimentName, 'in-content');
		}
	}

	function renderTaboola() {
		afterRailLoads(function() {
			taboolaHelper.initializeWidget({
				mode: 'thumbnails-rr2',
				container: railContainerId,
				placement: 'Right Rail Thumbnails 3rd',
				target_type: 'mix'
			});

			tracker.trackVerboseImpression(experimentName, 'rail');
			$(railSelector).on('mousedown', 'a', function() {
				var slot = $(element).parent().index() + 1,
					label = 'rail=slot-' + slot;

				tracker.trackVerboseClick(experimentName, label);
			});
		});
	}
});
