/*global define*/
define('ext.wikia.recirculation.recirculation', [
	'wikia.abTest',
	'videosmodule.controllers.rail',
	'ext.wikia.adEngine.taboolaHelper'
], function (abTest, videosModule, taboolaHelper) {
	'use strict';

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
	}

	return {
		injectRecirculationModule: injectRecirculationModule
	};
});
