window.AdProviderEvolve = window.AdProviderEvolve || (function (WikiaTracker, log, window, ghostwriter, document) {
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
	var slotMap = {
		'HOME_TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250,300x600'},
		'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600'},
		'TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250,300x600'}
	};

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

		var sect;
		// TODO criteria...
		if (true) {
			sect = 'home';
		} else if (false) {
			sect = 'entertainment';
		} else if (false) {
			sect = 'gaming';
		} else if (false) {
			sect = 'movies';
		} else if (false) {
			sect = 'tv';
		} else {
			sect = 'ros';
		}

		log(sect, 7, 'AdProviderEvolve');
		return sect;
	}

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.callLiftium
	function hop(slotname) {
		log('hop', 5, 'AdProviderEvolve');
		log(slotname, 5, 'AdProviderEvolve');

		slotname = sanitizeSlotname(slotname);
		var size = slotMap[slotname].size || '0x0';
		log('hop in:', 7, 'AdProviderEvolve');
		log([slotname, size], 7, 'AdProviderEvolve');

		WikiaTracker.trackAdEvent('liftium.hop2', {'ga_category':'hop2/evolve', 'ga_action':'slot ' + slotname, 'ga_label':'9.9' /* FIXME Liftium.formatTrackTime(time, 5) */}, 'ga');

		//LiftiumOptions.placement = slotname;
		var script = getLiftiumCallScript(slotname, size);
		ghostwriter(
			document.getElementById(slotname),
			{
				insertType:"append",
				script:{text:script},
				done:function () {
					log('(hop) ghostwriter done', 5, 'AdProviderEvolve');
					log([slotname, script], 5, 'AdProviderEvolve');
					ghostwriter.flushloadhandlers();
					window.AdDriver.adjustSlotDisplay(slotname);
				}
			}
		); // TODO get rid of ghostscript (inject iframe + call liftium)
		// TODO check AIC2 for an example
	}

	// dart has problems with sending back scripts based on key-val %p
	// http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;pos=TOP_LEADERBOARD;ord=7121786175
	// yields window.AdEngine2.hop('=TOP_LEADERBOARD;ord=7121786175');
	// instead of window.AdEngine2.hop('TOP_LEADERBOARD');
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

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.getLiftiumCallScript
	function getLiftiumCallScript(slotname, size) {
		log('getLiftiumCallScript', 5, 'AdProviderEvolve');
		log([slotname, size], 5, 'AdProviderEvolve');

		// TODO move AdDriverDelayedLoader.adNum to something global
		var dims = size.split('x');
		var script = '';
		script += "document.write('<div id=\"Liftium_"+size+"_"+(++window.AdDriverDelayedLoader.adNum)+"\"><iframe width=\""+dims[0]+"\" height=\""+dims[1]+"\" id=\""+slotname+"_iframe\" noresize=\"true\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"border:none;\" target=\"_blank\"></iframe><div>');";

		script += 'LiftiumOptions.placement = "'+slotname+'";';
		script += 'Liftium.callInjectedIframeAd("'+size+'", document.getElementById("'+slotname+'_iframe"));';

		log(script, 7, 'AdProviderEvolve');
		return script;
	}

	return {fillInSlot:fillInSlot, hop:hop};

})(WikiaTracker, Wikia.log, window, ghostwriter, document);

function evolve_hop(slotname) {
	window.AdProviderEvolve.hop(slotname);
}