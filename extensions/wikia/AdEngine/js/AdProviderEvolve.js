window.AdProviderEvolve = function (WikiaTracker, log, window, ghostwriter, document) {
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

	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderEvolve');
		log(slot, 5, 'AdProviderEvolve');

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'evolve'}, 'ga');

		var url = getUrl(slot[0], slot[1]);
		ghostwriter(
			document.getElementById(slot[0]),
			{
				insertType:"append",
				script:{ src:url },
				done:function () {
					log('ghostwriter done', 5, 'AdProviderEvolve');
					log([slot[0], url], 5, 'AdProviderEvolve');
					ghostwriter.flushloadhandlers();
				}
			}
		);
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

		WikiaTracker.trackAdEvent('liftium.hop2', {'ga_category':'hop2/evolve', 'ga_action':'slot ' + slotname, 'ga_label':'9.9' /* FIXME Liftium.formatTrackTime(time, 5) */}, 'ga');

		window.adslots2.push([slotname, null, 'Liftium2', null]);
	}

	function sanitizeSlotname(slotname) {
		log('sanitizeSlotname', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		var re = new RegExp('[A-Z1-9_]+');
		var out = re.exec(slotname);
		log(out, 8, 'AdProviderEvolve');

		if (typeof slotMap[out] == 'undefined') {
			log('error, unknown slotname', 1, 'AdProviderEvolve');
			out = '';
		}

		log(out, 7, 'AdProviderEvolve');
		return out;
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
