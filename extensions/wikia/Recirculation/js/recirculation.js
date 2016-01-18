/*global define*/
define('ext.wikia.recirculation.recirculation', [
	'jquery',
	'wikia.abTest',
	'wikia.tracker',
	'wikia.nirvana',
	'videosmodule.controllers.rail',
	'ext.wikia.adEngine.taboolaHelper'
], function ($, abTest, tracker, nirvana, videosModule, taboolaHelper) {
	'use strict';

	function trackClick() {
		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'recirculation',
			label: 'rail',
			trackingMethod: 'analytics'
		});
	}

	function injectFandomPosts(type, element) {
		nirvana.sendRequest({
			controller: 'Recirculation',
			method: 'index',
			data: {
				type: type
			},
			format: 'html',
			type: 'get',
			callback: function (response) {
				$(element).append(response);
			}
		});
	}

	function injectRecirculationModule(element) {
		var group = abTest.getGroup('RECIRCULATION_RAIL');

		switch (group) {
			case 'POPULAR':
				injectFandomPosts('popular', element);
				break;
			case 'SHARES':
				injectFandomPosts('shares', element);
				break;
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
