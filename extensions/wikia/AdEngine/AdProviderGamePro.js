var AdProviderGamePro = my.Class(AdProviderAdEngine2, {
	// core stuff, should be overwritten
	name:'AdProviderGamePro',

	fillInSlot: function(slot) {
		this.log('fillInSlot', 5, slot);

		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + slot[1], 'ga_action':slot[0], 'ga_label':'gamepro'}, 'ga');

		var url = this.getUrl(slot[0], slot[1]);
		var self = this;
		ghostwriter(
			document.getElementById(slot[0]),
			{
				insertType: "append",
				script: { src: url },
				done: function() {
					self.log('ghostwriter done', 5, [slot[0], url]);
					ghostwriter.flushloadhandlers();
				}
			}
		);
	},

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
		this.log('getUrl', 5, [slotname, size]);

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

		this.log(url, 7);
		return url;
	},

	// TODO: cache it
	rebuildKV: function(kv) {
		this.log('rebuildKV', 5, kv);

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
		this.log(out, 7);
		return out;
	}
});

var adProviderGamePro = new AdProviderGamePro;