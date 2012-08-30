var AdDriverGP = {
	ord: Math.round(Math.random() * 23456787654),
	slotMap: {
	   'HOME_TOP_LEADERBOARD': {'tile': 1, 'pos': "leadfull", 'dcopt': "ist"},
	   'HOME_TOP_RIGHT_BOXAD': {'tile': 3, 'pos': "mpu"},
	   'LEFT_SKYSCRAPER_2': {'tile': 2, 'pos': "sky"},
	   'PREFOOTER_LEFT_BOXAD': {'tile': 4, 'pos': "mpu2"},
	   'TOP_LEADERBOARD': {'tile': 1, 'pos': "leadfull", 'dcopt': "ist"},
	   'TOP_RIGHT_BOXAD': {'tile': 3, 'pos': "mpu"}
	},
	debug: false,

	// adapted for GP + simplified copy of AdConfig.DART.getUrl
	getUrl: function(slotname, size) {
		this.log('getUrl', [slotname, size]);

		var url = 'http://' +
			'ad-emea' +
			'.doubleclick.net/' +
			'adj' + '/' +
			'ow-wikia.com' + '/' + 'wka.' + window.cityShort + ';' +
			's1=' + '_' + window.wgDBname + ';' +
			'pos=' + AdDriverGP.slotMap[slotname].pos + ';' +
			(window.wgDartCustomKeyValues ? this.rebuildKV(window.wgDartCustomKeyValues) + ';' : '' ) +
			'tile=' + AdDriverGP.slotMap[slotname].tile + ';' +
			(AdDriverGP.slotMap[slotname].dcopt ? 'dcopt=' + AdDriverGP.slotMap[slotname].dcopt + ';' : '') + 
			'sz=' + size + ';' +
			'ord=' + AdDriverGP.ord + '?';

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

	log: function(msg, obj) {
		if (typeof console == 'undefined') return;
		
		// FIXME WikiaLogger...
		if (!this.debug) return;
		
		console.log('AdDriverGP: ' + msg);
		if (typeof obj != 'undefined') {
			console.log(obj);
		}
	},

	init: function() {
		this.log('init');

		this.moveQueue();
	},
	
	moveQueueSimple: function() {
		this.log('moveQueueSimple');
		
		if (!window.gpslots) { window.gpslots = []; }
		for (var i=0; i < window.gpslots.length; i++) {
			var s = window.gpslots[i];
			this.log('slot', s);
			this.fillInSlot(s);
		}
	},

	fillInSlot: function(s) {
		this.log('fillInSlot', s);
		
		WikiaTracker.trackAdEvent('liftium.slot2', {'ga_category':'slot2/' + s[1], 'ga_action':s[0], 'ga_label':'gamepro'}, 'ga');

		var url = this.getUrl(s[0], s[1]);
		ghostwriter(
			document.getElementById(s[0]),
			{
				insertType: "append",
				script: { src: url },
				done: function() {
					AdDriverGP.log('ghostwriter done', [s[0], url]);
					ghostwriter.flushloadhandlers();
				}
			}
		);
	},

	// based on WikiaTrackerQueue by macbre	
	moveQueue: function() {
		this.log('moveQueue');
		
		var slots = window.gpslots || [], s;
		while ((s = slots.shift()) !== undefined) {
			this.fillInSlot(s);
		}

		slots.push = this.proxy(this.fillInSlot, this);
	},
	
	proxy: function(fn, scope) {
		return function() {
			return fn.apply(scope, arguments);
		}
	}
};

//$(document).ready(function() {
if ( ! window.wgInsideUnitTest ) {
	AdDriverGP.init();
}
//});
