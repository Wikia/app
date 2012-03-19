var AdMeldAPIClient = {
	sizes:[], // filled in by init() based on slots
	slots:{
		'TOP_RIGHT_BOXAD':      {size:'300x250', placement:'test_atf',       ad:null, pixels: null},
		//'HOME_TOP_RIGHT_BOXAD': {                                                               }, use s/HOME_// instead
		'TOP_LEADERBOARD':      {size:'728x90',  placement:'test_atf',       ad:null, pixels: null},
		//'HOME_TOP_LEADERBOARD': {                                                               }, use s/HOME_// instead
		'LEFT_SKYSCRAPER_2':    {size:'160x600', placement:'test_btf_right', ad:null, pixels: null},
		'PREFOOTER_LEFT_BOXAD': {size:'300x250', placement:'test_btf',       ad:null, pixels: null},
		'PREFOOTER_RIGHT_BOXAD':{size:'300x250', placement:'test_btf_right', ad:null, pixels: null}
	}
};

AdMeldAPIClient.log = function(msg, level) {
	if (typeof top.WikiaLogger != 'undefined') {
		top.WikiaLogger.log(msg, level, 'AdMeldAPIClient');
	}
};

AdMeldAPIClient.track = function(data, profile) {
	profile = profile || 'admeldapiclient';
	this.log('track ' + data.join('/') + ' in ' + profile, 6);
	
	data[0] = 'admeldapiclient/' + data[0];

	var event = data;
	if (event.length > 3) {
		event = [event[0], event[1], event.slice(2).join('/')];		
	}
	this.log('event: [' + event.join(', ') + ']', 6);

	WikiaTracker.track(data.join('/'), 'liftium.' + profile, event);	
};

AdMeldAPIClient.getAd = function(slotname) {
	this.log('getAd ' + slotname, 5);

	try {
		slotname = slotname.replace('HOME_', '');
		this.log('slotname HOME_' + slotname + ' replaced with ' + slotname, 9);
	} catch(e) {
	}
	
	try {
		return this.slots[slotname].ad.creative + this.slots[slotname].pixels.join("\n");
	} catch(e) {
		this.log('Error in getAd ' + slotname + ', returning null', 3);
		this.track(['error', 'get_ad', slotname], 'error');
		return null;
	}
};

AdMeldAPIClient.getBid = function(slotname) {
	this.log('getBid ' + slotname, 5);
	
	try {
		slotname = slotname.replace('HOME_', '');
		this.log('slotname HOME_' + slotname + ' replaced with ' + slotname, 9);
	} catch(e) {
	}

	try {
		return this.slots[slotname].ad.bid;
	} catch(e) {
		this.log('Error in getBid ' + slotname + ', returning -1', 3);
		this.track(['error', 'get_bid', slotname], 'error');
		return -1;
	}
};

AdMeldAPIClient.init = function() {
	this.log('init', 1);
	
	var page = top.wgServer + top.wgArticlePath.replace('$1', top.wgPageName);

	for (var slot in this.slots) {
		this.log('ask for ' + slot + ' bid', 5);
		var s = this.slots[slot];
		this.log(s, 9);
		var url = 'http://tag.admeld.com/ad/json?publisher_id=' + 525 +
					'&site_id=' + 'wikia' +
					'&placement=' + s.placement +
					'&size=' + s.size +
					'&url=' + page +
					'&callback=' + 'AdMeldAPIClient.callback' + 
					'&container=' + slot;
		this.log('calling ' + url, 7);
		this.track(['call', slot]);
		$.ajax({url:url, dataType:'jsonp'});
		this.slots[slot].url = url;
		this.slots[slot].timer = (new Date).getTime();

		if ($.inArray(s.size, this.sizes) == -1) {
			this.sizes.push(s.size);
		}
	}
};

AdMeldAPIClient.callback = function(data) {
	this.log(data, 7);

	try {
		var slot = data.ad.container;
		this.slots[slot].ad = data.ad;
		this.slots[slot].pixels = data.pixels;
	} catch(e) {
		this.log('Error in callback, broken ad', 3);
		this.track(['error', 'callback', 'ad'], 'error');
		return false;
	}

	try {
		var time = (new Date).getTime() - this.slots[slot].timer;
		this.log('callback ' + slot + ' after ' + time + ' ms', 5);
		this.slots[slot].timer = time;

		if (time > 5000) time = 5000;
		time = (time/1000).toFixed(1); // store as x.x sec
		this.track(['callback', slot, time]);
	} catch(e) {
		this.log('Error in callback, broken timer', 3);
		this.track(['error', 'callback', 'timer'], 'error');
	}

	try {
		var bid = this.slots[slot].ad.bid;
		this.track(['bid', slot, bid.toFixed(3)]);

		this.slots[slot].ad.bid = (bid * 0.875).toFixed(2); // adjust magic for Kyle
	} catch(e) {
		this.log('Error in callback, broken bid', 3);
		this.track(['error', 'callback', 'bid'], 'error');
		return false;
	}
	
	return true;
};

// based on Liftium.setAdjustedValues
AdMeldAPIClient.adjustLiftiumChain = function(tags) {
	this.log(tags, 7);
	
	try {
		if (this.sizes.indexOf(tags[0].size) == -1) {
			this.log('adjustLiftiumChain ' + tags[0].size + ' skipped, no tags for this size', 5);
			return tags;
		}
		this.log('adjustLiftiumChain ' + tags[0].size, 5);
	} catch (e) {
		this.log('Error in adjustLiftiumChain', 3)
		this.track(['error', 'adjust_liftium_chain'], 'error');
	}
	
	for (var i = 0; i < tags.length; i++) {
		var t = tags[i];
		this.log(t, 9);
		if (t.network_id == 172) {
			this.log(t, 7);
			
			var slotname = t.criteria.placement[0];
			try {
				slotname = slotname.replace('HOME_', '');
				this.log('slotname HOME_' + slotname + ' replaced with ' + slotname, 9);
			} catch(e) {
			}

			var bid = this.getBid(slotname);
			var tier = this.getLiftiumTier(bid);
			tags[i].tier=tier; // not t, change the original in place
			tags[i].value=bid; // not t, change the original in place
			this.log('AdMeld tag #' + t.tag_id + ' adjusted to tier ' + tier + ', value $' + bid, 5);
			this.track(['liftium', t.tag_id, tier, bid]);
		}
	}
	
	return tags; // Not really necessary, because it modified values in place
};

AdMeldAPIClient.getLiftiumTier = function(bid) {
	this.log('getLiftiumTier ' + bid, 5);

	if (bid >= 2.00) return 3;
	if (bid >= 1.00) return 4;
	if (bid >= 0.80) return 5;
	if (bid >= 0.65) return 6;
	if (bid >= 0.50) return 7;
	if (bid >= 0.35) return 8;
	if (bid >= 0.20) return 9;
	
	return 10;
};

AdMeldAPIClient.getParamForDART = function(slotname) {
	this.log('getParamForDART ' + slotname, 5);

	var bid = this.roundBidForDART(this.getBid(slotname));
	this.track(['dart', slotname, bid]);

	return 'admeld=' + bid + ';';
};

AdMeldAPIClient.roundBidForDART = function(bid) {
	this.log('roundBidForDART ' + bid, 5);
	
	if (bid > 5) bid = 5;
	
	bid = Math.round(bid*10)/10; // round to x.x
	bid = bid.toFixed(2); // store as x.x0
	
	return bid;
};

if (!top.wgNoExternals && !(top.wgUserName && !top.wgUserShowAds) && top.wgEnableAdMeldAPIClient) {
	top.AdMeldAPIClient.init();
}
