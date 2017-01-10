/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'ext.wikia.adEngine.provider.factory.wikiaGpt'
], function (factory) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.directGptMobile',
		'DirectGptMobile',
		'mobile',
		{
			INVISIBLE_HIGH_IMPACT:      {size: '1x1'},
			INVISIBLE_HIGH_IMPACT_2:    {loc: 'hivi'},
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,300x250,320x50,320x100,320x480', loc: 'top'},
			MOBILE_BOTTOM_LEADERBOARD:  {size: '300x50,300x250,320x50,320x100,320x480', loc: 'footer'},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480', loc: 'middle'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50', loc: 'footer'}
		},
		{
			atfSlots: [
				'MOBILE_TOP_LEADERBOARD',
				'INVISIBLE_HIGH_IMPACT',
				'INVISIBLE_HIGH_IMPACT_2'
			]
		}
	);
});
