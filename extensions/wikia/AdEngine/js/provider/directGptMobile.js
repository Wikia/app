/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt'
], function (adContext, factory) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.directGptMobile',
		'DirectGptMobile',
		'mobile',
		{
			INVISIBLE_HIGH_IMPACT:      {size: '1x1'},
			INVISIBLE_HIGH_IMPACT_2:    {loc: 'hivi'},
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,320x50,320x100,320x480,2x2', loc: 'top'},
			BOTTOM_LEADERBOARD:         {
				size: '320x50,300x250,300x50,2x2',
				sizeMap: adContext.get('opts.additionalBLBSizes') ? [
					{
						viewportSize: [375, 627],
						sizes: [[2, 2], [300, 50], [320, 50], [300, 250], [300, 600]]
					}
				] : [],
				loc: 'footer',
				pos: ['BOTTOM_LEADERBOARD', 'MOBILE_PREFOOTER']
			},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480', loc: 'middle', pos: 'MOBILE_IN_CONTENT'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50', loc: 'footer'},
			INCONTENT_NATIVE:           {
				sizemap: [
					{
						viewportSize: [768, 0],
						sizes: ['fluid']
					}
				],
				loc: 'top'
			}
		},
		{
			firstCallSlots: [
				'MOBILE_TOP_LEADERBOARD'
			],
			testSrc: 'test'
		}
	);
});
