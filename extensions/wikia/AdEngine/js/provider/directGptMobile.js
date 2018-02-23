/*global define*/
define('ext.wikia.adEngine.provider.directGptMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.slot.service.kiloAdUnitBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder',
	'ext.wikia.adEngine.provider.factory.wikiaGpt'
], function (adContext, kiloAdUnitBuilder, megaAdUnitBuilder, factory) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.directGptMobile',
		'DirectGptMobile',
		'mobile',
		{
			INVISIBLE_HIGH_IMPACT:      {size: '1x1'},
			INVISIBLE_HIGH_IMPACT_2:    {loc: 'hivi'},
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,320x50,320x100,320x480,2x2', loc: 'top'},
			// TODO remove in ADEN-6719
			MOBILE_BOTTOM_LEADERBOARD:  {size: '320x50,300x250,300x50,2x2', loc: 'footer', pos: ['MOBILE_BOTTOM_LEADERBOARD', 'BOTTOM_LEADERBOARD', 'MOBILE_PREFOOTER']},
			// TODO remove pos attribute in ADEN-6719
			BOTTOM_LEADERBOARD:         {size: '320x50,300x250,300x50,2x2', loc: 'footer', pos: ['BOTTOM_LEADERBOARD', 'MOBILE_BOTTOM_LEADERBOARD', 'MOBILE_PREFOOTER']},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480', loc: 'middle'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50', loc: 'footer'}
		},
		{
			getAdUnitBuilder: function () {
				return adContext.getContext().opts.megaAdUnitBuilderEnabled ? megaAdUnitBuilder : kiloAdUnitBuilder;
			},
			atfSlots: [
				'MOBILE_TOP_LEADERBOARD'
			],
			testSrc: 'test'
		}
	);
});
