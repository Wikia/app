var AdMeldAPIClient = {
	sizes:[], // filled in by init() based on slots
	slots:{
		'TOP_RIGHT_BOXAD':      {size:'300x250', placement:'%%HUB%%-atf',       ad:null, pixels: null},
		//'HOME_TOP_RIGHT_BOXAD': {                                                                  }, use s/HOME_// instead
		'TOP_LEADERBOARD':      {size:'728x90',  placement:'%%HUB%%-atf',       ad:null, pixels: null},
		//'HOME_TOP_LEADERBOARD': {                                                                  }, use s/HOME_// instead
		'LEFT_SKYSCRAPER_2':    {size:'160x600', placement:'%%HUB%%-btf',       ad:null, pixels: null},
		'PREFOOTER_LEFT_BOXAD': {size:'300x250', placement:'%%HUB%%-btf-left',  ad:null, pixels: null},
		'PREFOOTER_RIGHT_BOXAD':{size:'300x250', placement:'%%HUB%%-btf-right', ad:null, pixels: null}
		// %%HUB%% is replaced with AdMeldAPIClient.siteHub
	}
};

// TODO: can we do it better?
if (window.cscoreCat === 'Gaming') {
	AdMeldAPIClient.siteHub = 'gaming';
} else if (window.cscoreCat === 'Entertainment') {
	AdMeldAPIClient.siteHub = 'entertainment';
} else {
	AdMeldAPIClient.siteHub = 'lifestyle';
}

AdMeldAPIClient.log = function(msg, level) {
	if (typeof window.top.Wikia !== 'undefined' && typeof window.top.Wikia.log === 'function') {
		window.top.Wikia.log(msg, level, 'AdMeldAPIClient');
	}
};

AdMeldAPIClient.track = function(data, profile) {
	profile = profile || 'admeldapiclient';
	this.log('track ' + data.join('/') + ' in ' + profile, 'trace_l3');
	
	data[0] = 'admeldapiclient/' + data[0];

	var event = data;
	if (event.length > 3) {
		event = [event[0], event[1], event.slice(2).join('/')];		
	}
	this.log('event: [' + event.join(', ') + ']', 'trace_l3');

	//WikiaTracker.track(data.join('/'), 'liftium.' + profile, event);	
};

AdMeldAPIClient.getAd = function(slotname) {
	this.log('getAd ' + slotname, 'trace_l2');

	try {
		slotname = slotname.replace('HOME_', '');
		this.log('slotname HOME_' + slotname + ' replaced with ' + slotname, 'trace_l3');
	} catch(e1) {
	}
	
	try {
		return this.slots[slotname].ad.creative + this.slots[slotname].pixels.join("\n");
	} catch(e2) {
		this.log('Error in getAd ' + slotname + ', returning null', 'error');
		this.track(['error', 'get_ad', slotname], 'error');
		return null;
	}
};

AdMeldAPIClient.getBid = function(slotname) {
	this.log('getBid ' + slotname, 'trace_l2');
	
	try {
		slotname = slotname.replace('HOME_', '');
		this.log('slotname HOME_' + slotname + ' replaced with ' + slotname, 'trace');
	} catch(e1) {
	}

	try {
		return this.slots[slotname].ad.bid;
	} catch(e2) {
		this.log('Error in getBid ' + slotname + ', returning -1', 'error');
		this.track(['error', 'get_bid', slotname], 'error');
		return -1;
	}
};

AdMeldAPIClient.init = function() {
	this.log('init', 'info');
	
	var page = window.top.wgServer + window.top.wgArticlePath.replace('$1', window.top.wgPageName);

	for (var slot in this.slots) {
		this.log('ask for ' + slot + ' bid', 'trace_l3');
		var s = this.slots[slot];
		this.log(s, 'trace_l3');
		var url = 'http://tag.admeld.com/ad/json?publisher_id=' + 525 +
					'&site_id=' + 'wikia' +
					'&placement=' + s.placement.replace('%%HUB%%', this.siteHub) +
					'&size=' + s.size +
					'&url=' + page +
					'&callback=' + 'AdMeldAPIClient.callback' + 
					'&container=' + slot;
		this.log('calling ' + url, 'trace');
		this.track(['call', slot]);
		$.ajax({url:url, dataType:'jsonp', timeout:2000});
		this.slots[slot].url = url;
		this.slots[slot].timer = (new Date).getTime();

		if ($.inArray(s.size, this.sizes) == -1) {
			this.sizes.push(s.size);
		}
	}
};

AdMeldAPIClient.callback = function(data) {
	this.log(data, 'trace_l3');

	try {
		var slot = data.ad.container;
		this.slots[slot].ad = data.ad;
		this.slots[slot].pixels = data.pixels;
	} catch(e) {
		this.log('Error in callback, broken ad', 'error');
		this.track(['error', 'callback', 'ad'], 'error');
		return false;
	}

	try {
		var time = (new Date).getTime() - this.slots[slot].timer;
		this.log('callback ' + slot + ' after ' + time + ' ms', 'trace_l2');
		this.slots[slot].timer = time;

		if (time > 5000) time = 5000;
		time = (time/1000).toFixed(1); // store as x.x sec
		this.track(['callback', slot, time]);
	} catch(e) {
		this.log('Error in callback, broken timer', 'error');
		this.track(['error', 'callback', 'timer'], 'error');
	}

	try {
		var bid = this.slots[slot].ad.bid;
		this.track(['bid', slot, bid.toFixed(3)]);

		this.slots[slot].ad.bid = (bid * 0.875).toFixed(2); // adjust magic for Kyle
	} catch(e) {
		this.log('Error in callback, broken bid', 'error');
		this.track(['error', 'callback', 'bid'], 'error');
		return false;
	}
	
	return true;
};

// based on Liftium.setAdjustedValues
AdMeldAPIClient.adjustLiftiumChain = function(tags) {
	this.log(tags, 'trace_l3');
	
	try {
		if (this.sizes.indexOf(tags[0].size) == -1) {
			this.log('adjustLiftiumChain ' + tags[0].size + ' skipped, no tags for this size', 'trace_l2');
			return tags;
		}
		this.log('adjustLiftiumChain ' + tags[0].size, 'trace_l3');
	} catch (e) {
		this.log('Error in adjustLiftiumChain', 'error')
		this.track(['error', 'adjust_liftium_chain'], 'error');
	}
	
	for (var i = 0; i < tags.length; i++) {
		var t = tags[i];
		this.log(t, 'trace_l3');
		if (t.network_id == 172) {
			this.log(t, 'trace_l3');
			
			var slotname = t.criteria.placement[0];
			try {
				slotname = slotname.replace('HOME_', '');
				this.log('slotname HOME_' + slotname + ' replaced with ' + slotname, 'trace_l2');
			} catch(e) {
			}

			var bid = this.getBid(slotname);
			var tier = this.getLiftiumTier(bid);
			tags[i].tier=tier; // not t, change the original in place
			tags[i].value=bid; // not t, change the original in place
			this.log('AdMeld tag #' + t.tag_id + ' adjusted to tier ' + tier + ', value $' + bid, 'trace_l2');
			this.track(['liftium', t.tag_id, tier, bid]);
		}
	}
	
	return tags; // Not really necessary, because it modified values in place
};

AdMeldAPIClient.getLiftiumTier = function(bid) {
	this.log('getLiftiumTier ' + bid, 'trace_l2');

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
	this.log('getParamForDART ' + slotname, 'trace_l2');

	var bid = this.roundBidForDART(this.getBid(slotname));
	this.track(['dart', slotname, bid]);

	return 'admeld=' + bid + ';';
};

AdMeldAPIClient.roundBidForDART = function(bid) {
	this.log('roundBidForDART ' + bid, 'trace_l2');
	
	if (bid > 5) bid = 5;
	
	bid = Math.round(bid*10)/10; // round to x.x
	bid = bid.toFixed(2); // store as x.x0
	
	return bid;
};

if (window.top.wgEnableAdMeldAPIClient) {
	window.top.AdMeldAPIClient.init();
}
