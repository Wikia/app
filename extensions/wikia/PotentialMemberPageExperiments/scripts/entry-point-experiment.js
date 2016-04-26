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
		$viewabilityTracker = $('<div>').addClass('viewability-tracker'),
		viewabilityCounter = 0,
		viewabilityInterval,
		bannerBottomOffset,
		bannerHeight50p,
		bannerOffset,
		dismissCookieName = 'pmp-entry-point-dismissed',
		track = tracker.buildTrackingFunction({
			category: 'potential-member-experiment',
			trackingMethod: 'analytics'
		});

	function init() {
		if ($.cookie(dismissCookieName)) {
			return;
		}

		$('body').prepend($viewabilityTracker);

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
		$banner.insertAfter($('#articleCategories'))
			.on('click', '.pmp-entry-point-button', onEntryPointClick)
			.on('click', '.pmp-entry-point-close', close);

		bannerOffset = $banner.offset().top;
		bannerBottomOffset = bannerOffset + $banner.outerHeight();
		bannerHeight50p = $banner.height() / 2;

		if (isEntryPointInViewport()) {
			checkViewability();
		}

		$(w).on('scroll.trackPMPEntryPoint', $.debounce(50, function() {
			checkViewability();
		}));
	}

	function checkViewability() {
		if (isEntryPointInViewport()) {
			if (viewabilityCounter === 0) {
				trackBannerImpression();
			}
			viewabilityInterval = setInterval(calculateViewability, 10);
		} else if (viewabilityInterval !== undefined) {
			clearInterval(viewabilityInterval);
		}
	}

	function calculateViewability() {
		viewabilityCounter = viewabilityCounter + 10;
		if (viewabilityCounter === 1000) {
			clearInterval(viewabilityInterval);
			$(w).off('scroll.trackPMPEntryPoint');
			trackBannerViewable();
		}
	}

	function isEntryPointInViewport() {
		return bannerOffset > w.scrollY &&
			(bannerBottomOffset - bannerHeight50p) < (w.scrollY + w.innerHeight);
	}

	function trackBannerImpression() {
		track({
			label: 'first-view',
			action: tracker.ACTIONS.VIEW
		});
	}

	function trackBannerViewable() {
		track({
			label: 'viewable',
			action: tracker.ACTIONS.VIEW
		});
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


	function onBannerDismissed() {
		$.cookie(dismissCookieName, 1, {
			expires: 7,
			path: mw.config.get('wgCookiePath'),
			domain: mw.config.get('wgCookieDomain')
		});
		$(w).off('scroll.trackPMPEntryPoint');
	}

	$(init);
});
