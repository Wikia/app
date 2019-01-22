/*global define*/
define('ext.wikia.adEngine.provider.remnantGptMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slot.adUnitBuilder'
], function (adContext, factory, adUnitBuilder) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.remnantGptMobile',
		'RemnantGptMobile',
		'mobile_remnant',
		{
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,320x50,320x100,320x480'},
			BOTTOM_LEADERBOARD:         {
				size: '320x50,300x250,300x50',
				sizeMap: adContext.get('opts.additionalBLBSizes') ? [
					{
						viewportSize: [375, 627],
						sizes: [[300, 50], [320, 50], [300, 250], [300, 600]]
					}
				] : [],
				pos: ['BOTTOM_LEADERBOARD', 'MOBILE_PREFOOTER']
			},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50'}
		},
		{
			getAdUnitBuilder: function () {
				return adUnitBuilder;
			},
			testSrc: 'test-remnant'
		});
});
