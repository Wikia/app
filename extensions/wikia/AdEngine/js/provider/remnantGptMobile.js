/*global define*/
define('ext.wikia.adEngine.provider.remnantGptMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder'
], function (adContext, factory, adUnitBuilder, megaAdUnitBuilder) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.remnantGptMobile',
		'RemnantGptMobile',
		'mobile_remnant',
		{
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,320x50,320x100,320x480,2x2'},
			BOTTOM_LEADERBOARD:         {size: '320x50,300x250,300x50,2x2'},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50'}
		},
		{
			getAdUnitBuilder: function () {
				return adContext.getContext().opts.enableRemnantNewAdUnit ? megaAdUnitBuilder : adUnitBuilder;
			},
			testSrc: 'test-remnant'
		});
});
