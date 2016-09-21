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
	'ext.wikia.recirculation.views.scroller',
	'ext.wikia.recirculation.views.impactFooter',
	'ext.wikia.recirculation.helpers.contentLinks',
	'ext.wikia.recirculation.helpers.fandom',
	'ext.wikia.recirculation.helpers.data',
	'ext.wikia.recirculation.helpers.cakeRelatedContent',
	'ext.wikia.recirculation.helpers.curatedContent',
	'ext.wikia.recirculation.helpers.googleMatch',
	'ext.wikia.recirculation.experiments.placement.IMPACT_FOOTER',
	'ext.wikia.recirculation.experiments.placement.FANDOM_TOPIC',
	'ext.wikia.recirculation.experiments.placement.CONTROL',
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
	scrollerView,
	impactFooterView,
	contentLinksHelper,
	fandomHelper,
	dataHelper,
	cakeHelper,
	curatedHelper,
	googleMatchHelper,
	impactFooterExperiment,
	fandomTopicExperiment,
	controlExperiment,
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
		case 'FANDOM_GENRE':
			helper = fandomHelper({
				type: 'vertical',
				limit: 5
			});
			view = railView();
			isRail = true;
			break;
		case 'FANDOM_HERO':
			helper = fandomHelper({
				type: 'hero',
				limit: 5
			});
			view = railView();
			isRail = true;
			break;
		case 'SDCC':
			helper = fandomHelper({
				type: 'category',
				limit: 5
			});
			view = railView();
			isRail = true;
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
		case 'LINKS_SCROLLER':
			helper = contentLinksHelper({
			    count: 6,
			    extra: 6
			});
			view = scrollerView();
			break;
		case 'GOOGLE_INCONTENT':
			renderGoogleIncontent();
			return;
		case 'TABOOLA':
			renderTaboola();
			return;
		case 'CAKE_RELATED_CONTENT':
			helper = cakeHelper();
			view = railView();
			isRail = true;
			break;
		case 'IMPACT_FOOTER':
			impactFooterExperiment.run(experimentName);
			return;
		case 'FANDOM_TOPIC':
			fandomTopicExperiment.run(experimentName)
				.fail(handleError);
			return;
		case 'CONTROL':
			controlExperiment.run(experimentName)
				.fail(handleError);
			return;
		default:
			return;
	}

	if (isRail) {
		runRailExperiment();
	} else {
		runExperiment();
	}

	function runExperiment() {
		helper.loadData()
			.then(view.render)
			.then(view.setupTracking(experimentName))
			.fail(handleError);
	}

	function runRailExperiment() {
		var curated = curatedHelper();

		log('Rail loaded, running experiment', 'info', logGroup);
		helper.loadData()
			.then(curated.injectContent)
			.then(view.render)
			.then(function($html) {
				view.setupTracking(experimentName)($html);
				curated.setupTracking($html);
			})
			.fail(handleError);
	}

	function handleError(err) {
		var rail;

		if (err) {
			log(err, 'info', logGroup);
		}

		// If there is an error somewhere we render the control group with no tracking
		if (errorHandled) {
			return;
		}

		rail = railView();
		errorHandled = true;

		fandomHelper({
			limit: 5
		}).loadData()
			.then(rail.render)
			.then(setupFallbackTracking)
			.fail(function(err) {
				// If this doesn't work, log out why. We tried our best.
				if (err) {
					log(err, 'info', logGroup);
				}
			});
	}

	function setupFallbackTracking($html) {
		var groupName = 'CONTROL_FALLBACK',
			position = 'rail',
			impressionLabel = [experimentName, groupName, position].join('=');

		tracker.trackImpression(impressionLabel);

		$html.on('mousedown', 'a', function() {
			var clickLabel = [experimentName, groupName, utils.buildLabel(this, position)].join('=');

			tracker.trackClick(clickLabel);
		});

		return $html;
	}

	function injectSubtitle($html) {
		var subtitle = $('<h2>').text($.msg('recirculation-fandom-subtitle'));

		$html.find('.trending').after(subtitle);
		return $html;
	}

	function renderGoogleIncontent() {
		var section = incontentView().findSuitableSection();

		if (section.exists()) {
			googleMatchHelper.injectGoogleMatchedContent(section);
			tracker.trackVerboseImpression(experimentName, 'in-content');
		}
	}

	function renderTaboola() {
		utils.afterRailLoads(function() {
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
