/*global define,require*/
define('ext.wikia.recirculation.recirculation', [
	'jquery',
	'wikia.window',
	'wikia.abTest',
	'wikia.nirvana',
	'ext.wikia.adEngine.taboolaHelper',
	'ext.wikia.recirculation.googleMatchHelper',
	'ext.wikia.recirculation.tracker',
	require.optional('videosmodule.controllers.rail')
], function ($, w, abTest, nirvana, taboolaHelper, googleMatchHelper, tracker, videosModule) {
	'use strict';

	var experimentName = 'RECIRCULATION_RAIL';

	function trackClick() {
		tracker.trackVerboseClick(experimentName, 'rail-item');
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
		if (w.wgContentLanguage !== 'en' && videosModule) {
			videosModule(element);
			return;
		}

		var group = abTest.getGroup(experimentName);

		switch (group) {
			case 'GOOGLE_MATCH':
				googleMatchHelper.injectGoogleMatchedContent(element);
				break;
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
				if (!videosModule) {
					return;
				}
				videosModule(element);
				break;
			default:
				return;
		}

		tracker.trackVerboseImpression(experimentName, 'rail');
		$(element).on('mousedown', 'a', trackClick);
	}

	return {
		injectRecirculationModule: injectRecirculationModule
	};
});
