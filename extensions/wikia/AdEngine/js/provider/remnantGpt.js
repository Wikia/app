/*global define*/
define('ext.wikia.adEngine.provider.remnantGpt', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker'
], function (adContext, factory, slotTweaker) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.remnantGpt',
		'RemnantGpt',
		'remnant',
		{
			BOTTOM_LEADERBOARD: {size: '728x90,970x250', loc: 'footer'},
			INCONTENT_BOXAD_1: {size: '120x600,160x600,300x250,300x600', loc: 'hivi'},
			INCONTENT_PLAYER: {size: '1x1', loc: 'middle'},
			INVISIBLE_HIGH_IMPACT_2: {loc: 'hivi'},
			INVISIBLE_SKIN: {size: '1000x1000,1x1', loc: 'top'},
			TOP_LEADERBOARD: {
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			TOP_BOXAD: {
				size: '300x250,300x600,300x1050',
				loc: 'top',
				pos: ['TOP_BOXAD', 'TOP_RIGHT_BOXAD']
			}
		},
		{
			afterSuccess: function (slotName) {
				slotTweaker.removeDefaultHeight(slotName);
			},
			testSrc: 'test-remnant'
		}
	);
});
