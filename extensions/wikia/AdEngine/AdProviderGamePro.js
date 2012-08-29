var AdProviderGamePro = my.Class(AdProviderAdEngine2, {
	// core stuff, should be overwritten
	name:'AdProviderGamePro',

	// private stuff
	ord: Math.round(Math.random() * 23456787654),
	slotMap: {
	   'HOME_TOP_LEADERBOARD': {'tile': 1, 'pos': "leadfull", 'dcopt': "ist"},
	   'HOME_TOP_RIGHT_BOXAD': {'tile': 3, 'pos': "mpu"},
	   'LEFT_SKYSCRAPER_2': {'tile': 2, 'pos': "sky"},
	   'PREFOOTER_LEFT_BOXAD': {'tile': 4, 'pos': "mpu2"},
	   'TOP_LEADERBOARD': {'tile': 1, 'pos': "leadfull", 'dcopt': "ist"},
	   'TOP_RIGHT_BOXAD': {'tile': 3, 'pos': "mpu"}
	},

	// adapted for GP + simplified copy of AdConfig.DART.getUrl
	getUrl: function(slotname, size) {
		this.log('getUrl', [slotname, size]);

		var url = 'http://' +
			'ad-emea' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'ow-wikia.com' + '/' + 'wka.' + window.cityShort + ';' +
			's1=' + '_' + window.wgDBname + ';' +
			'pos=' + this.slotMap[slotname].pos + ';' +
			(window.wgDartCustomKeyValues ? this.rebuildKV(window.wgDartCustomKeyValues) + ';' : '' ) +
			'tile=' + this.slotMap[slotname].tile + ';' +
			(this.slotMap[slotname].dcopt ? 'dcopt=' + this.slotMap[slotname].dcopt + ';' : '') +
			'sz=' + size + ';' +
			'ord=' + this.ord + '?';

		this.log(url);
		return url;
	},

	// from: egnre=action;egnre=adventure;egnre=drama;egnre=scifi;media=tv
	// to: egnre=action,adventure,drama,scifi;media=tv
	// TODO: cache it
	rebuildKV: function(kv) {
		this.log('rebuildKV', kv);

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
		this.log(out);
		return out;
	},

	fillInSlot: function(s) {
		this.log('fillInSlot', s);
		
		WikiaTracker.trackAdEvent('liftium.slot', {'ga_category':s[1], 'ga_action':s[0], 'ga_label':'gamepro'}, 'ga');

		var url = this.getUrl(s[0], s[1]);
		var self = this;
		ghostwriter(
			document.getElementById(s[0]),
			{
				insertType: "append",
				script: { src: url },
				done: function() {
					self.log('ghostwriter done', [s[0], url]);
					ghostwriter.flushloadhandlers();
				}
			}
		);
	}
});

var adProviderGamePro = new AdProviderGamePro;