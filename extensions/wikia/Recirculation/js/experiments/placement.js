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
	'ext.wikia.recirculation.helpers.lateral',
	'ext.wikia.recirculation.helpers.liftigniter',
	'ext.wikia.recirculation.helpers.data',
	'ext.wikia.recirculation.helpers.cakeRelatedContent',
	'ext.wikia.recirculation.helpers.curatedContent',
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
	scrollerView,
	impactFooterView,
	contentLinksHelper,
	fandomHelper,
	lateralHelper,
	liftigniterHelper,
	dataHelper,
	cakeHelper,
	curatedHelper,
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
		case 'LI_RAIL':
			renderLiftigniterFandom();
			return;
		case 'LI_COMMUNITY':
			renderLiftigniterCommunity();
			return;
		case 'LI_BOTH':
			renderLiftigniterFandom(true);
			renderLiftigniterCommunity();
			return;
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
		case 'FANDOM_TOPIC':
			helper = fandomHelper({
				type: 'community',
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
		case 'LATERAL_SCROLLER':
			helper = lateralHelper({
				type: 'community',
				count: 12
			});
			view = scrollerView();
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
		case 'CAKE_RELATED_CONTENT':
			helper = cakeHelper();
			view = railView();
			isRail = true;
			break;
		case 'IMPACT_FOOTER':
			renderImpactFooter();
			return;
		default:
			return;
	}

	if (isRail) {
		utils.afterRailLoads(runRailExperiment);
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
		if (err) {
			log(err, 'info', logGroup);
		}

		// If there is an error somewhere we render the control group with no tracking
		if (errorHandled) {
			return;
		}

		errorHandled = true;
		utils.afterRailLoads(function() {
			var rail = railView();

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
		});
	}

	function setupFallbackTracking($html) {
		var groupName = 'CONTROL_FALLBACK',
			position = 'rail',
			impressionLabel = [experimentName, groupName, position].join('='),
			abSlot = abTest.getGASlot(experimentName);

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

		utils.afterRailLoads(function() {
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

	function renderImpactFooter() {
		var curated = curatedHelper(),
			fView = impactFooterView(),
			rView = railView(),
			sView = scrollerView();

		contentLinksHelper({
			count: 6,
			extra: 6
		}).loadData()
			.then(sView.render)
			.then(sView.setupTracking(experimentName));

		dataHelper({}).loadData()
			.then(function(data) {
				var fandomData = {
					title: data.fandom.title,
					items: data.fandom.items.splice(0,5)
				};

				fView.render(data)
					.then(fView.setupTracking(experimentName));

				utils.afterRailLoads(function() {
					curated.injectContent(fandomData)
						.then(rView.render)
						.then(rView.setupTracking)
						.then(curatedHelper.setupTracking);
				});
			});
	}

	function renderLiftigniterFandom(waitToFetch) {
		var view = railView(),
			curated = curatedHelper(),
			helper = liftigniterHelper({
				count: 5,
				widget: 'fandom-rec'
			});

		helper.loadData(waitToFetch)
			.then(curated.injectContent)
			.then(view.render)
			.then(function($html) {
				var elements = $html.find('.rail-item').get();

				view.setupTracking(experimentName)($html);
				curated.setupTracking($html);
				helper.setupTracking(elements);
			})
			.fail(handleError);
	}

	function renderLiftigniterCommunity() {
		var view = incontentView(),
			helper = liftigniterHelper({
				count: 3,
				widget: 'in-wikia'
			});

		helper.loadData()
			.then(view.render)
			.then(function($html) {
				var elements = $html.find('.item').get();

				view.setupTracking(experimentName)($html);
				helper.setupTracking(elements);
			});
	}

});
