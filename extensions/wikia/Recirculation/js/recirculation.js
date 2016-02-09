/*global define*/
define('ext.wikia.recirculation.recirculation', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.tracker',
	'wikia.nirvana',
	'videosmodule.controllers.rail',
	'ext.wikia.adEngine.taboolaHelper'
], function ($, w, abTest, tracker, nirvana, videosModule, taboolaHelper) {
	'use strict';

	function trackClick() {
		tracker.track({
			action: tracker.ACTIONS.CLICK,
			category: 'recirculation',
			label: 'rail',
			trackingMethod: 'analytics'
		});
	}

	function trackImpression() {
		tracker.track({
			action: tracker.ACTIONS.IMPRESSION,
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
		if (w.wgContentLanguage !== 'en') {
			videosModule(element);
			return;
		}

		var group = abTest.getGroup('RECIRCULATION_RAIL');

		switch (group) {
			case 'RECENT_POPULAR':
				injectFandomPosts('recent_popular', element);
				break;
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
				videosModule(element);
				break;
			default:
				videosModule(element);
				return;
		}

		trackImpression();
		$(element).on('mousedown', 'a', trackClick);
	}

	return {
		injectRecirculationModule: injectRecirculationModule
	};
});
