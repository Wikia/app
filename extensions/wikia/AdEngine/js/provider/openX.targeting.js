/*global define*/
define('ext.wikia.adEngine.provider.openX.targeting', [
	'ext.wikia.adEngine.adContext',
	'wikia.geo',
	'wikia.log'
], function (adContext, geo, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.openX.targeting',
		itemMap = {
			/* Desktop */
			'HOME_TOP_LEADERBOARD/notUS/Entertainment':             {size: '728x90',  auid: 537201006},
			'HOME_TOP_LEADERBOARD/notUS/Gaming':                    {size: '728x90',  auid: 537212220},
			'HOME_TOP_LEADERBOARD/notUS/Lifestyle':                 {size: '728x90',  auid: 537212241},
			'HOME_TOP_LEADERBOARD/US/Entertainment':                {size: '728x90',  auid: 537155638},
			'HOME_TOP_LEADERBOARD/US/Gaming':                       {size: '728x90',  auid: 537211356},
			'HOME_TOP_LEADERBOARD/US/Lifestyle':                    {size: '728x90',  auid: 537211385},

			'INCONTENT_BOXAD_1/notUS/Entertainment':                {size: '300x250',  auid: 537201005},
			'INCONTENT_BOXAD_1/notUS/Gaming':                       {size: '300x250',  auid: 537212217},
			'INCONTENT_BOXAD_1/notUS/Lifestyle':                    {size: '300x250',  auid: 537227746},
			'INCONTENT_BOXAD_1/US/Entertainment':                   {size: '300x250',  auid: 537155637},
			'INCONTENT_BOXAD_1/US/Gaming':                          {size: '300x250',  auid: 537227743},
			'INCONTENT_BOXAD_1/US/Lifestyle':                       {size: '300x250',  auid: 537227744},

			'HOME_TOP_RIGHT_BOXAD/notUS/Entertainment':             {size: '300x250',  auid: 537200993},
			'HOME_TOP_RIGHT_BOXAD/notUS/Gaming':                    {size: '300x250',  auid: 537212217},
			'HOME_TOP_RIGHT_BOXAD/notUS/Lifestyle':                 {size: '300x250',  auid: 537212238},
			'HOME_TOP_RIGHT_BOXAD/US/Entertainment':                {size: '300x250',  auid: 537155634},
			'HOME_TOP_RIGHT_BOXAD/US/Gaming':                       {size: '300x250',  auid: 537211352},
			'HOME_TOP_RIGHT_BOXAD/US/Lifestyle':                    {size: '300x250',  auid: 537211378},

			'LEFT_SKYSCRAPER_2/notUS/Entertainment':                {size: '160x600',  auid: 537200991},
			'LEFT_SKYSCRAPER_2/notUS/Gaming':                       {size: '160x600',  auid: 537212216},
			'LEFT_SKYSCRAPER_2/notUS/Lifestyle':                    {size: '160x600',  auid: 537212237},
			'LEFT_SKYSCRAPER_2/US/Entertainment':                   {size: '160x600',  auid: 537155639},
			'LEFT_SKYSCRAPER_2/US/Gaming':                          {size: '160x600',  auid: 537211351},
			'LEFT_SKYSCRAPER_2/US/Lifestyle':                       {size: '160x600',  auid: 537211376},

			'LEFT_SKYSCRAPER_3/notUS/Entertainment':                {size: '160x600',  auid: 537200991},
			'LEFT_SKYSCRAPER_3/notUS/Gaming':                       {size: '160x600',  auid: 537212216},
			'LEFT_SKYSCRAPER_3/notUS/Lifestyle':                    {size: '160x600',  auid: 537212237},
			'LEFT_SKYSCRAPER_3/US/Entertainment':                   {size: '160x600',  auid: 537155639},
			'LEFT_SKYSCRAPER_3/US/Gaming':                          {size: '160x600',  auid: 537211351},
			'LEFT_SKYSCRAPER_3/US/Lifestyle':                       {size: '160x600',  auid: 537211376},

			'PREFOOTER_LEFT_BOXAD/notUS/Entertainment':             {size: '300x250',  auid: 537201004},
			'PREFOOTER_LEFT_BOXAD/notUS/Gaming':                    {size: '300x250',  auid: 537212217},
			'PREFOOTER_LEFT_BOXAD/notUS/Lifestyle':                 {size: '300x250',  auid: 537212238},
			'PREFOOTER_LEFT_BOXAD/US/Entertainment':                {size: '300x250',  auid: 537155635},
			'PREFOOTER_LEFT_BOXAD/US/Gaming':                       {size: '300x250',  auid: 537211352},
			'PREFOOTER_LEFT_BOXAD/US/Lifestyle':                    {size: '300x250',  auid: 537211378},

			'PREFOOTER_RIGHT_BOXAD/notUS/Entertainment':            {size: '300x250',  auid: 537201004},
			'PREFOOTER_RIGHT_BOXAD/notUS/Gaming':                   {size: '300x250',  auid: 537212217},
			'PREFOOTER_RIGHT_BOXAD/notUS/Lifestyle':                {size: '300x250',  auid: 537212238},
			'PREFOOTER_RIGHT_BOXAD/US/Entertainment':               {size: '300x250',  auid: 537155635},
			'PREFOOTER_RIGHT_BOXAD/US/Gaming':                      {size: '300x250',  auid: 537211352},
			'PREFOOTER_RIGHT_BOXAD/US/Lifestyle':                   {size: '300x250',  auid: 537211378},

			'TOP_LEADERBOARD/notUS/Entertainment':                  {size: '728x90',  auid: 537201006},
			'TOP_LEADERBOARD/notUS/Gaming':                         {size: '728x90',  auid: 537212220},
			'TOP_LEADERBOARD/notUS/Lifestyle':                      {size: '728x90',  auid: 537212241},
			'TOP_LEADERBOARD/US/Entertainment':                     {size: '728x90',  auid: 537155638},
			'TOP_LEADERBOARD/US/Gaming':                            {size: '728x90',  auid: 537211356},
			'TOP_LEADERBOARD/US/Lifestyle':                         {size: '728x90',  auid: 537211385},

			'TOP_RIGHT_BOXAD/notUS/Entertainment':                  {size: '300x250',  auid: 537200993},
			'TOP_RIGHT_BOXAD/notUS/Gaming':                         {size: '300x250',  auid: 537212217},
			'TOP_RIGHT_BOXAD/notUS/Lifestyle':                      {size: '300x250',  auid: 537212238},
			'TOP_RIGHT_BOXAD/US/Entertainment':                     {size: '300x250',  auid: 537155634},
			'TOP_RIGHT_BOXAD/US/Gaming':                            {size: '300x250',  auid: 537211352},
			'TOP_RIGHT_BOXAD/US/Lifestyle':                         {size: '300x250',  auid: 537211378},

			/* Mobile */
			'MOBILE_IN_CONTENT/notUSnotPL':                         {size: '300x250',  auid: 537208059},
			'MOBILE_IN_CONTENT/US':                                 {size: '300x250',  auid: 537204073},

			'MOBILE_PREFOOTER/notUSnotPL':                          {size: '300x250',  auid: 537208059},
			'MOBILE_PREFOOTER/US':                                  {size: '300x250',  auid: 537204073},

			'MOBILE_TOP_LEADERBOARD/notUSnotPL':                    {size: '320x50',  auid: 537208060},
			'MOBILE_TOP_LEADERBOARD/US':                            {size: '320x50',  auid: 537204074}
		};

	function getItemName(slotName) {
		var params = adContext.getContext().targeting,
			loc = geo.getCountryCode(),
			country = loc === 'US' ? 'US' : 'notUS',
			vertical = '/' + params.wikiVertical,
			itemName = slotName;

		if (params.skin === 'wikiamobile' || params.skin === 'mercury') {
			vertical = '';
			if (loc !== 'PL') {
				country = country + 'notPL';
			}
		}

		itemName += '/' + country + vertical

		log(['getItemName', itemName], 'debug', logGroup);
		return itemName;
	}

	function getItem(slotName) {
		var itemName = getItemName(slotName);

		log(['getItem', itemMap[itemName]], 'debug', logGroup);
		if (!itemMap[itemName]) {
			return;
		}

		return itemMap[itemName];
	}

	return {
		getItem: getItem
	};
});
