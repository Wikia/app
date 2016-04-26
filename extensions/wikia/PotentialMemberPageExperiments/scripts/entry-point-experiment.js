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
		bannerOffset,
		bannerBottomOffset,
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
			},
			GLUE_BOTTOM: {
				type: 'glue-bottom',
				addEntryPoint: function () {
					$('body').append($banner);
					$banner.addClass('initialized');
				}
			},
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

		if (isEntryPointInViewport()) {
			trackBannerImpression();
		} else {
			$(w).on('scroll.trackPMPEntryPoint', $.debounce(200, function() {
				trackEntryPointInViewport();
			}));
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
		return bannerOffset > w.scrollY &&
			bannerBottomOffset < (w.scrollY + w.innerHeight);
	}

	function trackEntryPointInViewport() {
		if (isEntryPointInViewport()) {
			trackBannerImpression();
			$(w).off('scroll.trackPMPEntryPoint');
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
		$(w).off('scroll.trackPMPEntryPoint');
	}

	$(init);
});
