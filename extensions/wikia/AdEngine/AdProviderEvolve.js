var AdProviderEvolve = my.Class(AdProviderAdEngine2, {
	// core stuff, should be overwritten
	name:'AdProviderEvolve',

	fillInSlot:function (slot) {
		this.log('fillInSlot', slot);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'evolve'}, 'ga');

		var url = this.getUrl(slot[0], slot[1]);
		var self = this;
		ghostwriter(
			document.getElementById(slot[0]),
			{
				insertType:"append",
				script:{ src:url },
				done:function () {
					self.log('(fillInSlot) ghostwriter done', [slot[0], url]);
					ghostwriter.flushloadhandlers();
				}
			}
		);
	},

	// private stuff
	ord:Math.round(Math.random() * 23456787654),
	slotMap:{
		'HOME_TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'HOME_TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250'},
		'LEFT_SKYSCRAPER_2':{'tile':3, 'size':'160x600'},
		'TOP_LEADERBOARD':{'tile':1, 'size':'728x90', 'dcopt':'ist'},
		'TOP_RIGHT_BOXAD':{'tile':2, 'size':'300x250'}
	},

	// adapted for Evolve + simplified copy of AdConfig.DART.getUrl
	getUrl:function (slotname, size) {
//return this.getDevboxUrl(slotname, size); // TODO remove, this is a test measure only!

		this.log('getUrl', [slotname, size]);

		var url = 'http://' +
			'n4403ad' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'gn.wikia4.com' + '/' +
			'home;' + // (window.adLogicPageType ? window.adLogicPageType : 'article') + ';' +
			'sect=' + 'home' + ';' +
			'mtfInline=true;' +
			'pos=' + slotname + ';' +
			'sz=' + size + ';' +
			(this.slotMap[slotname].dcopt ? 'dcopt=' + this.slotMap[slotname].dcopt + ';' : '') +
			'type=pop;type=int;' + // TODO remove?
			'tile=' + this.slotMap[slotname].tile + ';' +
			'ord=' + this.ord + '?';

		this.log(url);
		return url;
	},

	// TODO remove, this is a test measure only!
	getDevboxUrl:function (slotname, size) {
		this.log('getUrl', [slotname, size]);

		var url = 'http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;' +
			'pos=' + slotname + ';' +
			'src=evolve;' +
			'ord=' + this.ord + '?';

		this.log(url);
		return url;
	},

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.callLiftium
	hop:function (slotname) {
		slotname = this.sanitizeSlotname(slotname);
		var size = this.slotMap[slotname].size || '0x0';
		this.log('hop', [slotname, size]);

		WikiaTracker.trackAdEvent('liftium.hop2', {'ga_category':'hop2/evolve', 'ga_action':'slot ' + slotname, 'ga_label':'9.9' /* FIXME Liftium.formatTrackTime(time, 5) */}, 'ga');

		//LiftiumOptions.placement = slotname;
		var script = this.getLiftiumCallScript(slotname, size);
		this.log(script);
		var self = this;
		ghostwriter(
			document.getElementById(slotname),
			{
				insertType:"append",
				script:{text:script},
				done:function () {
					self.log('(hop) ghostwriter done', [slotname, script]);
					ghostwriter.flushloadhandlers();
					AdDriver.adjustSlotDisplay(slotname);
				}
			}
		); // TODO get rid of ghostscript (inject iframe + call liftium)
		// TODO check AIC2 for an example
	},

	// dart has problems with sending back scripts based on key-val %p
	// http://ad.doubleclick.net/adj/wka.gaming/_starcraft/article;s0=gaming;s1=_starcraft;dmn=wikia-devcom;pos=TOP_LEADERBOARD;ord=7121786175
	// yields window.AdEngine2.hop('=TOP_LEADERBOARD;ord=7121786175');
	// instead of window.AdEngine2.hop('TOP_LEADERBOARD');
	sanitizeSlotname:function (slotname) {
		this.log('sanitizeSlotname', slotname);

		var re = new RegExp('[A-Z1-9_]+');
		var out = re.exec(slotname);
		this.log(out);

		if (typeof this.slotMap[out] == 'undefined') {
			this.log('error, unknown slotname');
			out = '';
		}

		this.log(out);
		return out;
	},

	// adapted for Evolve + simplified copy of AdDriverDelayedLoader.getLiftiumCallScript
	getLiftiumCallScript:function(slotname, size) {
		this.log('getLiftiumCallScript', [slotname, size]);

		// TODO move AdDriverDelayedLoader.adNum to something global
		var dims = size.split('x');
		var script = '';
		script += "document.write('<div id=\"Liftium_"+size+"_"+(++AdDriverDelayedLoader.adNum)+"\"><iframe width=\""+dims[0]+"\" height=\""+dims[1]+"\" id=\""+slotname+"_iframe\" noresize=\"true\" scrolling=\"no\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\" style=\"border:none;\" target=\"_blank\"></iframe><div>');";

		script += 'LiftiumOptions.placement = "'+slotname+'";';
		script += 'Liftium.callInjectedIframeAd("'+size+'", document.getElementById("'+slotname+'_iframe"));';

		return script;
	}
});

var adProviderEvolve = new AdProviderEvolve;

function evolve_hop(slotname) {
	window.adProviderEvolve.hop(slotname);
}