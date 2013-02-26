var AdProviderEvolve = function (adLogicPageLevelParamsLegacy, scriptWriter, tracker, log, window, document, evolveHelper, slotTweaker, dartUrl) {
	'use strict';

	var slotMap,
		logGroup = 'AdProviderEvolve',
		ord = Math.round(Math.random() * 23456787654),
		slotTimer2 = {},
		slotForSkin = 'INVISIBLE_1',
		hoppedSlots = {},
		getReskinAndSilverScript,
		getUrl,
		getUrl2,
		getKv,
		iface,
		sanitizeSlotname,
		formatTrackTime,
		hop,
		canHandleSlot,
		fillInSlot;

	slotMap = {
		'HOME_TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'HOME_TOP_RIGHT_BOXAD': {'tile': 2, 'size': '300x250,300x600'},
		'HUB_TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'LEFT_SKYSCRAPER_2': {'tile': 3, 'size': '160x600'},
		'TOP_LEADERBOARD': {'tile': 1, 'size': '728x90', 'dcopt': 'ist'},
		'TOP_RIGHT_BOXAD': {'tile': 2, 'size': '300x250,300x600'},
		'INVISIBLE_1': {'size': '0x0'}
	};

	canHandleSlot = function (slot) {
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
	};

	fillInSlot = function (slot) {
		log('fillInSlot', 5, 'AdProviderEvolve');
		log(slot, 5, 'AdProviderEvolve');

		var slotname = slot[0],
			slotsize = slot[1] || slotMap[slotname].size;

		tracker.track({
			eventName: 'liftium.slot2',
			ga_category: 'slot2/' + slotsize.split(',')[0],
			ga_action: slotname,
			ga_label: 'evolve',
			trackingMethod: 'ad'
		});

		slotTimer2[slotname] = new Date().getTime();
		log('slotTimer2 start for ' + slotname, 7, 'AdProviderEvolve');

		if (slotname === slotForSkin) {
			scriptWriter.injectScriptByUrl(
				slot[0],
				'http://cdn.triggertag.gorillanation.com/js/triggertag.js',
				function () {
					log('(invisible triggertag) ghostwriter done', 5, logGroup);
					scriptWriter.injectScriptByText(slotname, getReskinAndSilverScript(slotname), function () {
						// gorrilla skin is suppressed by body.mediawiki !important so make it !important too
						if (document.body.style.backgroundImage.search(/http:\/\/cdn\.assets\.gorillanation\.com/) !== -1) {
							document.body.style.cssText = document.body.style.cssText.replace(document.body.style.backgroundImage, document.body.style.backgroundImage + ' !important');
							document.body.style.cssText = document.body.style.cssText.replace(document.body.style.backgroundColor, document.body.style.backgroundColor + ' !important');
						}
					});
				}
			);
		} else {
			scriptWriter.injectScriptByUrl(slotname, getUrl(slotname), function () {
				if (!hoppedSlots[slotname]) {
					slotTweaker.removeDefaultHeight(slotname);
					slotTweaker.removeTopButtonIfNeeded(slotname);
				}
			});
		}
	};

	getReskinAndSilverScript = function (slotname) {
		log('getReskinSilverScript', 5, logGroup);

		var script = '',
			kv = getKv(slotname);

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
	};

	getKv = function (slotname) {
		var sect = evolveHelper.getSect();

		return 'sect=' + sect + ';' +
			'mtfInline=true;' +
			'pos=' + slotname + ';' +
			's1=_' + (window.wgDBname || 'wikia').replace('/[^0-9A-Z_a-z]/', '_') + ';' +
			adLogicPageLevelParamsLegacy.getCustomKeyValues() +
			adLogicPageLevelParamsLegacy.getKruxKeyValues();
	};

	getUrl2 = function(slotname) {
		var sect = evolveHelper.getSect(),
			dcopt = slotMap[slotname].dcopt,
			size = slotMap[slotname].size,
			tile = slotMap[slotname].tile,
			url = dartUrl.urlBuilder('n4403ad.doubleclick.net', 'adj/gn.wikia4.com/' + sect);

		url.addParam('sect', sect);
		url.addParam('mtfInline', 'true');
		url.addParam('pos', slotname);
		url.addParam('s1', (window.wgDBname || 'wikia').replace('/[^0-9A-Z_a-z]/', '_'));
		url.addString(adLogicPageLevelParamsLegacy.getCustomKeyValues());
		url.addString(adLogicPageLevelParamsLegacy.getKruxKeyValues());
		url.addString(adLogicPageLevelParamsLegacy.getDomainKV());
		url.addString(adLogicPageLevelParamsLegacy.getHostnamePrefix());
		url.addParam('sz', size);
		url.addParam('dcopt', dcopt);
		url.addParam('type', ['pop', 'int']); // TODO remove?
		url.addParam('tile', tile);
		url.addString('ord=' + ord + '?');

		return url.toString();
	};

	// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
	getUrl = function (slotname) {
		log('getUrl ' + slotname, 5, 'AdProviderEvolve');

		var sect = evolveHelper.getSect(),
			url,
			dcopt = slotMap[slotname].dcopt,
			size = slotMap[slotname].size,
			tile = slotMap[slotname].tile;

		url = 'http://' +
			'n4403ad' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'gn.wikia4.com' + '/' +
			sect + ';' +
			getKv(slotname) +
			adLogicPageLevelParamsLegacy.getDomainKV() +
			adLogicPageLevelParamsLegacy.getHostnamePrefix() +
			'sz=' + size + ';' +
			(dcopt ? 'dcopt=' + dcopt + ';' : '') +
			'type=pop;type=int;' + // TODO remove?
			'tile=' + tile + ';' +
			'ord=' + ord + '?';

		log('getUrl1: ' + url, 7, 'AdProviderEvolve');
		log('getUrl2: ' + getUrl2(slotname), 5, 'AdProviderEvolve');
		return url;
	};

	hop = function (slotname) {
		log('hop', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		slotname = sanitizeSlotname(slotname);

		var size = (slotMap[slotname].size || '0x0').split(',')[0],
			time = new Date().getTime() - slotTimer2[slotname];

		log([slotname, size], 7, 'AdProviderEvolve');

		hoppedSlots[slotname] = true;

		log('slotTimer2 end for ' + slotname + ' after ' + time + ' ms', 7, 'AdProviderEvolve');
		tracker.track({
			eventName: 'liftium.hop2',
			ga_category: 'hop2/evolve',
			ga_action: 'slot ' + slotname,
			ga_label: formatTrackTime(time, 5),
			trackingMethod: 'ad'
		});

		window.adslots2.push([slotname, size, 'Liftium2Dom', null]);
	};

	sanitizeSlotname = function (slotname) {
		log('sanitizeSlotname', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		var re = new RegExp('[A-Z1-9_]+'),
			out = re.exec(slotname),
			undef;

		log(out, 8, 'AdProviderEvolve');

		if (out) {
			out = out[0];
		}

		if (slotMap[out] === undef) {
			log('error, unknown slotname', 1, 'AdProviderEvolve');
			out = '';
		}

		log(out, 7, 'AdProviderEvolve');
		return out;
	};

	// copy of Liftium.formatTrackTime
	// TODO refactor out... AdEngine2Helper? Wikia.Tracker?
	formatTrackTime = function (t, max) {
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
	};

	iface = {
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
