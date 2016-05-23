/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.utils.btfBlocker'
], function (factory, btfBlocker) {
	'use strict';

	var provider = factory.createProvider(
		'ext.wikia.adEngine.provider.directGptMobile',
		'DirectGptMobile',
		'mobile',
		{
			INVISIBLE_HIGH_IMPACT:      {size: '1x1'},
			MOBILE_TOP_LEADERBOARD:     {size: '320x50,320x100,300x250,300x50,1x1'},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,1x1'},
			MOBILE_IN_CONTENT_EXTRA_1:  {size: '300x250,1x1'},
			MOBILE_IN_CONTENT_EXTRA_2:  {size: '300x250,1x1'},
			MOBILE_IN_CONTENT_EXTRA_3:  {size: '300x250,1x1'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50,1x1'}
		},
		{
			beforeSuccess: function (slotName) {
				btfBlocker.onSlotResponse(slotName);
			},
			beforeCollapse: function (slotName) {
				btfBlocker.onSlotResponse(slotName);
			},
			beforeHop: function (slotName) {
				btfBlocker.onSlotResponse(slotName);
			}
		}
	);

	btfBlocker.init('mercury', provider.fillInSlot);

	return {
		name: provider.name,
		canHandleSlot: provider.canHandleSlot,
		fillInSlot: btfBlocker.fillInSlotWithDelay
	};
});
