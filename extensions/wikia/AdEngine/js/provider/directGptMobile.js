/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.uapContext',
	'wikia.window'
], function (factory, uapContext, win) {
	'use strict';

	function dispatchNoUapEvent(slotName) {
		if (slotName === 'MOBILE_TOP_LEADERBOARD' && uapContext.getUapId() === undefined) {
			win.dispatchEvent(new Event('wikia.not_uap'));
		}
	}

	return factory.createProvider(
		'ext.wikia.adEngine.provider.directGptMobile',
		'DirectGptMobile',
		'mobile',
		{
			INVISIBLE_HIGH_IMPACT:      {size: '1x1'},
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,300x250,320x50,320x100,320x480'},
			MOBILE_BOTTOM_LEADERBOARD:  {size: '300x50,300x250,320x50,320x100,320x480'},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480'},
			MOBILE_IN_CONTENT_EXTRA_1:  {size: '300x250'},
			MOBILE_IN_CONTENT_EXTRA_2:  {size: '300x250'},
			MOBILE_IN_CONTENT_EXTRA_3:  {size: '300x250'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50'}
		},
		{
			beforeSuccess: dispatchNoUapEvent,
			beforeHop: dispatchNoUapEvent,
			beforeCollapse: dispatchNoUapEvent,
			atfSlots: [
				'MOBILE_TOP_LEADERBOARD',
				'INVISIBLE_HIGH_IMPACT'
			]
		}
	);
});
