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
			'pos=' + AdDriverGP.slotMap[slotname].pos + ';' +
			/* (window.wgDartCustomKeyValues ? window.wgDartCustomKeyValues + ';' : '') + */
			'tile=' + AdDriverGP.slotMap[slotname].tile + ';' +
			(AdDriverGP.slotMap[slotname].dcopt ? 'dcopt=' + AdDriverGP.slotMap[slotname].dcopt + ';' : '') + 
			'sz=' + size + ';' +
			'ord=' + AdDriverGP.ord + '?';

		this.log(url);
		return url;
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
	AdDriverGP.init();
//});