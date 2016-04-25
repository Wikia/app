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

		$banner = $(mustache.render(template, { bannerType: group.toLowerCase() }))
			.on('click', '.pmp-entry-point-button', onEntryPointClick)
			.on('click', '.pmp-entry-point-close', close);

		switch (group) {
			case 'TOP': addEntryPointTop(); break;
			case 'IN_ARTICLE': addEntryPointInArticle(); break;
		}
	}

	function addEntryPointTop() {
		$banner.insertAfter($('#WikiaPageHeader .header-container'));
	}

	function addEntryPointInArticle() {
		var $content = $('.mw-content-text'),
			headers = $content.children('h2'),
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
			$content.append($banner);
		}
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
