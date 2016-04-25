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
		experimentName = 'POTENTIAL_MEMBER_PAGE_ENTRY_POINTS',
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
		var group = abTest.getGroup(experimentName);

		loader.processStyle(resources.styles);

		switch (group) {
			case 'TOP': addEntryPointTop(resources.mustache[0]);break;
			case 'IN_ARTICLE': addEntryPointInArticle(resources.mustache[0]);break;
		}
	}

	function addEntryPointTop(template) {
		var templateData = {
			bannerType: 'block-top'
		};

		$banner = $(mustache.render(template, templateData));
		$banner.insertAfter($('#WikiaPageHeader .header-container')).on('click', '.pmp-entry-point-close', close);
	}

	function addEntryPointInArticle(template) {
		var templateData = {
				bannerType: 'block-in-article'
			},
			$content = $('.mw-content-text'),
			headers = $content.children('h2'),
			$header;

		$banner = $(mustache.render(template, templateData));

		if (headers.length >= 2) {
			$header = headers.eq(0);

			if ($header.prevAll('p').length) {
				$banner.insertBefore($header);
			} else {
				$banner.insertBefore(headers.eq(1));
			}
		} else {
			$content.append($banner);
		}

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

	$(init);
});
