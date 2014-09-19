/*global define*/
/*jshint camelcase:false*/
/*jshint maxlen:200*/
define('ext.wikia.adEngine.gptSlotConfig', function () {
	'use strict';

	var slotMapConfig = {
		gpt: {
			BOTTOM_LEADERBOARD:         {size: '728x90,300x250', loc: 'bottom'},
			CORP_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			CORP_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			EXIT_STITIAL_BOXAD_1:       {size: '300x250,600x400,800x450,550x480', loc: 'exit'},
			HOME_TOP_LEADERBOARD:       {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			HOME_TOP_RIGHT_BOXAD:       {size: '300x250,300x600,300x1050', loc: 'top'},
			HUB_TOP_LEADERBOARD:        {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			INCONTENT_BOXAD_1:          {size: '300x250', loc: 'middle'},
			INVISIBLE_SKIN:             {size: '1000x1000,1x1', loc: 'top'},
			LEFT_SKYSCRAPER_2:          {size: '160x600', loc: 'middle'},
			LEFT_SKYSCRAPER_3:          {size: '160x600', loc: 'footer'},
			MODAL_INTERSTITIAL:         {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_1:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_2:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_3:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_INTERSTITIAL_4:       {size: '300x250,600x400,800x450,550x480', loc: 'modal'},
			MODAL_RECTANGLE:            {size: '300x100', loc: 'modal'},
			PREFOOTER_LEFT_BOXAD:       {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD:      {size: '300x250', loc: 'footer'},
			TOP_INCONTENT_BOXAD:        {size: '300x250', loc: 'top'},
			TOP_LEADERBOARD:            {size: '728x90,1030x130,1030x65,1030x250,970x250,970x90,970x66,970x180,980x150', loc: 'top'},
			TOP_RIGHT_BOXAD:            {size: '300x250,300x600,300x1050', loc: 'top'},
			WIKIA_BAR_BOXAD_1:          {size: '320x50,320x70,320x100', loc: 'bottom'},
			GPT_FLUSH: 'flushonly'
		},
		mobile: {
			MOBILE_TOP_LEADERBOARD:     {size: '320x50,1x1'},
			MOBILE_IN_CONTENT:          {size: '300x250,1x1'},
			MOBILE_PREFOOTER:           {size: '300x250,1x1'}
		},
		remnant: {
			BOTTOM_LEADERBOARD:         {size: '728x90', loc: 'bottom'},
			EXIT_STITIAL_BOXAD_1:       {size: '300x250'},
			HOME_TOP_LEADERBOARD:       {size: '728x90', loc: 'top'},
			HOME_TOP_RIGHT_BOXAD:       {size: '300x250', loc: 'top'},
			INCONTENT_BOXAD_1:          {size: '300x250', loc: 'middle'},
			LEFT_SKYSCRAPER_2:          {size: '160x600', loc: 'middle'},
			LEFT_SKYSCRAPER_3:          {size: '160x600', loc: 'footer'},
			PREFOOTER_LEFT_BOXAD:       {size: '300x250', loc: 'footer'},
			PREFOOTER_RIGHT_BOXAD:      {size: '300x250', loc: 'footer'},
			TOP_INCONTENT_BOXAD:        {size: '300x250', loc: 'top'},
			TOP_LEADERBOARD:            {size: '728x90', loc: 'top'},
			TOP_RIGHT_BOXAD:            {size: '300x250', loc: 'top'},
			WIKIA_BAR_BOXAD_1:          {size: '300x70', loc: 'bottom'}
		},
		mobile_remnant: {
			MOBILE_TOP_LEADERBOARD:     {size: '320x50,1x1'},
			MOBILE_IN_CONTENT:          {size: '300x250,1x1'},
			MOBILE_PREFOOTER:           {size: '300x250,1x1'}
		}
	};

	// Return a copy of slotMap objects
	function getConfig(src) {
		var undef;

		if (src === undef) {
			return JSON.parse(JSON.stringify(slotMapConfig));
		}

		return JSON.parse(JSON.stringify(slotMapConfig[src]));
	}

	function extendSlotParams(src, slotName, params) {
		if (!(params && slotMapConfig[src] && slotMapConfig[src][slotName])) {
			return false;
		}
		for (var i in params) {
			if (params.hasOwnProperty(i)) {
				slotMapConfig[src][slotName][i] = params[i];
			}
		}
	}

	return {
		getConfig: getConfig,
		extendSlotParams: extendSlotParams
	};
});
