require([
	'jquery',
	'mw',
	'wikia.window',
	'wikia.loader',
	'wikia.mustache',
	'wikia.tracker',
	'wikia.abTest'
], function ($, mw, w, loader, mustache, tracker, abTest) {
	'use strict';

	var $banner,
		viewabilityCounter = 0,
		viewabilityInterval,
		bannerBottomOffset,
		bannerHeight50p,
		bannerOffset,
		dismissCookieName = 'pmp-entry-point-dismissed',
		track = tracker.buildTrackingFunction({
			category: 'potential-member-experiment',
			trackingMethod: 'analytics'
		}),
		experimentGroup = abTest.getGroup('POTENTIAL_MEMBER_PAGE_ENTRY_POINTS'),
		experiments = {
			TOP: {
				type: 'top',
				addEntryPoint: function () {
					$banner.insertAfter($('#WikiaPageHeader .header-container'));
				}
			},
			IN_ARTICLE: {
				type: 'in-article',
				addEntryPoint: function () {
					var headers = mw.util.$content.children('h2'),
						$header;

					// Check if there are headers in content
					if (headers.length >= 2) {
						$header = headers.eq(0);

						// Check if first header is not first node in content
						if ($header.prevAll('p').length) {
							$banner.insertBefore($header);
						} else {
							$banner.insertBefore(headers.eq(1));
						}
					} else {
						mw.util.$content.append($banner);
					}
				}
			}
		};

	function init() {
		if ($.cookie(dismissCookieName)) {
			return;
		}

		if (shouldSetExperiment()) {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						mustache: '/extensions/wikia/PotentialMemberPageExperiments/templates/PMPEntryPoint.mustache',
						styles: '/extensions/wikia/PotentialMemberPageExperiments/styles/entry-point-experiment.scss'
					}
				})
			).done(setExperiment);
		}
	}

	function shouldSetExperiment() {
		return experiments.hasOwnProperty(experimentGroup);
	}

	function setExperiment(resources) {
		var experiment = experiments[experimentGroup];

		loader.processStyle(resources.styles);

		$banner = $(mustache.render(resources.mustache[0], { bannerType: experiment.type }))
			.on('click', '.pmp-entry-point-button', onEntryPointClick)
			.on('click', '.pmp-entry-point-close', close);

		experiment.addEntryPoint();

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
