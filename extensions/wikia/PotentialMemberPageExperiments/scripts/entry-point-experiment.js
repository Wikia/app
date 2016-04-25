require([
	'jquery',
	'mw',
	'wikia.loader',
	'wikia.mustache',
	'wikia.tracker',
	'wikia.abTest'
], function ($, mw, loader, mustache, tracker, abTest) {
	'use strict';

	var $banner,
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
	}

	function onEntryPointClick() {
		track({
			label: 'entry-point-click',
			action: tracker.ACTIONS.CLICK
		});
		setDismissCookie();
	}

	function close() {
		track({
			label: 'close',
			action: tracker.ACTIONS.CLICK
		});
		$banner.remove();
		setDismissCookie();
	}

	function setDismissCookie() {
		$.cookie(dismissCookieName, 1, {
			expires: 7,
			path: mw.config.get('wgCookiePath'),
			domain: mw.config.get('wgCookieDomain')
		});
	}

	$(init);
});
