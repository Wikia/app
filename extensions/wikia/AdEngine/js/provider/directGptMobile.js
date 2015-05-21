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
			MOBILE_TOP_LEADERBOARD:     {size: '320x50,320x100,1x1'},
			MOBILE_IN_CONTENT:          {size: '300x250,1x1'},
			MOBILE_PREFOOTER:           {size: '300x250,1x1'},
			INCONTENT_PLAYER:           {size: '640x400', 'pos': 'incontent_player'}
		}
	);
});
