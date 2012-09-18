var AdProviderEvolve = function (ScriptWriter, WikiaTracker, log, window, document) {
	var slotMap = {
		'HOME_TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250,300x600'},
		'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600'},
		'TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250,300x600'}
	};

	function canHandleSlot(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, 'AdProviderEvolve');
		log([slotname], 5, 'AdProviderEvolve');

		if (slotMap[slotname]) {
			return true;
		}

		return false;
	}

	var slotTimer2 = {};

	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderEvolve');
		log(slot, 5, 'AdProviderEvolve');

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'evolve'}, 'ga');

		slotTimer2[slot[0]] = new Date().getTime();
		log('slotTimer2 start for ' + slot[0], 7, 'AdProviderEvolve');

		ScriptWriter.injectScriptByUrl(slot[0], getUrl(slot[0], slot[1]));
	}

	var ord = Math.round(Math.random() * 23456787654);

	// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
	function getUrl(slotname, size) {
		log('getUrl', 5, 'AdProviderEvolve');
		log([slotname, size], 5, 'AdProviderEvolve');

		var sect = getSect();
		var url = 'http://' +
			'n4403ad' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'gn.wikia4.com' + '/' +
			 sect + ';' +
			'sect=' + sect + ';' +
			'mtfInline=true;' +
			'pos=' + slotname + ';' +
			'sz=' + slotMap[slotname].size + ';' +
			(slotMap[slotname].dcopt ? 'dcopt=' + slotMap[slotname].dcopt + ';' : '') +
			'type=pop;type=int;' + // TODO remove?
			'tile=' + slotMap[slotname].tile + ';' +
			'ord=' + ord + '?';

		log(url, 7, 'AdProviderEvolve');
		return url;
	}

	function getSect() {
		log('getSect', 5, 'AdProviderEvolve');

		var kv = window.wgWikiFactoryTagNames || [];
		var hub = window.cscoreCat || '';

		var sect;
		if (window.wgDBname == 'wikiaglobal') {
			sect = 'home';
		} else if (kv.indexOf('movies') != -1) {
			sect = 'movies';
		} else if (kv.indexOf('tv') != -1) {
			sect = 'tv';
		} else if (hub == 'Entertainment') {
			sect = 'entertainment';
		} else if (hub == 'Gaming') {
			sect = 'gaming';
		} else {
			sect = 'ros';
		}

		log(sect, 7, 'AdProviderEvolve');
		return sect;
	}

	function hop(slotname) {
		log('hop', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		slotname = sanitizeSlotname(slotname);
		var size = slotMap[slotname].size || '0x0';
		log([slotname, size], 7, 'AdProviderEvolve');

		var time = new Date().getTime() - slotTimer2[slotname];
		log('slotTimer2 end for ' + slotname + ' after ' + time + ' ms', 7, 'AdProviderEvolve');
		WikiaTracker.trackAdEvent('liftium.hop2', {'ga_category':'hop2/evolve', 'ga_action':'slot ' + slotname, 'ga_label':formatTrackTime(time, 5)}, 'ga');

		window.adslots2.push([slotname, null, 'Liftium2', null]);
	}

	function sanitizeSlotname(slotname) {
		log('sanitizeSlotname', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		var re = new RegExp('[A-Z1-9_]+');
		var out = re.exec(slotname);
		log(out, 8, 'AdProviderEvolve');

		if (out) out = out[0];

		if (typeof slotMap[out] == 'undefined') {
			log('error, unknown slotname', 1, 'AdProviderEvolve');
			out = '';
		}

		log(out, 7, 'AdProviderEvolve');
		return out;
	}

	// copy of Liftium.formatTrackTime
	// TODO refactor out... AdEngine2Helper? WikiaTracker?
	function formatTrackTime(t, max) {
		if (isNaN(t)) {
			log('Error, time tracked is NaN: ' + t, 7, 'AdProviderEvolve');
			return "NaN";
		}

		if (t < 0) {
			log('Error, time tracked is a negative number: ' + t, 7, 'AdProviderEvolve');
			return "negative";
		}

		t = t / 1000;
		if (t > max) {
			return "more_than_" + max;
		}

		return t.toFixed(1);
	}

	var iface = {
		name: 'Evolve',
		fillInSlot: fillInSlot,
		canHandleSlot: canHandleSlot,
		hop: hop
	};

	// TODO: @mech rethink
	// TODO: @rychu change tests
	if (window.wgInsideUnitTest) {
		iface.sanitizeSlotname = sanitizeSlotname;
		iface.getUrl = getUrl;
		iface.getSect = getSect;
	}

	return iface;

};
