var Ad = Ad || {};

Ad.ProviderEvolve = (function (Util, AdDriver, AdDriverDelayedLoader, WikiaTracker, ghostwriter, window, undef) {
	'use strict';

	// private stuff
	var ord = Math.round(Math.random() * 23456787654)
		, slotMap = {
			'HOME_TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
			'HOME_TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250'},
			'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600'},
			'TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
			'TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250'}
		}
		// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
		, getUrl = function (slotname, size) {
			//return getDevboxUrl(slotname, size); // TODO remove, this is a test measure only!

			Util.log('getUrl', [slotname, size]);

			var url = 'http://' +
				'n4403ad' +
				'.doubleclick.net/' +
				'adj' + '/' +
				'wikia' + '/' +
				(window.adLogicPageType || 'article') + ';' +
				//'sect=' + 'home' + ';' +
				'mtfInline=true;' +
				'pos=' + slotname + ';' +
				'sz=' + size + ';' +
				(slotMap[slotname].dcopt ? 'dcopt=' + slotMap[slotname].dcopt + ';' : '') +
				'tile=' + slotMap[slotname].tile + ';' +
				'ord=' + ord + '?';

			Util.log(url);
			return url;
		}

		// TODO remove, this is a test measure only!
		, getDevboxUrl = function (slotname, size) {
			Util.log('getUrl', [slotname, size]);

			var url = 'http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;' +
				'pos=' + slotname + ';' +
				'src=evolve;' +
				'ord=' + ord + '?';

			Util.log(url);
			return url;
		}

		// dart has problems with sending back scripts based on key-val %p
		// http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;pos=TOP_LEADERBOARD;ord=7121786175
		// yields window.AdEngine2.hop('=TOP_LEADERBOARD;ord=7121786175');
		// instead of window.AdEngine2.hop('TOP_LEADERBOARD');
		, sanitizeSlotname = function (slotname) {
			Util.log('Ad.ProviderEvolve:sanitizeSlotname', slotname);

			var re = new RegExp('[A-Z1-9_]+')
				, out = re.exec(slotname);
			Util.log(out);

			if (slotMap[out] === undef) {
				Util.log('error, unknown slotname');
				out = '';
			}

			Util.log(out);
			return out;
		}

		// adapted for Evolve + simplified copy of AdDriverDelayedLoader.getLiftiumCallScript
		, getLiftiumCallScript = function(slotname, size) {
			Util.log('getLiftiumCallScript', [slotname, size]);

			// TODO move AdDriverDelayedLoader.adNum to something global
			var dims = size.split('x')
				, script = '';

			script += "document.write('<div id=\"Liftium_"+size+"_"+(++AdDriverDelayedLoader.adNum)+"\"><iframe width=\""+dims[0]+"\" height=\""+dims[1]+"\" id=\""+slotname+"_iframe\" noresize=\"true\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"border:none;\" target=\"_blank\"></iframe><div>');";

			script += 'LiftiumOptions.placement = "'+slotname+'";';
			script += 'Liftium.callInjectedIframeAd("'+size+'", document.getElementById("'+slotname+'_iframe"));';

			return script;
		};

	return {
		name: 'Ad.ProviderEvolve',

		fillInSlot: function (slot) {
			Util.log('fillInSlot', slot);

			WikiaTracker.trackAdEvent('liftium.slot', {'ga_category':'slot/' + slot[1], 'ga_action':slot[0], 'ga_label':'evolve'}, 'ga');

			var url = getUrl(slot[0], slot[1]);
			ghostwriter(
				document.getElementById(slot[0]),
				{
					insertType: "append",
					script: { src:url },
					done: function () {
						Util.log('(fillInSlot) ghostwriter done', [slot[0], url]);
						ghostwriter.flushloadhandlers();
					}
				}
			);
		},

		hop: function (slotname) {
			var size, script;

			slotname = sanitizeSlotname(slotname);
			size = slotMap[slotname].size || '0x0';
			Util.log('hop', [slotname, size]);

			WikiaTracker.trackAdEvent('liftium.hop', {'ga_category':'hop/evolve', 'ga_action':'slot ' + slotname, 'ga_label':'9.9' /* FIXME Liftium.formatTrackTime(time, 5) */}, 'ga');

			//LiftiumOptions.placement = slotname;
			script = getLiftiumCallScript(slotname, size);
			Util.log(script);
			ghostwriter(
				document.getElementById(slotname),
				{
					insertType:"append",
					script:{text:script},
					done: function () {
						Util.log('(hop) ghostwriter done', [slotname, script]);
						ghostwriter.flushloadhandlers();
						AdDriver.adjustSlotDisplay(slotname);
					}
				}
			); // TODO get rid of ghostscript (inject iframe + call liftium)
			// TODO check AIC2 for an example
		}
	};
}(Ad.Util, window.AdDriver, window.AdDriverDelayedLoader, window.WikiaTracker, window.ghostwriter, window));

var evolve_hop = Ad.ProviderEvolve.hop;
