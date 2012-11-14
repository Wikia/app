var AdProviderEvolve = function (ScriptWriter, WikiaTracker, log, window, document, Krux, evolveHelper, slotTweaker) {
	var slotMap
		, logGroup = 'AdProviderEvolve'
		, ord = Math.round(Math.random() * 23456787654)
		, slotTimer2 = {}
		, slotForSkin = 'INVISIBLE_1'
		, hoppedSlots = {}
	;

	slotMap = {
		'HOME_TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250,300x600'},
		'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600'},
		'TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250,300x600'}
		, 'INVISIBLE_1':{'size':'0x0'}
	};

	function canHandleSlot(slot) {
		var slotname = slot[0];

		log('canHandleSlot', 5, 'AdProviderEvolve');
		log([slotname], 5, 'AdProviderEvolve');

		if (slotMap[slotname]) {
			return true;
		}

		if (slotname === slotForSkin) {
			return true;
		}

		return false;
	}

	function fillInSlot(slot) {
		log('fillInSlot', 5, 'AdProviderEvolve');
		log(slot, 5, 'AdProviderEvolve');

		var slotname = slot[0]
			, slotsize = slot[1] || slotMap[slotname].size
		;

		slotsize = slotsize.replace(/,.*$/, '');
		WikiaTracker.trackAdEvent('liftium.slot2', {
			'ga_category': 'slot2/' + slotsize, 'ga_action': slotname, 'ga_label': 'evolve'
		}, 'ga');

		slotTimer2[slotname] = new Date().getTime();
		log('slotTimer2 start for ' + slotname, 7, 'AdProviderEvolve');

		if (slotname === slotForSkin) {
			ScriptWriter.injectScriptByUrl(
				slot[0], 'http://cdn.triggertag.gorillanation.com/js/triggertag.js',
				function() {
					log('(invisible triggertag) ghostwriter done', 5, logGroup);
					ScriptWriter.injectScriptByText(slotname, getReskinAndSilverScript(slotname));
				}
			);
		} else {
			ScriptWriter.injectScriptByUrl(slotname, getUrl(slotname), function() {
				if (!hoppedSlots[slotname]) {
					slotTweaker.removeDefaultHeight(slotname);
					slotTweaker.removeTopButtonIfNeeded(slotname);
				}
			});
		}
	}

	function getReskinAndSilverScript(slotname) {
		log('getReskinSilverScript', 5, logGroup);

		var script = ''
			, kv = getKv(slotname)
		;

		//<!-- BEGIN TRIGGER TAG INITIALIZATION -->
		//script += '<script type="text/javascript" src="http://cdn.triggertag.gorillanation.com/js/triggertag.js"></script>' + '\n';
		//script += '<script type="text/javascript">' + '\n';
		script += "getTrigger('8057');" + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 1000x1000 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406815)=='undefined' || f406815 > 0) ) {" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/";
		script += kv + ";sz=1000x1000;tile=1;ord=" + ord + "?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		//<!-- BEGIN GN Ad Tag for Wikia 47x47 entertainment -->
		//script += '<script type="text/javascript">' + '\n';
		script += "if ((typeof(f406785)=='undefined' || f406785 > 0) ) {" + '\n';
		script += "document.write('<scr'+'ipt src=\"http://n4403ad.doubleclick.net/adj/gn.wikia4.com/";
		script += kv + ";sz=47x47;tile=2;ord=" + ord + "?\" type=\"text/javascript\"></scr'+'ipt>');" + '\n';
		script += '}' + '\n';
		//script += '</script>' + '\n';

		log(script, 7, logGroup);
		return script;
	}

	function getKv(slotname) {
		var sect = evolveHelper.getSect();

		return sect + ';' +
			'sect=' + sect + ';' +
			'mtfInline=true;' +
			'pos=' + slotname + ';' +
			WikiaDartHelper_getZone1() +
			WikiaDartHelper_getCustomKeyValues() +
			WikiaDartHelper_getKruxKV();
	}

	// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
	function getUrl(slotname) {
		log('getUrl ' + slotname, 5, 'AdProviderEvolve');

		var sect = evolveHelper.getSect()
			, url
			, dcopt = slotMap[slotname].dcopt
			, size = slotMap[slotname].size
			, tile = slotMap[slotname].tile
		;

		url = 'http://' +
			'n4403ad' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'gn.wikia4.com' + '/' +
			getKv(slotname) +
			'sz=' + size + ';' +
			(dcopt ? 'dcopt=' + dcopt + ';' : '') +
			'type=pop;type=int;' + // TODO remove?
			'tile=' + tile + ';' +
			'ord=' + ord + '?';

		log(url, 7, 'AdProviderEvolve');
		return url;
	}

	// c&p WikiaDartHelper.getZone1
	// TODO refactor
	function WikiaDartHelper_getZone1() {
		log('WikiaDartHelper_getZone1', 5, 'AdProviderEvolve');

		if (window.wgDBname) {
			var kv = 's1=_' + window.wgDBname.replace('/[^0-9A-Z_a-z]/', '_') + ';';

			log(kv, 7, 'AdProviderEvolve');
			return kv;
		}

		return '';
	}

	// c&p WikiaDartHelper.getCustomKeyValues
	// TODO refactor
	var kvStrMaxLength = 500;
	function WikiaDartHelper_getCustomKeyValues() {
		log('WikiaDartHelper_getCustomKeyValues', 5, 'AdProviderEvolve');

		if (window.wgDartCustomKeyValues) {
			var kv = window.wgDartCustomKeyValues + ';';
			kv = kv.substr(0, kvStrMaxLength);
			kv = kv.replace(/;[^;]*$/, ';');

			log(kv, 7, 'AdProviderEvolve');
			return kv;
		}

		return '';
	}

	// c&p WikiaDartHelper.getKruxKV
	// TODO refactor
	function WikiaDartHelper_getKruxKV() {
		log('WikiaDartHelper_getKruxKV', 5, 'AdProviderEvolve');

		var kv = Krux.dartKeyValues;

		if (kv) {
			kv = kv.substr(0, kvStrMaxLength);
			kv = kv.replace(/;[^;]*$/, ';');

			log(kv, 7, 'AdProviderEvolve');
			return kv;
		}

		return '';
	}

	function hop(slotname) {
		log('hop', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		slotname = sanitizeSlotname(slotname);
		var size = (slotMap[slotname].size || '0x0').replace(/,.*/, '');
		log([slotname, size], 7, 'AdProviderEvolve');

		hoppedSlots[slotname] = true;

		var time = new Date().getTime() - slotTimer2[slotname];
		log('slotTimer2 end for ' + slotname + ' after ' + time + ' ms', 7, 'AdProviderEvolve');
		WikiaTracker.trackAdEvent('liftium.hop2', {'ga_category':'hop2/evolve', 'ga_action':'slot ' + slotname, 'ga_label':formatTrackTime(time, 5)}, 'ga');

		window.adslots2.push([slotname, size, 'Liftium2Dom', null]);
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
	}

	return iface;

};
