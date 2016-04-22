require([
	'jquery',
	'mw',
	'wikia.loader',
	'wikia.mustache'
], function ($, mw, loader, mustache) {
	'use strict';

	var dismissCookieName = 'pmp-entry-point-dismissed';

	function init() {
		debugger;

		if (
			mw.config.get('wgAction') !== 'view' ||
			$.cookie(dismissCookieName) ||
			mw.config.get('wgNamespaceNumber') !== 0
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
	}

	function addEntryPoint(resources) {
		debugger;

		loader.processStyle(resources.styles);

		var templateData = {
			bannerType: 'block'
		};

		$('#WikiaPageHeader').prepend(
			mustache.render(resources.mustache[0], templateData)
		);
	}

	$(init);
});
