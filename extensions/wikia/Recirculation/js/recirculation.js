/*global define*/
define('ext.wikia.recirculation.recirculation', [
	'jquery',
	'wikia.abTest',
	'wikia.tracker',
	'videosmodule.controllers.rail',
	'ext.wikia.adEngine.taboolaHelper'
], function ($, abTest, tracker, videosModule, taboolaHelper) {
	'use strict';

	function trackClick ( e ) {
		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'recirculation',
			label: 'rail',
			trackingMethod: 'analytics'
		});
	}

	function injectRecirculationModule ( element ) {
		var group = abTest.getGroup('RECIRCULATION_RAIL');

		switch (group) {
			case 'TABOOLA':
				taboolaHelper.initializeWidget({
					mode: 'thumbnails-rr2',
					container: element.id,
					placement: 'Right Rail Thumbnails 3rd',
					target_type: 'mix'
				});
				break;
			case 'VIDEOS_MODULE':
			default:
				videosModule(element);
				break;
		}

		$(element).on('click', 'a', trackClick);
	}

	return {
		injectRecirculationModule: injectRecirculationModule
	};
});
