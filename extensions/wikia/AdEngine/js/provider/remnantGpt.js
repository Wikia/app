/*global define*/
define('ext.wikia.adEngine.provider.remnantGpt', [
	'ext.wikia.adEngine.provider.factory.wikiaGpt',
	'ext.wikia.adEngine.slotTweaker'
], function (factory, slotTweaker) {
	'use strict';

	return factory.createProvider(
		'ext.wikia.adEngine.provider.remnantGpt',
		'RemnantGpt',
		'remnant',
		{
			EXIT_STITIAL_BOXAD_1: {size: '300x250,600x400,800x450,550x480', loc: 'exit'},
			HOME_TOP_LEADERBOARD: {
				size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			HOME_TOP_RIGHT_BOXAD: {size: '300x250,300x600,300x1050', loc: 'top'},
			INCONTENT_1A: {size: '300x250', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1B: {size: '300x250,160x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_1C: {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_1'},
			INCONTENT_2A: {size: '300x250', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_2B: {size: '300x250,160x600', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_2C: {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_2'},
			INCONTENT_3A: {size: '300x250', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_3B: {size: '300x250,160x600', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_3C: {size: '300x250,160x600,300x600', loc: 'middle', pos: 'incontent_3'},
			INCONTENT_BOXAD_1: {size: '300x250', loc: 'middle'},
			INCONTENT_LEADERBOARD_1: {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_LEADERBOARD_2: {size: '728x90,468x90', loc: 'middle'},
			INCONTENT_LEADERBOARD_3: {size: '728x90,468x90', loc: 'middle'},
			INVISIBLE_SKIN: {size: '1000x1000,1x1', loc: 'top'},
			LEFT_SKYSCRAPER_2: {size: '160x600', loc: 'middle'},
			LEFT_SKYSCRAPER_3: {size: '160x600', loc: 'footer'},
			PREFOOTER_LEFT_BOXAD: {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD: {size: '300x250', loc: 'footer'},
			TOP_LEADERBOARD: {
				size: '728x90,1030x130,1030x65,1030x250,970x365,970x250,970x90,970x66,970x180,980x150',
				loc: 'top'
			},
			TOP_RIGHT_BOXAD: {size: '300x250,300x600,300x1050', loc: 'top'}
		},
		{
			beforeSuccess: function (slotName) {
				slotTweaker.removeDefaultHeight(slotName);
				slotTweaker.removeTopButtonIfNeeded(slotName);
				slotTweaker.adjustLeaderboardSize(slotName);
			}
		}
	);
});
