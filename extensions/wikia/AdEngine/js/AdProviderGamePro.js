var AdProviderGamePro = function(wikiaDart, ScriptWriter, WikiaTracker, log, window, document) {
	var ord = Math.round(Math.random() * 23456787654);
	var slotMap = {
		'HOME_TOP_LEADERBOARD': {'size':'728x90', 'tile': 1, 'pos': 'leadfull', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'size':'300x250,300x600', 'tile': 3, 'pos': 'mpu'},
		'LEFT_SKYSCRAPER_2': {'size':'160x600', 'tile': 2, 'pos': 'sky'},
		'PREFOOTER_LEFT_BOXAD': {'size': '300x250', 'tile': 4, 'pos': 'mpu2'},
		'TOP_LEADERBOARD': {'size':'728x90', 'tile': 1, 'pos': 'leadfull', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'size':'300x250,300x600', 'tile': 3, 'pos': 'mpu'}
	};

	function canHandleSlot(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, 'AdProviderGamePro');
		log([slotname], 5, 'AdProviderGamePro');

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	}

	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderGamePro');
		log(slot, 5, 'AdProviderGamePro');

		var slotname = slot[0]
			, slotsize = slot[1] || slotMap[slotname].size
		;

		WikiaTracker.track({
			eventName: 'liftium.slot2',
			ga_category: 'slot2/' + slotsize.replace(/,.*$/, ''),
			ga_action: slotname,
			ga_label: 'gamepro',
			trackingMethod: 'ad'
		});

		ScriptWriter.injectScriptByUrl(slotname, getUrl(slotname));
	}

	// adapted for GP + simplified copy of AdConfig.DART.getUrl
	function getUrl(slotname) {
		log(['getUrl', slotname], 5, 'AdProviderGamePro');

		var url = 'http://' +
			'ad-emea' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'ow-wikia.com' + '/' + 'wka.' + window.cityShort + ';' +
			's1=' + '_' + window.wgDBname + ';' +
			'pos=' + slotMap[slotname].pos + ';' +
			 wikiaDart.getCustomKeyValues() +
			'tile=' + slotMap[slotname].tile + ';' +
			(slotMap[slotname].dcopt ? 'dcopt=' + slotMap[slotname].dcopt + ';' : '') +
			'sz=' + slotMap[slotname].size + ';' +
			'ord=' + ord + '?';

		log(url, 7, 'AdProviderGamePro');
		return url;
	}

	return {
		name: 'GamePro',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};
};
