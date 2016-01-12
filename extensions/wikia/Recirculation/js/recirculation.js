/*global define*/
define('ext.wikia.recirculation.recirculation', [
	'wikia.log',
	'wikia.window',
	'wikia.abTest',
	'videosmodule.controllers.rail'
], function (log, win, abTest, videosModule) {
	'use strict';

	var logGroup = 'ext.wikia.recirculation.recirculation',
		$ = win.$;

	function injectVideosModule ( element ) {
		videosModule(element);
	}

	function injectTaboola( element ) {
		win._taboola = win._taboola || [];
		win._taboola.push({
			mode: 'thumbnails-rr2',
			container: element.id,
			placement: 'Right Rail Thumbnails 3rd',
			target_type: 'mix'
		});
	}

	function injectRecirculationModule ( element ) {
		var group = abTest.getGroup('RECIRCULATION_RAIL');

		switch (group) {
			case 'TABOOLA':
				injectTaboola(element);
				break;
			case 'VIDEOS_MODULE':
			default:
				injectVideosModule(element);
				break;
		}
	}

	return {
		injectRecirculationModule: injectRecirculationModule
	};
});
