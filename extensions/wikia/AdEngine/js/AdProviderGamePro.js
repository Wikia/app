var AdProviderGamePro = function(ScriptWriter, WikiaTracker, log, window, document) {
	var ord = Math.round(Math.random() * 23456787654);
	var slotMap = {
	   'HOME_TOP_LEADERBOARD': {'tile': 1, 'pos': "leadfull", 'dcopt': "ist"},
	   'HOME_TOP_RIGHT_BOXAD': {'tile': 3, 'pos': "mpu"},
	   'LEFT_SKYSCRAPER_2': {'tile': 2, 'pos': "sky"},
	   'PREFOOTER_LEFT_BOXAD': {'tile': 4, 'pos': "mpu2"},
	   'TOP_LEADERBOARD': {'tile': 1, 'pos': "leadfull", 'dcopt': "ist"},
	   'TOP_RIGHT_BOXAD': {'tile': 3, 'pos': "mpu"}
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

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'gamepro'}, 'ga');
		ScriptWriter.injectScriptByUrl(slot[0], getUrl(slot[0], slot[1]));
	}

	// adapted for GP + simplified copy of AdConfig.DART.getUrl
	function getUrl(slotname, size) {
		log('getUrl', 5, 'AdProviderGamePro');
		log([slotname, size], 5, 'AdProviderGamePro');

		var url = 'http://' +
			'ad-emea' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'ow-wikia.com' + '/' + 'wka.' + window.cityShort + ';' +
			's1=' + '_' + window.wgDBname + ';' +
			'pos=' + slotMap[slotname].pos + ';' +
			(window.wgDartCustomKeyValues ? rebuildKV(window.wgDartCustomKeyValues) + ';' : '' ) +
			'tile=' + slotMap[slotname].tile + ';' +
			(slotMap[slotname].dcopt ? 'dcopt=' + slotMap[slotname].dcopt + ';' : '') +
			'sz=' + size + ';' +
			'ord=' + ord + '?';

		log(url, 7, 'AdProviderGamePro');
		return url;
	}

	// TODO: cache it
	function rebuildKV(kv) {
		log('rebuildKV', 5, 'AdProviderGamePro');
		log(kv, 5, 'AdProviderGamePro');

		if (kv.indexOf(';') === -1) {
			return kv;
		}

		kv = kv.split(';');
		kv.sort();

		var out = '', last_k = '';
		for (var i = 0; i < kv.length; i++) {
			var k_v = kv[i].split('=');
			if (k_v[0] == last_k) {
				out = out + ',' + k_v[1];
			} else {
				out = out + ';' + k_v[0] + '=' + k_v[1];
				last_k = k_v[0];
			}
		}

		out = out.substring(1);
		log(out, 7, 'AdProviderGamePro');
		return out;
	}

	var iface = {
		name: 'GamePro',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot
	};

	// TODO: @mech rethink
	// TODO: @rychu change tests
	if (window.wgInsideUnitTest) {
		iface.rebuildKV = rebuildKV;
	}

	return iface;

};