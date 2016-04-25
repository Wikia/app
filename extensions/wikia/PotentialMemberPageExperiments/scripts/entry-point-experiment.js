require([
	'jquery',
	'mw',
	'wikia.window',
	'wikia.loader',
	'wikia.mustache',
	'wikia.tracker'
], function ($, mw, w, loader, mustache, tracker) {
	'use strict';

	var $banner,
		viewportScroll,
		viewportHeight,
		bannerOffset,
		bannerHeight,
		dismissCookieName = 'pmp-entry-point-dismissed',
		track = tracker.buildTrackingFunction({
			category: 'potential-member-experiment',
			trackingMethod: 'analytics'
		});

	function init() {
		if ($.cookie(dismissCookieName)) {
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
	}

	function addEntryPoint(resources) {
		loader.processStyle(resources.styles);

		var templateData = {
			bannerType: 'block-top'
		};

		$banner = $(mustache.render(resources.mustache[0], templateData));
		$banner.insertAfter($('.header-container'))
			.on('click', '.pmp-entry-point-button', onEntryPointClick)
			.on('click', '.pmp-entry-point-close', close);

		bannerOffset = $banner.offset().top;
		bannerHeight = $banner.outerHeight();

		if (isEntryPointInViewport()) {
			trackBannerImpression();
		} else {
			$(w).on('scroll', trackEntryPointInViewport);
		}
	}

	function onEntryPointClick() {
		track({
			label: 'entry-point-click',
			action: tracker.ACTIONS.CLICK
		});
		onBannerDismissed();
	}

	function close() {
		track({
			label: 'close',
			action: tracker.ACTIONS.CLICK
		});
		$banner.remove();
		onBannerDismissed();
	}

	function isEntryPointInViewport() {
		viewportScroll = w.scrollY;
		viewportHeight = w.innerHeight;

		return bannerOffset > viewportScroll &&
			(bannerOffset + bannerHeight) < (viewportScroll + viewportHeight);
	}

	function trackEntryPointInViewport() {
		if (isEntryPointInViewport()) {
			trackBannerImpression();
			$(w).off('scroll', trackEntryPointInViewport);
		}
	}

	function trackBannerImpression() {
		track({
			label: '',
			action: tracker.ACTIONS.VIEW
		});
	}

	function onBannerDismissed() {
		$.cookie(dismissCookieName, 1, {
			expires: 7,
			path: mw.config.get('wgCookiePath'),
			domain: mw.config.get('wgCookieDomain')
		});
	}

	$(init);
});
