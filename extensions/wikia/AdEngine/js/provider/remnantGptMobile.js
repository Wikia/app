/*global define*/
define('ext.wikia.adEngine.provider.remnantGptMobile', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slot.adUnitBuilder',
	'ext.wikia.adEngine.slot.service.megaAdUnitBuilder'
], function (adContext, factory, adUnitBuilder, megaAdUnitBuilder) {
	'use strict';

	var src = 'mobile_remnant';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.remnantGptMobile',
		'RemnantGptMobile',
		src,
		{
			MOBILE_TOP_LEADERBOARD:     {size: '300x50,320x50,320x100,320x480,2x2'},
			MOBILE_BOTTOM_LEADERBOARD:  {size: '320x480,2x2'},
			MOBILE_IN_CONTENT:          {size: '320x50,300x250,300x50,320x480'},
			MOBILE_PREFOOTER:           {size: '320x50,300x250,300x50'}
		},
		{
			buildAdUnit: function (slotName, passback) {
				var builder = adContext.getContext().opts.enableRemnantNewAdUnit ? megaAdUnitBuilder : adUnitBuilder;
				return builder.build(src, slotName, passback);
			}

		});
});
