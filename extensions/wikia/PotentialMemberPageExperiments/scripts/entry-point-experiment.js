require([
	'jquery',
	'mw',
	'wikia.loader',
	'wikia.mustache',
	'wikia.tracker'
], function ($, mw, loader, mustache, tracker) {
	'use strict';

	var $banner,
		dismissCookieName = 'pmp-entry-point-dismissed',
		track = tracker.buildTrackingFunction({
			category: 'potential-member-experiment',
			trackingMethod: 'analytics'
		});

	function init() {
		if (
			mw.config.get('wgAction') !== 'view' ||
			$.cookie(dismissCookieName) ||
			mw.config.get('wgNamespaceNumber') !== 0 ||
			mw.config.get('wgIsMainPage')
		) {
			return;
		}

		$.when(
			loader({
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/PotentialMemberPageExperiments/templates/PMPEntryPoint.mustache',
					styles: '/extensions/wikia/PotentialMemberPageExperiments/styles/entry-point-experiment.scss'
				}
			})
		).done(addEntryPoint);

		$('body').on('click', '.pmp-entry-point-close', close);
	}

	function close() {
		track({
			label: 'close',
			action: tracker.ACTIONS.CLICK
		});
		$banner.remove();
		$.cookie(dismissCookieName, 1, {
			expires: 1,
			path: mw.config.get('wgCookiePath'),
			domain: mw.config.get('wgCookieDomain')
		});
	}

	function addEntryPoint(resources) {
		loader.processStyle(resources.styles);

		var templateData = {
			bannerType: 'block-top'
		};

		$banner = $(mustache.render(resources.mustache[0], templateData));
		$banner.insertAfter($('.header-container'));
	}

	$(init);
});
