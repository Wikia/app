/******************************************
Variable initialisation
******************************************/

window.globalV6  = 'SOI-Revision: 1.519 $Revision: 1.519 $Date: 2013/11/08 08:08:49 $';

/******************************************
Functions for public interface
******************************************/

/*
	Example for optional data argument
	data = {
		fullscreen: true,
		industries: {
			midroll1:  {industry: 'blub'},
			midroll1c: {industry: 'blab'}
		}
	}
*/

// IMPORTANT:
// return value must be a string(!), possibly empty
function soi_Tagwriter(platz, data)
{
	if (!platz) {
		SoiLogger.logMsg('INVALID soi_Tagwriter call: platz not defined ' + platz);
		return '';
	}

	// Invalid configuration (e.g. due to firefox iframe caching bug, or reset because of file protocol)
	if (!window.DFPSite || !window.DFPZone) {
		SoiLogger.logMsg('INVALID soi_Tagwriter call for ' + platz + ' (DFPOrd ' + window.DFPOrd + ')\n' 
			+ 'DFPSite ' + window.DFPSite + ', DFPZone ' + window.DFPZone + ', DFPTile ' + window.DFPTile,
			data);
		return '';
	}

	// FIXME: temporary remedy for video pages
	if ((window.SOI_IDENTIFIER == 'pro7' || window.SOI_IDENTIFIER == 'ran') && window.SOI_VP) {
		if (!window.SOI_FB2 && platz == 'fullbanner2'
			|| !window.SOI_RT1 && platz == 'rectangle1') return '';
	}

	var self = arguments.callee;

	if (!SoiUtils.isObject(data)) data = {};

	var is_video = SoiIsVideo(platz);

	if (!is_video) SoiLogger.addSeparator(1, platz);

	var msg = '';

	var soi_var = SoiPlatzToVar(platz);
	if (soi_var) {
		var flag = window[soi_var];
		if (!flag) {
			if (platz == 'popup1') {
				// Auto repair is only possible for master ad, i.e. popup1!
				window[soi_var] = flag = true;
				msg += 'WARNING: soi_Tagwriter called for ' + platz + ', but window.' + soi_var + ' was not set. ' + soi_var + ' has been set to true via auto-repair.\n';
			}
			else {
				// Too late for auto-repair
				msg += 'WARNING: soi_Tagwriter called for ' + platz + ', but window.' + soi_var + ' = ' + flag + '\n';
			}
		}
	}

	// WITHIN THIS FUNCTION:
	// Access SOI_* variables only via "config" variable, not directly
	// window.SOI_XXX => config.XXX
	
	if (!self.dear_old_globals) {
		self.dear_old_globals = SoiDearOldGlobals('Tagwriter');
	}

	var config = {};
	for (var i = 0; i < self.dear_old_globals.length; i++) {
		var key = self.dear_old_globals[i];
		var config_key = key.replace(/^SOI_/, '');
		// Get rid of *string* 'null' misconfiguration
		config[config_key] = window[key] == 'null' ? '' : window[key];
	}
	
	var ind_params = soi_IndustryParams(data) || '';
	var fullscreen = !data.screen_mode || data.screen_mode == 'normal' ? 0 : 1;

	var tparam = config.TPARAM;
	if (tparam) tparam = tparam.replace(/;+$/, '');

	var params = SoiDFPParams(platz);
	if (!params.size) return '';

	var size     = params.size;
	var pos      = params.pos;
	var vpos     = params.vpos;
	var prefetch = params.prefetch;
	var vtype    = params.vtype;

	// Neither earlier nor later
	var flash_version = SoiUtils.getFlashVersion() || 0;
	var is_mobile     = SoiUtils.isMobile();
	var device        = SoiUtils.getDevice();

	var base_url  = '';
	var mime_part = '';
	if (is_video) {
		var mobilegate = String(config.MOBILEGATE || '').replace(/\/+$/, '');
		if (mobilegate) {
			var needs_mobilegate = typeof data.html5 == 'undefined' ?
				  !flash_version && device.match(/^(?:ipad|iphone|ipod)$/i)
				: data.html5; // wins if set
			if (needs_mobilegate) {
				base_url = mobilegate;
				// FIXME: re-enabled after adjustment of mobilegate script
				// prefetch = false;
				if (window.SoiSetMid) window.SoiSetMid = 1;
			}
		}

		mime_part = prefetch ? 'pfadx' : 'adx';
	}
	else {
		mime_part = 'adj';
	}

	var protocol = SoiUtils.getProtocol();
	if (!base_url) base_url = protocol + '//' + 'ad.de.doubleclick.net';
	base_url += '/N5731'; // required!

	var tile = SoiGetTile(platz, is_video, vpos);

	var retval   = '';
	var src_only = false;
	var special_showroom = false;

	var showroom      = SoiGetShowroomParam('showroom');
	var showroom_site = SoiGetShowroomParam('site');
	if (showroom) {
		var f = 'Soi' + SoiLemonInk(showroom.toUpperCase());
		if (typeof(window[f]) == 'function') {
			special_showroom = true;
			try {
				msg += showroom + '\n';
				retval = window[f](platz, size) || '';
			}
			catch(e) {
				msg += 'Error with ' + showroom + ' for ' + platz + ': ' + e.name + ' ' + e.message + '\n';
			}
		}
	}
	
	if (special_showroom) {
		src_only = is_video ? true : false;
	}
	else {
		var nugg       = SoiNugg.get();
		var rogator    = SoiRogator.get();
		var yieldprobe = SoiYieldProbe.get(platz) || '';

		// The params are used as booking condition for adprobe ads
		var ap_campaign_params = '';
		try {
			ap_campaign_params = String(SoiAP.getCampaignParams(platz) || '').replace(/;+$/, '');
		}
		catch(e) {
			SoiLogger.logMsg('SoiAP.getCampaignParams failed for ' + platz + ': ' + e.message);
		}

		// Syndication
		var nw_partner_id = SoiGetNetworkPartnerID();
		
		// 160x600 needs zz because of ADTECH-913 (master wp condition never met by skyscraper1)
		var needs_zz = (is_video && size.match(/^[124]0x1$/)) || size == '160x600' ? true : false;

		// Available display ads
		var wefos = ['PU1', 'FB2', 'RT1', 'SC1'];
		var wefo_collected = [];
		for (var i = 0; i < wefos.length; i++) {
			if (config[wefos[i]]) wefo_collected.push('xx=' + wefos[i].toLowerCase());
		}
		
		// Video ad configuration
		var vi_collected = [];

		if (config.VP) {
			// 1 prerolls ok
			// 2 postrolls ok
			// 3 presplit, midrolls, postsplit ok
			// 4 overlays ok
			// 5 sponsors ok
			for (var i = 1; i < 6; i++) {
				if (config['VA'+i]) vi_collected.push('vi='+i);
			}
			if (config.LPY) vi_collected.push('vi=l'); // fullepisode
		}

		var not_collected = [];
		var xx_collected  = [];

		if (config.PU1)  {
			if (config.PU)  xx_collected.push('xx=pu');  // popup/popunder allowed by site and user
			if (config.PUX) xx_collected.push('xx=pux'); // popup/popunder allowed by site, blocker detected
		}
		if (config.PU1 && config.PL && (!config.VP || config.AUTOPLAY == 'off')) xx_collected.push('xx=pl'); // powerlayer
		if (config.PU1 && config.FA) xx_collected.push('xx=fa'); // baseboard
		if (config.FB2 && config.PB) xx_collected.push('xx=pb'); // powerbanner
		if (config.FB2 && config.PD) xx_collected.push('xx=pd'); // pushdown
		if (config.FB2 && config.BB) xx_collected.push('xx=bb'); // billboard
		if (config.FB2 && config.WP) xx_collected.push('xx=wp'); // wallpaper
		if (config.FB2 && config.FP) xx_collected.push('xx=fp'); // fireplace
		if (config.RT1 && config.HP) xx_collected.push('xx=hp'); // halfpage
		if (config.RT1 && config.PR) xx_collected.push('xx=pr'); // powerrectangle
		if (config.SC1 && config.SB) xx_collected.push('xx=sb'); // sidebar
		if (config.SC1 && config.SK) xx_collected.push('xx=sk'); // sidekick

		// Video ad tandems are booked with condition xx=vp.
		// Tandems must be excluded for AUTOPLAY off (property is usually not set)
		if (config.VP && config.AUTOPLAY != 'off') xx_collected.push('xx=vp'); // videoads with tandem suitability

		// Exclusion clusters
		var exclude_collected = [];
		if (config.EXCL) {
			config.EXCL = String(config.EXCL).replace(/^,+/, '').replace(/,+$/, '').replace(/,{2,}/g, ',');
			if (config.EXCL) {
				exclude_collected = config.EXCL.split(',');
				for (var i = 0; i < exclude_collected.length; i++) {
					exclude_collected[i] = '!c=' + SoiEscapedASCII(exclude_collected[i]);
				}
			}
		}

		var keyvalue_collected = [];
		var keyvalue_max = 5;
		if (config.KEYVALUE && typeof(config.KEYVALUE) == 'object') {
			var regexp_key   = new RegExp('^[a-z][a-z0-9_]+$');
			var regexp_value = new RegExp('^[a-z0-9_]+$');
			for (var key in config.KEYVALUE) {
				// showroom treatment for icq showroom hack
				if (typeof(key) == 'undefined' || key === '' || (key != 'showroom' && String(key).length > 5) || !String(key).match(regexp_key)) continue;

				var value = config.KEYVALUE[key];
				if (typeof(value) == 'undefined' || value === '' || String(value).length > 10 || !String(value).match(regexp_value)) continue;

				keyvalue_collected.push(key + '=' + value);
				if (keyvalue_collected.length >= keyvalue_max) break;
			}
		}

		var site_zone;

		if (data.rp) {
			// restplatz handling
			site_zone = [data.site || window.DFPSiteRP || 'RP_OTHER', data.zone || 'other'].join('/');

			if (SoiUtils.isObject(data.seen)) {
				for (var k in data.seen) {
					var partner = SoiEscapedASCII(k || '');
					if (partner) not_collected.push('not=' + partner);
				}
			}
		}
		else {
			site_zone = [window.DFPSite, window.DFPZone].join('/');
		}

		var keywords = config.KEYWORDS || '';
		if (keywords) {
			keywords = String(keywords).replace(/ /g, '');
			// flash plugin dies on non-ascii characters in request url
			if (keywords.match(/[^a-zA-Z0-9_,.-]/)) keywords = '';
			config.KEYWORDS = keywords;
			if (keywords) keywords = (SoiEscapedASCII(keywords)).substr(0,113);
		}

		var special_ads_seen = SoiAd.isXXL('popup1')
			|| SoiAd.isWallpaper('fullbanner2')
			|| SoiAd.isFireplace('fullbanner2')
			|| SoiAd.isSidebar('skyscraper1') ? true : false;

		var all_collected = [];
		all_collected.push(site_zone);
		if (is_video) all_collected.push('dcmt=text/xml');
		all_collected.push('sz='+size);
		all_collected.push('pos='+pos);
		if (is_video) all_collected.push('vpos='+vpos);
		if (needs_zz) all_collected.push('zz='+size);
		if (ind_params) all_collected.push(ind_params);
		if (config.VP) all_collected.push('fs=' + fullscreen);
		if (config.DEBUG_TRACKING) all_collected.push('tid='+config.DEBUG_TRACKING);
		all_collected.push('dc_ref=sevenone'); // remedy for DFP master/companion with different referrers
		if (config.VP && config.PLAYER) all_collected.push('player='+SoiEscapedASCII(config.PLAYER));
		if (keyvalue_collected.length) all_collected.push(keyvalue_collected.join(';'));
		if (platz.match(/^shoppingtipp/) && special_ads_seen) all_collected.push('sas=1');
		if (vtype) all_collected.push('vtype=' + vtype); // for movad reports
		if (showroom) all_collected.push(showroom_site+'='+showroom);
		if (config.UPC) all_collected.push('upc='+SoiEscapedASCII(config.UPC));
		if (protocol == 'https:') all_collected.push('ssl=1');
		all_collected.push('fv=' + (flash_version || 0));
		if (is_mobile) all_collected.push('mob='+device);
		all_collected.push('sx='+SoiQuery.getScreenWidth()+';sy='+SoiQuery.getScreenHeight());
		if (config.TLD) all_collected.push('tld='+SoiEscapedASCII(config.TLD));
		if (nugg) all_collected.push(nugg);
		if (rogator) all_collected.push('KW='+rogator);
		if (yieldprobe) all_collected.push(yieldprobe);
		if (tparam) all_collected.push(tparam);
		if (xx_collected.length) all_collected.push(xx_collected.join(';'));
		if (wefo_collected.length) all_collected.push(wefo_collected.join(';'));
		if (vi_collected.length) all_collected.push(vi_collected.join(';'));
		if (not_collected.length) all_collected.push(not_collected.join(';'));
		if (config.FRA) all_collected.push('ifr=1');
		if (keywords) all_collected.push('KW='+keywords);
		if (exclude_collected.length) all_collected.push(exclude_collected.join(';'));
		if (ap_campaign_params) all_collected.push(ap_campaign_params); // Needed as booking condition
		all_collected.push('tile='+tile);
		all_collected.push('ord='+window.DFPOrd);

		var src = base_url + '/' + mime_part + '/' + all_collected.join(';') + '?';

		// On special request - links for showroom DPF URLs
		msg += (SoiGetShowroomParam('showroom') ? 'SOISALABIM<a href="' + src + '" target="_blank">SOISALABIM' + src + 'SOISALABIM<\/a>SOISALABIM' : src) + '\n';

		src_only = is_video || (data.rp && data.noload) ? true : false;
		retval = src_only ?
			  src
			: '<script type="text/javascript" src="'+src+'"><\/script>';
	}
	
	SoiLogger.logMsg('soi_Tagwriter called for ' + platz + ' - DFPOrd ' + window.DFPOrd + ' - tile ' + tile + '\n' + (msg ? '\n' + msg : ''), data);

	if (config.WRITE_TAG && !src_only) {
		if (retval) document.write(retval);
		// IMPORTANT:
		// Reset to empty string to return empty string
		retval = '';
	}

	return retval;
}

function soi_VideoAdRequest(platz, data)
{
	if (!window.DFPSite || !window.DFPZone) return '';

	SoiLogger.addSeparator(1, platz);
	SoiLogger.logMsg('soi_VideoAdRequest called for ' + platz);

	var retval = '';
	try {
		retval = soi_Tagwriter(platz, data);

		// Only defined dynamically if needed
		if (retval && SoiUtils.debugTracking) {
			try {
				SoiUtils.debugTracking(platz);
			}
			catch(e) {
				SoiLogger.logMsg('Call to SoiUtils.debugTracking failed for ' + platz + ': ' + e.message, data);
			}
		}
	}
	catch(e) {
		SoiLogger.logMsg('soi_VideoAdRequest failed for ' + platz + ': ' + e.message, data);
	}

	return retval;
}

// - For external usage:
//   fire request
//   soi_RP('fullbanner2', {partner: 'adscale'});
//   return request url or empty string
//   var url = soi_RP('fullbanner2', {partner: 'groupm', noload: true});
//   possibly existing site and/or zone properties will be ignored
// - For internal usage only (maybe for certain reload situations):
//   soi_RP('fullbanner2', {reset: true});
function soi_RP(platz, data)
{
	var self = arguments.callee;
	if (!self.seen) {
		self.seen = {};
		self.counter = {};
	}

	if (SoiIsVideo(platz)) return '';
	if (!data.partner) data.partner = 'other';

	if (!SoiUtils.isObject(data)) data = {};

	if (!self.seen[platz] || data.reset) {
		self.seen[platz] = {};
		self.counter[platz] = 0;
		if (data.reset) {
			SoiLogger.logMsg('Resetting soi_RP counter for ' + platz);
			return '';
		}
	}

	if (++self.counter[platz] > 3) {
		SoiLogger.logMsg('Rejecting soi_RP for ' + platz + ' because rp counter ' + self.counter[platz] + ' is too high (partner ' + data.partner + ')');
		return '';
	}
	else if (self.seen[platz][data.partner]) {
		SoiLogger.logMsg('Rejecting soi_RP for ' + platz + ' because partner ' + data.partner + ' already seen before');
		return '';
	}

	SoiLogger.logMsg('soi_RP called for ' + platz + ' (counter ' + self.counter[platz] + ', partner ' + data.partner + ')');

	// Not earlier
	self.seen[platz][data.partner] = 1;

	// Pass a copy!
	var seen = {};
	for (var k in self.seen[platz]) {
		seen[k] = self.seen[platz][k];
	}
	
	if (window.soi_adtrace && !data.noload) {
		window.soi_adtrace = window.soi_adtrace.replace(
				new RegExp('^' + platz, 'm'),
				'rp' + (self.counter[platz] - 1) + ' ' + platz.split('').reverse().join('')
			);
	}
	
	var retval = soi_Tagwriter(platz,
		{
			rp:     true,
			site:   window.DFPSiteRP || 'RP_OTHER',
			zone:   data.partner || 'other',
			seen:   seen,
			noload: data.noload ? true : false
		});
	
	if (!data.noload) {
		document.write(retval);
		// IMPORTANT:
		// Reset to empty string to return empty string
		retval = '';
	}

	return retval;
}

function soi_SyncVars(from, to)
{
	if (window.SOI_NOSYNC) return;
	if (!SoiUtils.isObject(from) || !SoiUtils.isObject(to)) return;
	if (from == to) return;
	
	var from_label;
	var to_label;
	if (from == parent) {
		from_label = 'parent';
		to_label   = 'iframe ' + (to.frameElement ? to.frameElement.id || '' : '');
		SoiLogger.addSeparator(2);
	}
	else {
		from_label = 'iframe ' + (from.frameElement ? from.frameElement.id || '' : '');
		to_label   = 'parent';
	}

	SoiLogger.logMsg('soi_SyncVars from ' + from_label + ' to ' + to_label, {}, 2);

	var varnames = SoiDearOldGlobals('SyncVars');
	for (var i = 0; i < varnames.length; i++) {
		if (varnames[i] == 'DFPTile') {
			soi_SyncDFPTile(from, to, '(caller soi_SyncVars)');
		}
		else {
			to[varnames[i]] = from[varnames[i]];
		}
	}
}

function soi_SyncDFPTile(from, to, msg)
{
	if (window.SOI_NOSYNC) return;
	if (from == to) return;
	try {
		if (!from.globalV6 || !to.globalV6) return;
		if (!SoiUtils.isNumber(from.DFPTile)) return;

		var from_label;
		var to_label;
		if (from == parent) {
			from_label = 'parent';
			to_label   = 'iframe ' + (to.frameElement ? to.frameElement.id || '' : '');
		}
		else {
			from_label = 'iframe ' + (from.frameElement ? from.frameElement.id || '' : '');
			to_label   = 'parent';
		}

		if (!SoiUtils.isNumber(to.DFPTile) || (from.DFPTile || 0) > (to.DFPTile || 0)) {
			// Log first.
			SoiLogger.logMsg('soi_SyncDFPTile from ' + from_label + ' to ' + to_label
				+ (msg ? ' ' + msg : '')
				+ ': increasing ' + to_label + ' value from ' + to.DFPTile + ' to ' + from.DFPTile, {}, 2);

			// Assign then.
			to.DFPTile = from.DFPTile;
		}
		else {
			if ((from.DFPTile || 0) == (to.DFPTile || 0)) {
				msg += ': ' + to_label + ' and ' + from_label + ' values are already identical: ' + to.DFPTile;
			}
			else {
				msg += ': not decreasing ' + to_label + ' value from ' + to.DFPTile + ' to ' + from.DFPTile;
			}
			SoiLogger.logMsg('soi_SyncDFPTile from ' + from_label + ' to ' + to_label + (msg ? ' ' + msg : ''), {}, 3);
		}
	}
	catch(e) {}
}

function soi_ResetVars()
{
	SoiLogger.logMsg('soi_ResetVars called');

	var varnames = SoiDearOldGlobals('SyncVars');

	// Declare but do not define variable.
	// This is necessary because very old or exotic browsers
	// might not have native undefined property.
	var my_undefined;

	for (var i = 0; i < varnames.length; i++) {
		// Must be set to undefined, not to null!
		window[varnames[i]] = my_undefined;
	}
}

function soi_IndustryParams(data)
{
	var ind_params = '';

	if (data && SoiUtils.isObject(data.industries)) {
		var seen = {};
		for (var key in data.industries) {
			if (!data.industries[key]) continue;

			var value = String(data.industries[key].industry || '');
			value = value.replace(/^ +/, '').replace(/ +$/, '');
			if (!value) continue;
			
			// Avoid duplicates
			if (seen[value]) continue;
			seen[value] = 1;

			if (ind_params) ind_params += ';';
			ind_params += 'ind=' + SoiEscapedASCII(value);
		}
	}

	return ind_params;
}

/******************************************
Functions for internal usage
******************************************/

/*
	Functions for variable initialisation
*/
function SoiInitDFPVars()
{
	// Workaround for Facebook ILike Button bug (i.e. second load of page with url parameter fb_xd_fragment)
	var fb_like_bug = window.location.search.match(/[?&;]fb_xd_fragment(?:[&;=]|$)/) ? true : false;
	if (fb_like_bug) {
		SoiLogger.logMsg('REFUSING AD DELIVERY: detected Facebook ILike Button bug - url parameter *fb_xd_fragment*');
		window.DFPSite = window.DFPZone = '';
	}
	else if (window.location.protocol == 'file:') {
		SoiLogger.logMsg('REFUSING AD DELIVERY: for ' + window.DFPSite + '/' + window.DFPZone + ' with file protocol');
		window.DFPSite = window.DFPZone = '';
	}
	if (!window.DFPSite || !window.DFPZone) return;

	window.DFPTile = 0;
	if (window.DFPOrd) {
		var length = String(window.DFPOrd).length;
		if (length < 30) {
			// Do not refresh, but modify value by appending 1s to simplify debugging
			window.DFPOrd += '1';
		}
		else {
			// Very unlikely to happen - but if so: limit length of DFPOrd
			window.DFPOrd = String(window.DFPOrd).replace(/(1{11,})([0-9]+)?$/,
					function(a, b, c) {
						var x = (Number(c) || 0) + 1;
						var y = 4 - String(x).length;
						if (y > 0) for (var i = 0; i < y; i++) x = '0' + x;
						return [b.replace(/0+$/, ''), 0, x].join('');
					}
				);
		}
	}
	else {
		window.DFPOrd = Math.floor(Math.random()*10000000000);
	}

	// Must be stored before showroom handling
	var is_session_start = window.SOI_INIT_DONE ? false : true;

	// Adjusts DFPSite and DFPZone for showroom,
	// and SOI_INIT_DONE for special showroom.
	// Must happen before setting defaults.
	SoiGetShowroomParam('INIT');

	if (!window.DFPSite) window.DFPSite = '';
	if (!window.DFPZone) window.DFPZone = 'other';

	if (is_session_start) {
		SoiLogger.logMsg('STARTING SESSION ' + [window.DFPOrd, window.DFPSite, window.DFPZone].join(' - '), {new_session: true});
	}
}

function SoiInitMoreVars()
{
	// Currently all ads *declare* soi_adtrace with *var*
	// under the condition that the variable has not been set.
	// This clobbers the value in IE
	// even if the variable was defined and not empty before.
	// The following definition prevents this error.
	if (!window.soi_adtrace) window.soi_adtrace = '';
	if (!window.soi_dimension) window.soi_dimension = {};

	// Variables defined for backwards compatibility.
	window.DFP      = true;
	window.DFPVideo = true;
	window.add2tag  = '';
	if (!window.SOI_GLOBALV) window.SOI_GLOBALV = 'V6'; // SIC!
	
	// Adjusting SOI_PU, setting SOI_PUX, setting cookie
	SoiCanPU();

	// Default values for video ads
	if (typeof(window.SoiSetPre)       == 'undefined') window.SoiSetPre       = 1;
	if (typeof(window.SoiSetSpon)      == 'undefined') window.SoiSetSpon      = 1;
	if (typeof(window.SoiSetPreSplit)  == 'undefined') window.SoiSetPreSplit  = 0;
	if (typeof(window.SoiSetMid)       == 'undefined') window.SoiSetMid       = 3;
	if (typeof(window.SoiSetPostSplit) == 'undefined') window.SoiSetPostSplit = 0;
	if (typeof(window.SoiSetOva)       == 'undefined') window.SoiSetOva       = 1;
	if (typeof(window.SoiSetSpon2)     == 'undefined') window.SoiSetSpon2     = 0;
	if (typeof(window.SoiSetPost)      == 'undefined') window.SoiSetPost      = 1;
	if (typeof(window.SoiSetPause)     == 'undefined') window.SoiSetPause     = 1;
	
	// Variable is used in template :(
	if (typeof(window.SOI_AFFILIATE) == 'undefined') window.SOI_AFFILIATE = '';

	// Initialisation for old-style shoppingtipps
	// FIXME: remove as soon as SIMAD does not use this any more
	window.SOI_ZAHL  = 0;
	window.SOI_place = ['leer', 'shoppingtipp1', 'shoppingtipp2', 'shoppingtipp3', 'shoppingtipp4', 'shoppingtipp5'];
}

// Syndication
function SoiGetNetworkPartnerID()
{
	if (!window.SOI_PARTNER) return;
	
	// Backwards compatibility
	if (Number(window.SOI_PARTNER) > 99 && Number(window.SOI_PARTNER) < 150)
		return window.SOI_PARTNER;

	var lookup = {
		'lokalisten': 100,
		't-online':   101,
		'studivz':    102,
		'schuelervz': 102,
		'meinvz':     102,
		'icq':        103,
		'fem':        104,
		'promiflash': 105,
		'sevenload':  106,
		'spox':       107,
		'welt':       108,
		'bunte':      109,
		'autoplenum': 110,
		'love-green': 111,
		'sport1':     112
	};
	
	return lookup[window.SOI_PARTNER] || 999;
}

function SoiGetTile(platz, is_video, vpos)
{
	// myvideo issue
	if (platz == 'popup1') {
		try {
			var my_undefined;
			if (parent != window) parent.DFPTile = my_undefined;
		}
		catch(e) {}
	}
	
	// Increase and sync tile counter
	soi_SyncDFPTile(parent, window, ' - pre-sync for ' + platz + ' (caller SoiGetTile)');
	var tile;
	var do_sync = false;
	if (is_video) {
		// Do not anchor the regex to the start position (e modifier)!
		if (platz.match(/(preroll|sponsor1)/)) {
			// preroll and sponsor1 block
			tile = ++window.DFPTile;
			do_sync = true;
		}
		else {
			// all other video ads (including sponsor2)
			tile = vpos || 1;
		}
	}
	else {
		tile = ++window.DFPTile;
		do_sync = true;
	}
	SoiLogger.logMsg('SoiGetTile set tile for ' + platz + ' to ' + tile, {}, 2);
	if (do_sync) soi_SyncDFPTile(window, parent, ' - post-sync for ' + platz + ' (caller SoiGetTile)');

	// FIXME: must be <= 16
	return tile;
}

function SoiDearOldGlobals(which)
{
	var dear_old_globals = [
			'SOI_SITE', 'SOI_AFFILIATE', 'SOI_SUBSITE', 'SOI_SUB2SITE', 'SOI_SUB3SITE', 'SOI_SUB4SITE', 'SOI_SUB5SITE', 'SOI_SUB6SITE',
			'SOI_MARKETINGCLUSTER', 'SOI_CONTENT', 'SOI_MOBILEGATE',
			'SOI_WERBUNG', 'SOI_PU1', 'SOI_FB2', 'SOI_SC1', 'SOI_RT1', 'SOI_RT1B', 'SOI_RT2', 'SOI_RT3', 'SOI_FB1',
			'SOI_PB1', 'SOI_PB2', 'SOI_PB3', 'SOI_PB4', 'SOI_PB5', 'SOI_TS1', 'SOI_MA1', 'SOI_MA2', 'SOI_TSA', 'SOI_TSB', 'SOI_TSC', 'SOI_PF1', 'SOI_PF2', 'SOI_PF3', 'SOI_PF4',
			'SOI_VP', 'SOI_VA1', 'SOI_VA2', 'SOI_VA3', 'SOI_VA4', 'SOI_VA5', 'SOI_LPY',
			'SOI_SOWEFO', 'SOI_PU', 'SOI_PUX', 'SOI_PL', 'SOI_FA', 'SOI_PB', 'SOI_PD', 'SOI_BB', 'SOI_WP', 'SOI_FP', 'SOI_PR', 'SOI_HP', 'SOI_SB', 'SOI_SK',
			'SOI_TPARAM', 'SOI_UPC', 'SOI_PARTNER', 'SOI_AGOFID', 'SOI_TCLUSTER', 'SOI_TWORD', 'SOI_KEYWORDS',
			'SOI_CLUSTER', 'SOI_EXCL', 'SOI_PLAYER', 'SOI_AUTOPLAY', 'SOI_KEYVALUE', 'SOI_TLD', 'SOI_DEBUG_TRACKING'
		];

	var retval = [];
	for (var i = 0; i < dear_old_globals.length; i++) {
		retval.push(dear_old_globals[i]);
	}
	
	if (which == 'Tagwriter' || which == 'Logger') {
		retval.push('SOI_WRITE_TAG', 'SOI_FRA', 'SOI_NOSYNC', 'SOI_INIT_DONE')
	}
	
	// Separate block
	if (which == 'SyncVars' || which == 'Logger') {
		retval.unshift('DFPOrd', 'DFPSite', 'DFPZone', 'DFPSiteRP');
		retval.push('SoiSetPre', 'SoiSetSpon', 'SoiSetPreSplit', 'SoiSetMid', 'SoiSetPostSplit', 'SoiSetOva', 'SoiSetSpon2', 'SoiSetPost', 'SoiSetPause');
		if (which == 'SyncVars') {
			retval.push('soi_adtrace', 'soi_dimension',	'DFPTile');
			retval.push('rsinetsegs');
		}
		else if (which == 'Logger') {
			retval.unshift('SOI_IDENTIFIER', 'SOI_RELAUNCH');
			retval.push('SOI_ROGATOR', 'SOI_ADA', 'SOI_NUGGSID');
		}
	}

	return retval;
}

/*
	AdProbe
*/
window.SoiAP = {
	disabled:    true, // initially always disabled
	initialized: false,
	cookie_name: 'SoiAP',
	config: {members: [], db: {}},
	max_recommendations_per_unit: 7,

	// The init method is always executed on loading of script
	// even if SOI_INIT_DONE is true.
	// This is important in domino iframes.
	init: function() {
		if (this.initialized) return this.disabled ? false : true;
		this.initialized = true;
		
		// null, no object or array
		if (!window.SOI_AP || typeof(window.SOI_AP) != 'object' || typeof(window.SOI_AP.length) != 'undefined') {
			SoiLogger.logMsg('SoiAP.init failed: SOI_AP not defined or invalid');
			return false;
		}
		
		this.config.force_test = SoiGetShowroomParam('yshowroom', 'force') ? true : false;
		try {
			// For tearsheet tests: yshowroom=23456
			var found = top.location.search.match(/[?&]yshowroom=(?:wl)?([0-9]{4,10})(?:[&#]|$)/);
			if (found) this.config.force_campaign = found[1];
		}
		catch(e) {}

		var lookup = {
				'adaudience': 'aa',
				'procter':    'pr'
			};

		try {
			var critical_exclusions = String(window.SOI_EXCL).match(/(?:^|,)(fi|ga)(?:,|$)/) ? true : false;
			for (var member in window.SOI_AP) {
				if (!lookup[member]) {
					SoiLogger.logMsg('SoiAP.init skipping unknown member: ' + member);
					continue;
				}
				var config = window.SOI_AP[member];
				if (!config || config.disabled || !config.ids || !config.units) continue;
				if (member == 'adaudience' && !window.SOI_ADA) continue;
				// adaudience is master if present
				this.config.members[member == 'adaudience' ? 'unshift' : 'push'](member);
				this.disabled = false;

				this.config[member] = {ids: {}, units: {}}; // used in loadCampaign and getURL

				for (var id in config.ids) {
					this.config[member].ids[id] = config.ids[id]; // queried in getURL
				}

				UNITS:
				for (var unit in config.units) {
					var unit_id = config.units[unit];
					var parts = unit.match(/(.+[0-9])?(.*)/);
					if (!parts) continue;
					// might result in pseudo varname SOI_NN*
					var varname = parts[1] ? 'SOI_' + String(parts[1] || '').toUpperCase() : '';
					var others = String(parts[2] || '');
					var low = others.match(/low/) ? true : false;
					var expandable = others.match(/exp/) ? true : false;
					var sowefos = others.replace(/(exp|low)/g, '').match(/([a-z]{2})/g) || [];
					if (expandable) sowefos.push('exp');
					
					var ok = false;
					if (varname.match(/^SOI_NN[0-9]+$/)) {
						// no name - not associated with specific ad_id and/or sowefo
						switch (member) {
							case 'adaudience':
								// adaudience variable unit nn1 ... nn3 (obsolete)
								ok = true;
								break;
							case 'procter':
								// procter global unit nn1
								ok = window.SOI_PU1 || window.SOI_FB2 || window.SOI_SC1 || window.SOI_RT1 ? true : false;
								break;
						}
					}
					else if (varname == 'SOI_MA1') { // SIC!
						// FIXME: variables possibly not set => not working reliably
						ok = window.SOI_MA1 || window.SOI_TS1;
						// FIXME: allow maxiad for bigpoint logout
						// set SOI_MA1 on logout pages??
					}
					else {
						if (member == 'adaudience') {
							ok = critical_exclusions && low ? false : window[varname];
						}
						else {
							ok = window[varname];
						}
					}
					if (!ok) continue;

					var sowefo_varnames = [];
					if (sowefos && sowefos.length) {
						for (var j = 0; j < sowefos.length; j++) {
							var sowefo = 'SOI_' + sowefos[j].toUpperCase();
							switch (sowefo) {
								case 'SOI_BR':
									sowefo = 'SOI_PL';
									break;
								case 'SOI_EXP': // FIXME: or ignore?
									sowefo = 'SOI_PL';
									break;
							}
							if (!window[sowefo]) continue UNITS; // all sowefos must match
							sowefo_varnames.push(sowefo);
						}
					}

					// both structures are needed
					this.config[member].units[unit] = unit_id; // for convenience in loadCampaign
					this.config.db[unit_id] = {
							unit:   unit,
							member: member,
							key: [lookup[member], unit].join(''),
							varname: varname,
							sowefos: sowefo_varnames || [], // probably not used at all
							campaign_ids: []
						};
				}
			}
		}
		catch (e) {}

		SoiLogger.logMsg('SoiAP.init: SoiAP is ' + (this.disabled ? 'disabled' : 'enabled'));
		return this.disabled ? false : true;
	},

	initAP: function() {
		this.init();
		if (this.disabled) return;
		if (window.SOI_VP && window.SOI_AUTOPLAY != 'off') {
			SoiLogger.logMsg('SoiAP.initAP: skipped because SOI_VP = ' + window.SOI_VP + ' in autoplay mode');
			return;
		}

		var server = this.getURL('AP');
		if (!server) return;

		var unit_ids = this.getUnitIDs() || [];
		if (!unit_ids.length) return;

		// Experimental feature to speed up requests by grouping unit ids
		var pubkeys = '';
		if (unit_ids.length && SoiGetShowroomParam('yshowroom', 'fastap')) {
			var group_size = 4;
			for (var i = 0; i < unit_ids.length; i++) {
				pubkeys += (parseInt(i / group_size) + 1) + ',';
			}
			pubkeys = pubkeys.replace(/,+$/, '');
			if (pubkeys) pubkeys = 'PubKeys=' + pubkeys + '&';
		}

		var src = server + '?' + pubkeys + 'cus=' + unit_ids.join(',') + '&ord=' + window.DFPOrd;
		SoiLogger.logMsg('SoiAP.initAP called: ' + src);
		
		document.write('<script type="text/javascript" src="' + src + '"><\/script>');
		
		// For showroom testing: overload wl*camp values with test campaign ids
		if (this.config.force_test)
			document.write('<script type="text/javascript" src="http://adserver.71i.de/global_js/Showrooms/audiencescience.js' + (window.SOI_CACHEBUSTER || '') + '"><\/script>');

		return true;
	},

	doProfiling: function() {
		this.init();
		if (this.disabled || !this.config.members) return;

		if (this.config.members[0] == 'adaudience') {
			var src = 'http://js.revsci.net/gateway/gw.js?csid=L11281&auto=t';
			// FIXME: experimental for testing
			var async = SoiGetShowroomParam('yshowroom', 'async');
			var sync  = SoiGetShowroomParam('yshowroom', 'sync');
			if (!sync) {
				var script = document.createElement('script');
				script.id = 'soi-ap-gateway';
				script.type = 'text/javascript';
				script.src = src;
				script.async = true;

				var insertion_point;
				try {
					insertion_point = document.getElementsByTagName('head')[0];
				}
				catch(e) {
					insertion_point = document.body;
				}
				insertion_point.insertBefore(script, insertion_point.firstChild);
			}
			else {
				document.write('<script type="text/javascript" src="' + src + '"><\/script>');
			}
			SoiLogger.logMsg('SoiAP.doProfiling: ' + (async ? 'async' : 'sync') + ' loading of ' + src);
		}
	},

	// without argument => unit ids for all available ad ids and sowefos
	// argument ad_id   => unit ids for specified ad_id and available sowefos
	getUnitIDs: function(ad_id) {
		this.init();
		if (this.disabled || !this.config || !this.config.db) return [];

		var x = [];
		var varname = '';
		if (ad_id) {
			varname = SoiPlatzToVar(ad_id);
			if (varname == 'SOI_TS1') varname = 'SOI_MA1';
			if (!varname) return [];
		}

		for (var unit_id in this.config.db) {
			var n = this.getInfo(unit_id, 'varname') || '';
			var u = this.getInfo(unit_id, 'unit') || '';
			var ok = false;
			// varname is empty if called without ad_id, i.e. for all units
			if (!varname || n == varname) {
				ok = true;
			}
			else if (u.match(/^nn[0-9]+$/)) {
				var m = this.getInfo(unit_id, 'member');
				if (m == 'adaudience'
					|| (m == 'procter' && ad_id.match(/^(popup1|fullbanner2|skyscraper1|rectangle1)$/)))
						ok = true;
			}
			if (ok) x.push(unit_id);
		}
		
		return x.sort();
	},

	setCampaignIDs: function() {
		this.init();
		if (this.disabled || !this.config) return;

		if (this.campaign_ids_initialized) return;
		this.campaign_ids_initialized = true;

		var unit_ids = this.getUnitIDs() || [];
		if (!unit_ids.length) return;

		var ord = window.DFPOrd;

		var done = false;
		for (var i = 0; i < unit_ids.length; i++) {
			var unit_id = unit_ids[i];
			if (!this.config.db[unit_id]) continue; // should never happen
			// backwards compatibility: camp vs. camps
			var value = String(window['wl' + unit_id + 'camps'] || window['wl' + unit_id + 'camp'] || '');
			if (!value && this.config.force_test && this.config.db[unit_id].member == 'procter') {
				// Resolve dummy unit ids for procter
				value = window['wl' + this.config.db[unit_id].unit + 'camps'] || '';
			}
			if (value) {
				done = true;
				var list = value.split(',');
				var max = this.max_recommendations_per_unit;
				if (list.length > max) {
					try {
						var selected = [];
						for (var j = 0; j < max; j++) {
							var index = parseInt(Math.random() * 10000000000) % list.length;
							selected.push(list[index]);
							list.splice(index, 1);
						}
						list = selected;
					}
					catch(e) {}
				}
				this.config.db[unit_id].campaign_ids = list;
			}
		}
		
		if (window != parent) {
			// domino iframe
			if (!window.SOI_INIT_DONE) {
				// set cookie from within master domino iframe
				var c = '';
				for (var i = 0; i < unit_ids.length; i++) {
					var unit_id = unit_ids[i];
					var campaign_ids = this.getInfo(unit_id, 'campaign_ids') || [];
					c += unit_id + ':' + campaign_ids.join(',') + ';';
				}

				// Session cookie only
				// 9684570609-10519:1111,1112,1113;12464:5551,5552,5553;12466:7771,7772,7773;
				if (c) {
					SoiUtils.setCookie(this.cookie_name, {value: ord + '-' + c, path: '/'});
				}
				else {
					SoiUtils.deleteCookie(this.cookie_name);
				}
			}
			else if (!done) {
				// read cookie from within dependent domino iframes
				var cookie = SoiUtils.getCookie(this.cookie_name) || '';
				var regex = new RegExp('^'+ord+'-');
				if (cookie.match(regex)) {
					cookie = cookie.replace(regex, '') || '';
					var data = cookie.split(';');
					for (var i = 0; i < data.length; i++) {
						if (!data[i]) continue;
						var items = String(data[i]).split(':');
						var unit_id = items[0];
						var values  = items[1] || ''; // comma-separated campaign ids
						if (values) this.config.db[unit_id].campaign_ids = values.split(',');
						// copy wl*camp[s] vars to domino iframe
						var name = 'wl' + unit_id + 'camp';
						if (this.config.db[unit_id].campaign_ids.length > 1) {
							window[name + 's'] = values || '';
						}
						else {
							window[name] = window[name + 's'] = values || '';
						}
					}
				}
			}
		}
	},

	getCampaignParams: function(ad_id) {
		this.init();
		if (this.disabled || !this.config) return;

		this.setCampaignIDs();

		var unit_ids = this.getUnitIDs(ad_id) || [];
		if (!unit_ids.length) return '';

		var params = '';
		for (var i = 0; i < unit_ids.length; i++) {
			var unit_id = unit_ids[i];
			var key  = this.getInfo(unit_id, 'key');
			if (!key) continue;
			var campaign_ids = this.getInfo(unit_id, 'campaign_ids') || [];
			for (var j = 0; j < campaign_ids.length; j++) {
				var campaign_id = campaign_ids[j];
				if (campaign_id) params += key + '=' + campaign_id + ';';
			}
		}
		
		return params;
	},

	// For AdProbe delivery from DFP server
	// campaign_id:
	// optional for single recommendations (AdAudience)
	// required for multiple recommendations (Procter)
	loadCampaign: function(config) {
		if (!config || typeof (config) != 'object') return;

		this.setCampaignIDs();

		var ad_id         = config.place;
		var member        = config.type;
		var unit          = config.campaign;
		var campaign_id   = config.campaign_id;
		var clickredirect = config.clickredirect; // currently not used

		// Normalization for DFP
		var normalized = SoiUtils.normalizeClickConfig({clickredirect: clickredirect}) || {};
		if (normalized.clickredirect) clickredirect = normalized.clickredirect;

		this.init();
		if (this.disabled || !this.config) return;

		var unit_id;
		try {
			unit_id = this.config[member].units[unit];
		}
		catch(e) {}

		if (!unit_id) {
			SoiLogger.logMsg('SoiAP.loadCampaign unable to determine unit id for ' + ad_id + ' from: ' + member + ' ' + unit);
			return;
		}

		if (!campaign_id) {
			var campaign_ids = this.getInfo(unit_id, 'campaign_ids') || [];
			if (campaign_ids.length == 1) campaign_id = campaign_ids[0];
			if (!campaign_id || campaign_id.match(/,/)) { // missing or multiple recommendations
				SoiLogger.logMsg('SoiAP.loadCampaign unable to determine valid campaign id for ' + ad_id + ' from: ' + member + ' ' + unit + ' ' + unit_id + ' => ' + campaign_id);
				return;
			}
		}

		// Override campaign id with forced test campaign id (yshowroom=34567, or also yshowroom=wl34567)
		if (this.config.force_campaign) campaign_id = this.config.force_campaign;

		// add campaign id to soi_adtrace
		// yes, this is messy, but helps in case of problems
		// Case 1: soi_adtrace has already been set
		var campaign_info = '- campaignID ' + campaign_id;
		if (window.soi_adtrace) {
			try {
				window.soi_adtrace = window.soi_adtrace.replace(new RegExp('(' + ad_id + '.+)'), '$1 ' + campaign_info);
			}
			catch(e) {}
		}
		// Case 2: soi_adtrace will be set via SoiAdTemplate.setAdTrace
		try {
			SoiAdTemplate.stored[ad_id] = campaign_info;
		}
		catch(e) {}

		var server = this.getURL('CC', unit_id);
		if (!server) return;
		
		var pub_key = this.getInfo(unit_id, 'member') == 'adaudience' ?
			  '&PubKey=71i_' + window.SOI_ADA
			: '';

		var src = server + '?'
			+ 'ord=' + window.DFPOrd
			+ pub_key
			+ '&EAS=camp=' + escape(campaign_id)
			+ ';cu=' + escape(unit_id)
			+ ';cre=mu;js=y;target=_blank;EASClick='; // optionally + escape(clickredirect);
		if (SoiGetShowroomParam('yshowroom', 'inprogress') && clickredirect)
			src += clickredirect;

		SoiLogger.logMsg('SoiAP.loadCampaign for ' + ad_id + ': ' + src);
		
		document.write('<script type="text/javascript" src="' + src +'"><\/script>');
	},

	getURL: function(what, unit_id) {
		this.init();
		if (this.disabled || !this.config || !what) return;
		
		var pub_id;
		var site_id;
		var cu_id;
		
		try {
			var master = this.config.members[0];
			pub_id  = this.config[master].ids.pub_id;
			site_id = this.config[master].ids.site_id;
			cu_id   = unit_id || this.config[master].ids.cu_id;
		}
		catch (e) {}

		if (!pub_id || !site_id || !cu_id) return;

		return [SoiUtils.getProtocol() + '//req.connect.wunderloop.net', String(what).toUpperCase(), pub_id, site_id, cu_id, 'js'].join('/');
	},

	getInfo: function(unit_id, key) {
		if (!this.config.db || !this.config.db[unit_id]) return;
		return this.config.db[unit_id][key];
	}
}

/*
	YieldProbe
*/
window.SoiYieldProbe = {
		disabled: true, // initially disabled
		session: '',
		recommendations: {},
		units: {},
		init: function() {
				if (window.SOI_VP && window.SOI_AUTOPLAY != 'off') {
					SoiLogger.logMsg('SoiYieldProbe.init: skipped because SOI_VP = ' + window.SOI_VP + ' in autoplay mode');
				}
				else if (window.SOI_YP && !window.SOI_YP.disabled && window.SOI_YP.units) {
					this.disabled = false;
				}
				if (this.disabled) return;

				var units = window.SOI_YP.units;
				var params = [];
				for (var k in units) {
					var varname = 'SOI_' + String(k).toUpperCase();
					if (!units[k] || !window[varname]) continue;
					this.units[k] = units[k];
					params.push(units[k]);
				}
				if (params.length) {
					var src = 'http://ad.yieldlab.net/yp/' + params.join(',') + '?' + window.DFPOrd;
					document.write('<script type="text/javascript" src="' + src + '"><\/script>');
					SoiLogger.logMsg('SoiYieldProbe.init: ' + src);
				}
				else {
					this.disabled = true;
				}
			},
		store: function() {
				// always - regardless of disabled state
				var friendly_iframe = SoiUtils.getIFrameRelation() == 1;
				if (window.yl) {
					this.session = window.DFPOrd;
					this.recommendations = {};
					try {
						for (var k in this.units) {
							var id = this.units[k];
							var item = yl.YpResult.get(id);
							if (!item) continue;
							this.recommendations[k] = {};
							/* properties: id, price, advertiser, curl */
							for (var p in item) {
								this.recommendations[k][p] = item[p];
							}
						}
						if (friendly_iframe && window != parent)
							this.sync(window, parent);
					}
					catch(e) {}
				}
				else if (friendly_iframe && parent.SoiYieldProbe) {
					this.sync(parent, window);
				}
			},
		sync: function(from, to) {
				if (from == to || SoiUtils.getIFrameRelation() != 1) return; // identical or non-friendly iframe
				try {
					if (!from.SoiYieldProbe || !to.SoiYieldProbe) return;
					to.SoiYieldProbe.disabled = from.SoiYieldProbe.disabled;
					to.SoiYieldProbe.session  = from.SoiYieldProbe.session;
					to.SoiYieldProbe.recommendations = {};
					to.SoiYieldProbe.units = {};
					if (to.SoiYieldProbe.disabled) return;
					if (from.SoiYieldProbe.units) {
						for (var k in from.SoiYieldProbe.units) {
							to.SoiYieldProbe.units[k] = from.SoiYieldProbe.units[k];
						}
					}
					if (from.SoiYieldProbe.recommendations) {
						for (var k in from.SoiYieldProbe.recommendations) {
							to.SoiYieldProbe.recommendations[k] = {};
							for (var p in from.SoiYieldProbe.recommendations[k]) {
								to.SoiYieldProbe.recommendations[k][p]
									= from.SoiYieldProbe.recommendations[k][p];
							}
						}
					}
				}
				catch(e) {}
			},
		get: function(ad_id) {
				if (this.session != window.DFPOrd || !this.recommendations)
					this.store();
				if (this.disabled) return ''; // not earlier
				
				var varname = SoiPlatzToVar(ad_id);
				if (!varname) return '';
				var id = varname.replace(/^SOI_/, '').toLowerCase();
				
				var active;
				try {
					/* properties: id, price, advertiser, curl */
					var result = this.recommendations[id];
					if (result) {
						active = true;
						if (result.advertiser) SoiAdTemplate.stored[ad_id] = result.advertiser; // for adtrace
					}
				}
				catch(e) {}
				return active ? 'yl=1' : '';
			},
		// For YieldProbe delivery from DFP server
		loadCampaign: function(config) {
				if (this.disabled) return;

				var ad_id = config.place;
				var size = config.size == '468x60' ? '728x90' : config.size;
				if (!ad_id || !size) return;

				var varname = SoiPlatzToVar(ad_id);
				if (!varname) return;

				var id = varname.replace(/^SOI_/, '').toLowerCase();
				var unit_id = this.units[id];
				if (!unit_id) return;

				var publisher_id = 5710;
				var src = 'http://ad.yieldlab.net/d/' + [unit_id, publisher_id, size].join('/') + '?ts=' + window.DFPOrd;

				document.write('<script type="text/javascript" src="' + src + '"><\/script>');
			}
	};

/*
	Nuggad
*/
window.SoiNugg = {
	init: function() {
		if (!window.SOI_NUGGSID) return;

		var subsite  = String(window.SOI_SUBSITE  || '').replace(/_/g, '');
		var sub2site = String(window.SOI_SUB2SITE || '').replace(/_/g, '');
		var sub3site = String(window.SOI_SUB3SITE || '').replace(/_/g, '');

		var params = window.SOI_SITE;
		if (subsite)  params += '_' + subsite;
		if (sub2site) params += '_' + sub2site;
		if (sub3site) params += '_' + sub3site;

		if (window.SOI_CONTENT)  params += '_' + window.SOI_CONTENT;
		if (window.SOI_TCLUSTER) params += '_' + window.SOI_TCLUSTER;
		if (window.SOI_TWORD)    params += '_' + window.SOI_TWORD;

		var src;
		if (window.SOI_NUGGSID) {
			var publisher_id;
			var host = 'http://71i.nuggad.net';
			if (SoiUtils.isMobile()) {
				publisher_id = 126188777;
				// global nuggad variables
				window.nuggdfp  = '';
				window.nuggn    = publisher_id;
				window.nuggsid  = window.SOI_NUGGSID;
				window.nugghost = host;
				window.nuggtg   = params;
				src = host + '/javascripts/nuggad-ls.js';
			}
			else {
				publisher_id = 1272195681;
				src = host + '/rc?'
					+ 'nuggn=' + publisher_id
					+ '&nuggsid=' + window.SOI_NUGGSID
					+ '&nuggtg=' + params;
			}
		}
		if (!src) return;

		SoiLogger.logMsg('SoiNugg.init: ' + src);

		document.write('<script type="text/javascript" src="' + src + '"><\/script>');
	},

	get: function() {
			var self = arguments.callee;

			var cookie_name = 'SoiNug';

			var ord = window.DFPOrd;
			var regex = new RegExp('^'+ord+'-');

			// If value depends on site and zone (i.e. changing with ad reload),
			// self.cookie starts with DFPOrd + '-'.
			// In this case, a non-matching value must be reset.
			// regex test must be accompanied by empty test!
			if (self.cookie && !self.cookie.match(regex)) self.cookie = '';

			if (!self.cookie) {
				var cookie = SoiUtils.getCookie(cookie_name) || '';
				// regex test must be accompanied by empty test!
				if (cookie && cookie.match(regex)) {
					self.cookie = cookie;
				}
				else {
					if (SoiUtils.isMobile() && window.nuggad) {
						try {
							nuggad.init(
								{'rptn-url': window.nugghost},
								function(api) {
									var args = {nuggn: window.nuggn, nuggsid: window.nuggsid};
									if (window.nuggtg) args.nuggtg = window.nuggtg;
									api.rc(args);  
								}
							);
						}
						catch(e) {
							SoiLogger.logMsg('SoiNugg.get failed on mobile ' + SoiUtils.getDevice() + ' for nuggad.init: ' + e.message);
						}

						if (SoiGetShowroomParam('yshowroom', 'readcookie')) {
							try {
								nuggad.read_cookie(); // reads previous cookie, i.e. always lagging behind
							}
							catch(e) {
								SoiLogger.logMsg('SoiNugg.get failed on mobile ' + SoiUtils.getDevice() + ' for nuggad.read_cookie: ' + e.message);
							}
						}
						if (!window.nuggdfp) window.nuggdfp = 'nugg=no'; // FIXME: temporary solution
					}

					if (window.nuggdfp) {
						self.cookie = window.nuggdfp || '';
						if (self.cookie) self.cookie = ord + '-' + self.cookie;
						// Session cookie only
						SoiUtils.setCookie(cookie_name, {value: self.cookie, path: '/'});
					}
				}
			}

			return self.cookie ? self.cookie.replace(/^[0-9]+-/, '') : '';
		}
	};

/*
	Rogator
*/
window.SoiRogator = {
	init: function() {
			if (!window.SOI_ROGATOR) return;
			var protocol = SoiUtils.getProtocol();

			var src = protocol + '//adserver.71i.de/cgi-bin/functions/rogator-kkl2ads.pl?' + window.DFPOrd;

			SoiLogger.logMsg('SoiRogator.init: ' + src);

			document.write('<script type="text/javascript" src="' + src + '"><\/script>');
		},

	get: function() {
			var self = arguments.callee;

			var cookie_name = 'SoiRog';

			var ord = window.DFPOrd;
			var regex = new RegExp('^'+ord+'-');

			// Value may changes with ad reload.
			// self.cookie starts with DFPOrd + '-'
			// Non-matching value must be reset.
			if (self.cookie && !self.cookie.match(regex)) self.cookie = '';

			if (!self.cookie) {
				var cookie = SoiUtils.getCookie(cookie_name) || '';
				if (cookie.match(regex)) {
					self.cookie = cookie;
				}
				else {
					var map = {
						KEINKEKS:      'rog1',
						KEINEKONTAKTE: 'rog2',
						KEINKKLC:      'rog3',
						BEFRAGT:       'rog4',
						GESEHEN:       'rog5',
						JA:            'rog6'
					};
					self.cookie = '';
					if (window.SOI_rogator_kkl) {
						// KEINKEKS|KEINEKONTAKTE|KEINKKLC|o107a102... (pattern: 1 letter, 3 digits)
						var value = map[window.SOI_rogator_kkl]
							|| window.SOI_rogator_kkl.replace(/([0-9])([a-z])/g, '$1,$2');
						if (value) {
							if (self.cookie) self.cookie += ',';
							self.cookie += value;
						}
					}
					if (window.SOI_rogator_kklcount) {
						// a02o07... (pattern: 1 letter, 2 digits)
						var value = window.SOI_rogator_kklcount.replace(/([0-9])([a-z])/g, '$1,$2');
						if (value) {
							if (self.cookie) self.cookie += ',';
							self.cookie += value;
						}
					}
					if (window.SOI_rogator_allow) {
						// BEFRAGT|GESEHEN|JA
						var value = map[window.SOI_rogator_allow];
						if (value) {
							if (self.cookie) self.cookie += ',';
							self.cookie += value;
						}
					}

					// b201,a201,o201,o108,a01,b01,o09,rog6 or rog1,rog6
					self.cookie = ord + '-' + self.cookie;
					// Session cookie only
					SoiUtils.setCookie(cookie_name, {value: self.cookie, path: '/'});
				}
			}

			return self.cookie ? self.cookie.replace(regex, '') : '';
		}
	};

window.SoiPrivacyInfo = {
		version: '2.0.2.FINAL',
		globalID: 'soi-global-privacy-info',
		init: function() {
				if (window != parent) return;

				if (SoiUtils.isMobile()) return;
				// FIXME: for testing only - remove eventually
				if (SoiGetShowroomParam('yshowroom', 'nooba')) return;
				if (window.SOI_NO_OBA && !SoiGetShowroomParam('yshowroom', 'forceoba')) return;

				var protocol = SoiUtils.getProtocol();
				var version = this.version;
				var base = protocol + '//ad.71i.de/global_js/AdPlayer/adplayer-v' + version;
				var src = base + '/js/adplayer.min.js';
				SoiLogger.logMsg('SoiPrivacyInfo.init: '+ src);
				
				var stylesheet = base + '/css/adplayer.min.css'
				SoiUtils.addStyleSheet(stylesheet);
				try {
					var script = document.createElement('script');
					script.type = 'text/javascript';
					script.src = src;
					script.async = true;
					document.getElementsByTagName('head')[0].appendChild(script);
				}
				catch(e) {}

				// Closure
				var that = this;
				setTimeout(
						function() {
							var ok = false;
							if (!arguments.callee.start) arguments.callee.start = (new Date()).getTime();
							var time_passed = (new Date()).getTime() - arguments.callee.start;
							// body not yet existent if starting in head
							if (window.$ADP && window.document.body) {
								ok = that.initGlobalPrivacyInfo();
								if (ok) SoiLogger.logMsg('SoiPrivacyInfo.initGlobalPrivacyInfo successful after ' + time_passed + ' msecs');
							}
							if (!ok) {
								if (time_passed < 10000) {
									setTimeout(arguments.callee, 100);
								}
								else {
									SoiLogger.logMsg('Error: Timeout for SoiPrivacyInfo.initGlobalPrivacyInfo not successful after 10secs');
								}
							}
						},
						100
					);
			},
		initGlobalPrivacyInfo: function() {
				if (!window.$ADP) {
					SoiLogger.logMsg('Error: SoiPrivacyInfo.initGlobalPrivacyInfo failed for global privacy button: $ADP unavailable');
					return;
				}
				
				var text      = 'Datenschutz und Cookies';
				var linktext  = 'Deaktivieren';
				var use_popup = false;
				
				var ok = false;
				try {
					// optional 3rd argument: callback function
					var oba_id = parseInt(Math.random() * 1000000000);
					var items = [];
					if (window.SOI_NUGGSID) items.push(
							{
								title:    'Nugg.ad AG',
								url:      'http://ad-choices.nuggad.net',
								text:     text,
								linkText: linktext,
								usePopup: use_popup
							}
						);

					if (window.SOI_AP) {
						if (window.SOI_AP.adaudience && !window.SOI_AP.adaudience.disabled) items.push(
								{
									title:    'AdAudience GmbH/AudienceScience',
									url:      'http://www.adaudience.de/index.php?id=23',
									text:     text,
									linkText: linktext,
									usePopup: use_popup
								}
							);
						if (window.SOI_AP.procter && !window.SOI_AP.procter.disabled) items.push(
								{
									title:    'AudienceScience',
									url:      'http://www.audiencescience.com/de/privacy/',
									text:     text,
									linkText: linktext,
									usePopup: use_popup
								}
							);
					}

					if (window.SOI_YP && !window.SOI_YP.disabled) items.push(
							{
								title:    'Yieldlab GmbH',
								url:      'http://www.yieldlab.de/kontakt/privacy/',
								text:     text,
								linkText: linktext,
								usePopup: use_popup
							}
						);

					items.push(
							{
								title:    'SevenOne Media GmbH',
								url:      'http://www.sevenonemedia.de/web/sevenone/datenschutzbestimmungen',
								text:     '',
								linkText: 'Weitere Informationen',
								usePopup: use_popup
							}
						);

					if (items.length) {
						for (var i = 0; i < items.length; i++) {
							$ADP.Registry.register(oba_id, items[i]);
						}

						var header = '<strong class="adp-header-strong">Informationen zu nutzungsbasierter Online-Werbung</strong><br/>Auf der vorliegenden Website werden Ihre Nutzungsdaten anonym erhoben bzw. verwendet, um Werbung f&uuml;r Sie zu optimieren. Wenn Sie keine nutzungsbasierte Werbung mehr von den hier gelisteten Anbietern erhalten wollen, k&ouml;nnen Sie die Datenerhebung beim jeweiligen Anbieter direkt deaktivieren. Eine Deaktivierung bedeutet nicht, dass Sie k&uuml;nftig keine Werbung mehr erhalten, sondern lediglich, dass die Auslieferung der konkreten Kampagnen nicht anhand anonym erhobener Nutzungsdaten ausgerichtet ist.';
						var footer = 'Wenn Sie mehr &uuml;ber nutzungsbasierte Online-Werbung erfahren wollen, klicken Sie <a href="http://meine-cookies.org" target="_blank">hier</a>. Dort k&ouml;nnen Sie dar&uuml;ber hinaus auch bei weiteren Anbietern die Erhebung der Nutzungsinformationen deaktivieren bzw. aktivieren und den Status der Aktivierung bei unterschiedlichen Anbietern <a href="http://meine-cookies.org/cookies_verwalten/praeferenzmanager-beta.html" target="_blank">einsehen</a>.';

						var container_id = this.globalID;
						if (false && 'FIXME') SoiUtils.addStyleElement(
								  '#' + container_id + ' .adp-panel {padding: 5px; width: 420px;}\n'
								+ '#' + container_id + ' .adp-panel-header, '
								+ '#' + container_id + ' .adp-header-strong, '
								+ '#' + container_id + ' .adp-panel-info, '
								+ '#' + container_id + ' .adp-panel-footer {text-align: left !important; line-height: 1.3 !important;}'
							);

						$ADP.Registry.createPlayer(oba_id,
							{
								domId:    container_id, 
								position: 'top-right',
								header:   header,
								footer:   footer,
								usePopup: false
							}
						);

						// Wrapper for privacy button
						var container = document.createElement('div');
						container.id = this.globalID;
						container.style.position = 'fixed';
						container.style.zIndex   = 1999999999;
						container.style.top      = '0px';
						container.style.right    = '0px';
						document.body.insertBefore(container, document.body.firstChild);

						// Closure
						var that = this;
						SoiUtils.addEventHandler(window, 'load', function() {that.showGlobalPrivacyInfo();});
					}
					ok = true;
				}
				catch(e) {
					SoiLogger.logMsg('SoiPrivacyInfo.initGlobalPrivacyInfo failed: ' + e.message);
				}
				return ok;
			},
		showGlobalPrivacyInfo: function() {
				var container_id = this.globalID;
				var container = document.getElementById(container_id);
				if (!container) return;
				container.style.display = 'block';
				container.style.zIndex  = 2000000111; // 3rd party banderole issue
			}
	};

/*
	Utils
*/
window.SoiUtils = {
		flash_version:          0,
		flash_version_tested:   0,
		flash_version_required: 7,
		device:                 '',
		setCookie: function(name, data) {
				if (!data) data = {};
				if (typeof(data.value) == 'undefined') data.value = '';
				if (!data.path) data.path = '/';

				var pairs = [];
				pairs.push([name, escape(String(data.value) || '')].join('='));

				var expires = data.expires;
				if (expires && typeof(expires) == 'number') {
					expires = new Date(expires);
				}

				if (!expires && typeof(data.maxage) != 'undefined') {
					if (data.maxage) {
						expires = new Date();
						// Date in the future
						expires.setTime(expires.getTime() + data.maxage);
					}
					else {
						// Date in the past, i.e. deletion
						expires = new Date(1000);
					}
				}

				if (expires) {
					pairs.push(['expires', expires.toGMTString()].join('='));
				}

				var keys = ['domain', 'path'];
				for (var i = 0; i < keys.length; i++) {
					var key = keys[i];
					if (data[key]) pairs.push([key, data[key]].join('='));
				}
				
				if (data.secure) pairs.push('secure');

				document.cookie = pairs.join('; ');
			},
		// Return value is either undefined,
		// or a value of type *string*.
		// Please note that String(0) is true!
		getCookie: function(name) {
				if (!document.cookie) return;

				var found = document.cookie.match(new RegExp('(?:^|; )' + name + '=' + '([^;]+)'));
				if (!found) return;

				return unescape(found[1]);
			},
		deleteCookie: function(name, data) {
				if (!data) data = {};
				this.setCookie(name,
						{
							path:   data.path,
							domain: data.domain,
							maxage: 0
						}
					);
			},
		// For use in popup1 ad templates
		checkPopUp: function(popup_window) {
				// Test for existence of close function is required for Opera.
				// Caveat: IE has typeof(popup_window.close) == 'object' instead of 'function'
				var ok = popup_window && popup_window.close ? true : false;
				if (!ok) {
					var cookie_name = 'SoiPbl';
					var maxage = 24 * 3600 * 1000;
					this.setCookie(cookie_name, {value: String(1), path: '/', maxage: maxage});
				}
				return ok;
			},
		getProtocol: function() {
				return 'http:'; // https not supported
				return window.location.protocol == 'https:' ? 'https:' : 'http:';
			},

		isNumber: function(arg) {
				return typeof(arg) == 'number' && isFinite(arg);
			},
		// Returns false for null, returns true for array.
		isObject: function(arg) {
				return arg && typeof(arg) == 'object' ? true : false;
			},
		getFlashVersion: function(required) {
				if (!required) required = this.flash_version_required;
		
				if (!this.flash_version || (this.flash_version < required && this.flash_version_tested < required)) {
					var available;

					if (window != parent) {
						try {
							available = parent.SoiUtils.getFlashVersion(required);
						}
						catch(e) {}
					}

					if (!available) {
						if (navigator.plugins && navigator.mimeTypes.length) {
							var todos = ['Shockwave Flash 2.0', 'Shockwave Flash'];
							for (var i = 0; i < todos.length; i++) {
								var plugin = navigator.plugins[todos[i]];
								if (!plugin) continue;
								available = plugin.description;
								break;
							}
						}
						else if (window.ActiveXObject) {
							var upper = parseInt(required);
							if (!upper || upper == 6) upper = 7;
							for (var i = upper; i > 1; i--) {
								try {
									var plugin = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.' + i);
									if (!plugin) continue;

									// IE crashes for some subversions of 6 when using GetVariable
									// (Never start from upper = 6)
									if (i != 6) {
										try {
											// This returns the current version
											// which might be higher than i
											available = plugin.GetVariable('$version') || i;
										}
										catch(e) {}
									}
									if (!available) available = i;
									break;
								}
								catch(e) {}
							}
						}
					}

					this.flash_version_tested = required;
					this.flash_version = parseInt(String(available).replace(/^[^0-9]+/, '')) || 0;
				}

				return this.flash_version;
			},
		// css_text: stylesheet url
		// id:       optional
		addStyleSheet: function(href, id) {
				if (!href) return;

				var insertion_point;
				try {
					insertion_point = document.getElementsByTagName('head')[0];
				}
				catch(e) {
					insertion_point = document.body;
				}
				
				var link = document.createElement('link');
				link.type = 'text/css';
				link.rel  = 'stylesheet';
				link.href = href;
				if (id) link.id = id;
				insertion_point.appendChild(link);
			},
		// css_text: 'body {font-size: 11px;} .pretty {color: green;}'
		// id:       optional
		addStyleElement: function(css_text, id) {
				if (!css_text) return;

				var insertion_point;
				try {
					insertion_point = document.getElementsByTagName('head')[0];
				}
				catch(e) {
					insertion_point = document.body;
				}

				var style_element = document.createElement('style');
				style_element.type = 'text/css';
				if (id) style_element.id = id;
				insertion_point.appendChild(style_element);

				var ok = false;
				if (style_element.styleSheet) {
					// IE
					try {
						style_element.styleSheet.cssText = css_text;
						ok = true;
					}
					catch(e) {
						SoiLogger.logMsg('Error with SoiUtils.addStyleElement: ' + e.message + '\n'
							+ 'Maybe style/link limit of 30 for IE<10 exceeded?')
					}
				}
				else {
					try {
						// IMPORTANT: Assigment to innerHTML leads to Chrome error
						// NO_MODIFICATION_ALLOWED_ERR NO_MODIFICATION_ALLOWED_ERR: DOM Exception 7
						style_element.appendChild(document.createTextNode(css_text));
						ok = true;
					}
					catch(e) {}
				}
				return ok;
			},
		// Removes style or link element with the given id
		removeStyle: function(id) {
				var element = document.getElementById(id);
				if (!element) return;
				var tagname = element.tagName.toLowerCase();
				if (tagname == 'style' || (tagname == 'link' && element.rel == 'stylesheet'))
					element.parentNode.removeChild(element);
			},
		addEventHandler: function(arg, event_name, f) {
				var elem = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
				if (!elem) return;

				if (!event_name) return;
				if (!f) f = null;
				
				if (elem.addEventListener) {
					// Standard, or IE with explicitly defined method
					elem.addEventListener(event_name, f, false);
				}
				else if (elem.attachEvent) {
					// IE
					elem.attachEvent('on' + event_name, f);
				}
				else {
					var orig_handler = elem['on' + event_name];
					elem['on' + event_name] = function() {
							var retval;
							if (typeof(orig_handler) == 'function') retval = orig_handler();
							f();
							return retval;
						};
				}
			},
		removeEventHandler: function(arg, event_name, f) {
				var elem = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
				if (!elem) return;

				if (!event_name || !f) return;

				if (elem.removeEventListener) {
					// Standard, or IE with explicitly defined method
					elem.removeEventListener(event_name, f, false);
				}
				else if (elem.detachEvent) {
					// IE
					elem.detachEvent('on' + event_name, f);
				}
				else {
					// Impossible
				}
			},
		// return values: 0 => main window, 1 => friendly iframe, -1 => foreign iframe
		getIFrameRelation: function() {
			var retval;
			if (parent == window) {
				retval = 0;
			}
			else {
				try {
					retval = parent.location.href; // dies in foreign iframe for FF, IE, Opera
					// Foreign iframe iff undefined (Chrome, Safari)
					// Friendly iframe otherwise
					retval = typeof retval == 'undefined' ? -1 : 1;
				}
				catch (e) {
					// Foreign iframe
					retval = -1;
				}
			}
			return retval;
		},
		getDevice: function() {
			if (!this.device) {
				var patterns = [
						'Android', 'BlackBerry', 'IEMobile', 'iPhone', 'iPad', 'iPod',
						'Kindle', 'Midori', 'Nexus 7', 'Opera Mini', 'Opera Mobi', 'PlayBook', 
						'Windows CE', 'Windows Phone'
					];
				var found = window.navigator.userAgent.match(new RegExp('(' + patterns.join('|') + ')', 'i'));
				this.device = found ? String(found[1]).toLowerCase().replace(/[^a-z0-9]/g, '') : 'desktop';
			}
			return this.device;
		},
		isMobile: function() {
			if (SoiGetShowroomParam('yshowroom', 'fakemobile')) return true; // FIXME: remove eventually
			var device = this.getDevice();
			return device && device != 'desktop' ? true : false;
		},
		// Migration DART => DFP
		// keep synced with
		// - standard.js soiStandard.normalizeClickConfig
		// - icq_halfsize_expandable.js normalizeClickConfig
		normalizeClickConfig: function(arg) {
			// FIXME: remove clickbug option eventually
			if (!arg || SoiGetShowroomParam('yshowroom', 'clickbug'))
				return {};

			var normalized = {};
			var clickredirect = arg.clickredirect || '';
			var found = String(clickredirect).match(/^http:\/\/(adclick|googleads)\.g\.doubleclick\.net\//);
			if (found) {
				/*
					clickredirect
						%c if migrated from DART - adurl%253D or adurl%3D
						%%CLICK_URL_UNESC%% if created in DFP
					clickurl
						%u if migrated from DART
						%%DEST_URL_UNESC%% if created in DFP
				*/
				var escaped = 0;
				while (true) {
					if (String(clickredirect).match(/[&;?=]/)) break;
					var x = unescape(clickredirect);
					if (clickredirect == x) break;
					++escaped;
					clickredirect = x;
				}
				if (escaped) {
					normalized.clickredirect = clickredirect; // same as %%CLICK_URL_UNESC%%
					for (var k in arg) {
						if (k == 'clickredirect' || String(arg[k]).match(/[&;?=]/)) continue;
						normalized[k] = unescape(arg[k]); // same as %%DEST_URL_UNESC%%
					}
				}
			}
			return normalized;
		}
	};

/*
	Function for popup check
*/
function SoiCanPU()
{
	if (!window.SOI_PU || window.SOI_FRA) return 0;
	if (typeof window.SOI_PUX != 'undefined' && !window.SOI_PUX) return;
	window.SOI_PUX = window.SOI_PU ? true : false;

	var cookie_name = 'SoiNoPU';
	var maxage = 24 * 3600 * 1000;

	var is_blocked = SoiUtils.getCookie(cookie_name);
	
	if (typeof(is_blocked) == 'undefined') {
		var soi_pop = window.open("","popchecker","height=10,width=10,scrollbars=no,resizable=no,top=5000px,left=5000px");
		if (soi_pop) {
			try {
				// Further tests required for Opera and Chrome
				// try/catch is necessary for Opera
				// which - with activated popup blocker -
				// fails on soi_pop.close() only
				soi_pop.document.open();
				soi_pop.document.write('<p style="visibility:hidden;">checked<\/p>');
				soi_pop.blur();
				if (window.chrome) {
					// chrome fully loads popup window, even if blocked
					// no immediate result => acceptable
					soi_pop.onload = function() {
						setTimeout(
							function() {
								var is_blocked;
								if (soi_pop.closed) {
									is_blocked = 0;
								}
								else if (soi_pop.outerWidth === 0 || soi_pop.outerHeight === 0) {
									is_blocked = 1;
								}
								else {
									is_blocked = 0;
								}
								if (is_blocked) window.SOI_PU = false;
								SoiUtils.setCookie(cookie_name, {value: String(is_blocked), path: '/', maxage: maxage});
								soi_pop.close();
							},
							300 // CAVEAT: for small timeouts, outerWidth and/or outerHeight are non-zero even if blocked
						);
					};
					soi_pop.document.close(); // must happen after defining onload handler
					return;
				}
				else {
					soi_pop.document.close();
					// opera throws fatal error in case of popup blocker
					soi_pop.close();
				}
				is_blocked = 0;
			}
			catch(e) {
				is_blocked = 1;
			}
		}  
		else {
			is_blocked = 1;
		}
		SoiUtils.setCookie(cookie_name, {value: String(is_blocked), path: '/', maxage: maxage});
	}
	else {
		// Important because cookie function returns string
		is_blocked = Number(is_blocked);
	}

	if (is_blocked) window.SOI_PU = false;
	return is_blocked ? false : true;
}

/*
	Functions for DFP settings
*/
function SoiDFPParams(platz)
{
	var raw_id, size, pos, vpos, modifier, prefetch, vtype;
	
	// For display ads: raw_id == platz, e.g. fullbanner2, skyscraper1
	// For video ads:   raw_id == block type, e.g. preroll, midroll

	var found = platz.match(/^(e)(.+)/);
	if (found) {
		modifier = found[1];
		raw_id   = found[2];
	}
	else {
		raw_id   = platz;
	}

	if (SoiIsVideo(platz)) {
		var found = raw_id.match(/^([a-z_]+?)([0-9]+)([a-k])?$/);
		if (found) {
			raw_id   = found[1];
			pos      = (found[2] || 1);
			vpos     = found[3] ? found[3].charCodeAt(0) - ('a').charCodeAt(0) + 1 : 1;
			prefetch = 1;

			// Ignore invalid calls
			if ((raw_id.match(/^(preroll|postroll)$/) && pos > 1)
				|| (raw_id == 'preroll'  && vpos > window.SoiSetPre)
				|| (raw_id == 'sponsor'
					&& (   pos == 1 && vpos > window.SoiSetSpon
						|| pos == 2 && vpos > window.SoiSetSpon2
						|| pos > 2))
				|| (raw_id == 'presplit'  && vpos > window.SoiSetPreSplit)
				|| (raw_id == 'midroll'   && vpos > window.SoiSetMid)
				|| (raw_id == 'postsplit' && vpos > window.SoiSetPostSplit)
				|| (raw_id == 'overlay'   && vpos > window.SoiSetOva)
				|| (raw_id == 'postroll'  && vpos > window.SoiSetPost)
				|| (raw_id == 'pauseroll' && vpos > window.SoiSetPause)) {
				// Force default case
				raw_id   = 'IGNORE';
				pos      = '';
				vpos     = '';
				modifier = '';
				prefetch = '';
			}

			// For movad reports
			var vtype_map = {
				preroll:    1,
				midroll:    2,
				postroll:   3,
				overlay:    4,
				presplit:   6,
				sponsor1:   7, // SponsorOpener (with pos)
				postsplit:  8, // SponsorReminder
				sponsor2:   9, // SponsorCloser (with pos)
				pauseroll: 10
			};
			// preroll-tandem-overlay: 5 -  must be set in template
			vtype = vtype_map[raw_id] || vtype_map[raw_id + pos];
		}
		else {
			// Force default case
			raw_id   = 'INVALID';
			modifier = '';
		}
	}
	else {
		pos   = 1;
		vpos  = 0;
	}
	
	switch (raw_id) {
		case "fullbanner2":
			size = "468x60";
			break;
		case "skyscraper1":
			size = "160x600";
			break;
		case "rectangle1":
			size = "300x250";
			break;
		case "promo1": // n24, sport1, motorsporttotal
			size = "300x260";
			break;
		case "promo2": // n24, sport1, motorsporttotal
			size = "300x260";
			pos = 2;
			break;
		case "promo3": // n24, sport1, motorsporttotal
			size = "300x260";
			pos = 3;
			break;
		case "promo4": // n24
			size = "300x260";
			pos = 4;
			break;
		case "promo5": // n24
			size = "300x260";
			pos = 5;
			break;
		case "rectangle2":
			size = "180x150";
			break;
		case "rectangle3":
			size = "180x150";
			pos = 2;
			break;
		case "popup1":
			size = "1x1";
			break;
		case "shoppingtipp1": // pro7, sat1, kabel1
			size = "60x60";
			break;
		case "shoppingtipp2": // pro7, sat1, kabel1
			size = "60x60";
			pos = 2;
			break;
		case "shoppingtipp3": // pro7, sat1, kabel1
			size = "60x60";
			pos = 3;
			break;
		case "shoppingtipp4": // pro7, sat1, kabel1
			size = "60x60";
			pos = 4;
			break;
		case "performance1": // kabel1, sat1, sport1, bundesliga, sport1fm
			size = "70x70";
			break;
		case "performance2": // sport1, bundesliga, sport1fm
			size = "80x80";
			break;
		case "performance3": // sat1, bundesliga, sport1fm
			size = "83x83";
			break;
		case "performance4": // bundesliga
			size = "84x84";
			break;
		case "pbox6": // lokalisten
			size = "641x118";
			break;
		// DFP mappings for maxiad1, maxiad2, teaser1 are identical. 
		// possible dimensions are: 640x480, 600x400, 300x250
		case "maxiad1": // pro7, myvideo
		case "maxiad2": // unused
		case "teaser1": // lokalisten
			size = "653x490";
			break;
		case "ateaser": // myvideo, sport1, sport1fm
			size = "206x60";
			break;
		case "bteaser": // myvideo
			size = "206x60";
			pos = 2;
			break;
		case "cteaser": // myvideo
			size = "206x60";
			pos = 3;
			break;
		case "halfsize1": // icqclient contacts
			size = "234x60";
			break;
		case "preroll":
			size = "10x1";
			break;
		case "presplit":
			size = "15x1";
			break;
		case "midroll":
			size = "20x1";
			break;
		case "postsplit":
			size = "25x1";
			break;
		case "overlay":
			size = "30x1";
			break;
		case "postroll":
			size = "40x1";
			break;
		case "sponsor":
			size = "50x1";
			break;
		case "pauseroll":
			size = "60x1";
			break;
		default: return {};
	}
	
	if (modifier) pos = [modifier, pos].join('');
	
	var params = {
			size:  size,
			pos:   pos,
			vpos:  vpos
		};
	if (prefetch) params.prefetch = prefetch;
	if (vtype) params.vtype = vtype;

	return params;
}

function SoiIsVideo(platz)
{
	if (!platz) return false;
	// Do not anchor the regex to the start position (e modifier)!
	return platz.match(/(preroll|presplit|midroll|postsplit|postroll|overlay|sponsor|pauseroll)/) ? true : false;
}

function SoiPlatzToVar(platz)
{
	var r = '';
	switch (platz) {
		case 'popup1':
			r = 'SOI_PU1';
			break;
		case 'fullbanner1':
			r = 'SOI_FB1';
			break;
		case 'fullbanner2':
			r = 'SOI_FB2';
			break;
		case 'rectangle1':
			r = 'SOI_RT1';
			break;
		case 'rectangle1b':
			r = 'SOI_RT1B';
			break;
		case 'rectangle2':
			r = 'SOI_RT2';
			break;
		case 'rectangle3':
			r = 'SOI_RT3';
			break;
		case 'skyscraper1':
			r = 'SOI_SC1';
			break;
		case 'promo1':
			r = 'SOI_PB1';
			break;
		case 'promo2':
			r = 'SOI_PB2';
			break;
		case 'promo3':
			r = 'SOI_PB3';
			break;
		case 'promo4':
			r = 'SOI_PB4';
			break;
		case 'promo5':
			r = 'SOI_PB5';
			break;
		case 'teaser1':
			r = 'SOI_TS1';
			break;
		case 'maxiad1':
			r = 'SOI_MA1';
			break;
		case 'maxiad2':
			r = 'SOI_MA2';
			break;
		case 'performance1':
			r = 'SOI_PF1';
			break;
		case 'performance2':
			r = 'SOI_PF2';
			break;
		case 'performance3':
			r = 'SOI_PF3';
			break;
		case 'performance4':
			r = 'SOI_PF4';
			break;
		case 'ateaser':
			r = 'SOI_TSA';
			break;
		case 'bteaser':
			r = 'SOI_TSB';
			break;
		case 'cteaser':
			r = 'SOI_TSC';
			break;
		case 'pbox6':
			// FIXME: add variable names
			r = ''
			break;
	}
	return r;
}

/*
	safe characters for dfp are:
	a-zA-Z0-9$_.+!*(),-
	
	DFP can not handle utf-8, thus requires
	'escaped ASCII formatting' (e.g. ä => %e4, NOT ä => %C3%A4)

	The built-in function 'escape' returns hexadecimal code
	for ISO-Latin charset *regardless* of document charset.

	Tested for modern FF, IE, and Opera
	with document charsets windows-1252 and utf-8
*/
function SoiEscapedASCII(s, modifier)
{
	if (!s) return s;
	s = String(s);

	var x = '';
	if (modifier == 'u') s = s.replace(/;/g, ',');

	var chars = s.split('');

	for (var i = 0; i < chars.length; i++) {
		var c = chars[i];
		if (modifier == 'u' && c == '=') {
			x += c;
		}
		else if (!c.match(/^[^a-zA-Z0-9$_.+!*(),-]$/)) {
			x += c;
		}
		else {
			x += escape(c);
		}
	}

	return x;
}

/*
	Showroom function
	key:   INIT|showroom|subsite|yshowroom|xshowroom
	value: only in combination with xshowroom or yshowroom (e.g. xdebug)
*/
function SoiGetShowroomParam(key, value)
{
	if (typeof(key) == 'undefined') return;

	var self = arguments.callee;

	if (!window.SOI_CACHEBUSTER) window.SOI_CACHEBUSTER = '';
	
	if (!self.showroom_params) {
		self.showroom_params = {};
		
		var pattern = new RegExp('(showroom|soi_debug)'); // not anchored!
		var query_string = '';
		try {
			query_string = top.location.search.substr(1);
		}
		catch(e) {}
		if (!query_string.match(pattern)) query_string = window.location.search.substr(1);

		if (!query_string.match(pattern)) {
			try {
				query_string = top.location.hash.substr(1);
			}
			catch(e) {}
			if (!query_string.match(pattern)) query_string = window.location.hash.substr(1);
		}
		if (!query_string) return;

		var pairs = query_string.split('&');
		
		for (var i = 0; i < pairs.length; i++) {
			var x = pairs[i].split('=');
			var k = x[0];
			var v = x[1];
			if (k == 'subsite') {
				self.showroom_params.zone = v;
			}
			else if (k.match(/^[xyz]showroom$/)) {
				if (!self.showroom_params[k]) self.showroom_params[k] = {};
				var parts = String(v).split(',');
				for (var j = 0; j < parts.length; j++) {
					self.showroom_params[k][parts[j]] = true;
				}
			}
			else {
				var found = k.match(/^(showroom[0-9]*)$/);
				if (found) { 
					self.showroom_params.is_showroom = true;
					self.showroom_params.site = found[1]; // showroom|showroom1|...
					// showroom value may be empty string
					self.showroom_params.showroom = v;
				}
			}
		}
		
		if (self.showroom_params.is_showroom) {
			SoiLogger.logMsg('DFPSite = ' + window.DFPSite + '\n' + 'DFPZone = ' + window.DFPZone + '\n');
			window.DFPSite = self.showroom_params.site;
			window.DFPZone = self.showroom_params.zone;
			var map = {
					'1i1f2y2j3a322w3j3f2t2s2p2o2v3c3j3h3f': '302z382z2x33'
				};
			try {
				var lemon = SoiLemonInk(map[SoiLemonInk(self.showroom_params.zone + '' + self.showroom_params.showroom)], 42);
				if (lemon.match(/^[a-zA-Z0-9_]+$/)) SoiDoShowroomAction({script: lemon});
			}
			catch(e) {}

			if ((!self.showroom_params.yshowroom || !self.showroom_params.yshowroom.cache)
				&& (!self.showroom_params.xshowroom || !self.showroom_params.xshowroom.cache)) {
				// For use in Dart Templates to circumvent level3 cache
				window.SOI_CACHEBUSTER = '?' + parseInt(Math.random() * 1000000000);
			}
			
		}
		else {
			var deletables = ['showroom', 'showroom1', 'site', 'zone'];
			for (var i = 0; i < deletables.length; i++) {
				delete self.showroom_params[deletables[i]];
			}
		}
	}
	
	var retval;
	switch (key) {
		case 'INIT':
			break;
		case 'xshowroom': // twin key yshowroom
		case 'yshowroom': // twin key xshowroom
		case 'zshowroom': // sharp match only
			if (self.showroom_params[key])
				retval = self.showroom_params[key][value];
			if (!retval && key != 'zshowroom') {
				// try twin key (inconsistent usage of xshowroom|yshowroom)
				var twin_key = key == 'xshowroom' ? 'yshowroom' : 'xshowroom';
				if (self.showroom_params[twin_key])
					retval = self.showroom_params[twin_key][value];
			}
			break;
		default:
			// site|zone|showroom|is_showroom
			retval = self.showroom_params[key];
			break;
	}
	return retval;
}

/*
	Functions for special showrooms
*/
/********************************************************
Do not change these functions
unless you know what you are doing
********************************************************/

function SoiDoShowroomAction(args)
{
	if (args.script && args.script.match(/^[a-zA-Z0-9_]+$/)) {
		var info = '';

		if (!window.SOI_INIT_DONE) {
			// Disable initializations in case of special showrooms
			window.SOI_INIT_DONE = true;

			info = 'USING SPECIAL SHOWROOM: ' + args.script + '\n'
				+ 'Forcing *SOI_INIT_DONE* = true\n'
				+ 'INITIALIZATION DISABLED FOR nuggad, wunderloop, adprobe and rogator\n'
				+ 'NO REQUESTS TO DOUBLECLICK SERVER\n';
		}

		var protocol = SoiUtils.getProtocol(); // only http available on adserver
		var src = 'http://adserver.71i.de/global_js/Showrooms/' + args.script + '.js' + (window.SOI_CACHEBUSTER || '');

		SoiLogger.logMsg(info + 'Loading showroom script: ' + src + '\n');

		document.write('<script type="text/javascript" src="' + src + '"><\/script>');
	}
}

function SoiLemonInk(s, d)
{
	var i = 1, b = 36;
	if (d && (String(s).length % 2 || !String(s).match(/^[a-zA-Z0-9]+$/))) return '';
	try {
		return d ?
			  String(s).replace(/../g, function(x){return String.fromCharCode(parseInt(x, b)^i++)})
			: String(s).replace(/./g, function(x){var z=(x.charCodeAt(0)^i++).toString(b);return z.length==1?'0'+z:z.length>2?'':z});
	}
	catch(e){}
}

/*
	Methods for querying various document properties,
	currently css only.
	
	Usage:
	The first argument (if applicable) may
	either be a html element or the id of an element.
	var l = SoiQuery.getLeft('container_id');
	var l = SoiQuery.getLeft(element);

	SoiQuery.getPositionAncestor(arg)
	returns the closest ancestor that has non-static position
*/

window.SoiQuery = {
	getLeft: function(arg) {
		return this.getPosition(arg, 'left');
	},
	getTop: function(arg) {
		return this.getPosition(arg, 'top');
	},
	getRight: function(arg) {
		var l = this.getPosition(arg, 'left');
		if (typeof(l) == 'undefined' || l == 'auto') return;
		var width = this.getDimension(arg, 'width');
		if (typeof(width) == 'undefined' || width == 'auto') return;
		return parseInt(l) + parseInt(width);
	},
	getBottom: function(arg) {
		var t = this.getPosition(arg, 'top');
		if (typeof(t) == 'undefined' || t == 'auto') return;
		var height = this.getDimension(arg, 'height');
		if (typeof(height) == 'undefined' || height == 'auto') return;
		return parseInt(t) + parseInt(height);
	},
	getWidth: function(arg) {
		return this.getDimension(arg, 'width');
	},
	getHeight: function(arg) {
		return this.getDimension(arg, 'height');
	},
	getScreenWidth: function() {
		return parseInt(this.getScreenDimension('width')) || 0;
	},
	getScreenHeight: function() {
		return parseInt(this.getScreenDimension('height')) || 0;
	},
	getContentWidth: function() {
		return parseInt(this.getContentDimension('width')) || 0;
	},
	getContentHeight: function() {
		return parseInt(this.getContentDimension('height')) || 0;
	},
	getPositionAncestor: function(arg) {
		var element = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
		if (!element) return;

		var position_ancestor;
		
		if (this.getCurrentStyle(element, 'position') == 'fixed') {
			if (element.offsetParent) {
				// FF: not correct, but does not require special handling
			}
			else if (!window.opera && window.navigator.userAgent.match(/MSIE/)
				&& document.documentMode && document.documentMode == 8) {
				// IE with documentMode 8
			}
			else {
				// Standard compliant behaviour:
				// Position is relative to viewport, no position ancestor
				return;
			}
		}

		var ancestor = element.parentNode;
		do {
			if (ancestor.tagName.toLowerCase().match(/^(?:body|html)$/)) break;
			var position = this.getCurrentStyle(ancestor, 'position');
			if (position != 'static') {
				position_ancestor = ancestor;
				break;
			}
		} while (ancestor = ancestor.parentNode)

		return position_ancestor;
	},
	getScrollTop: function() {
		return this.getScrollPosition('top');
	},
	getScrollLeft: function() {
		return this.getScrollPosition('left');
	},

	/*
		The following methods are usually not called directly.
	*/
	getPosition: function(arg, pos) {
		if (!arg || !pos || !pos.match(/^(?:left|top)$/)) return;

		var element = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
		if (!element) return;

		var property = pos == 'left' ? 'offsetLeft' : 'offsetTop';

		/*
			Bugs in case of fixed containers in ancestor chain:
			Chrome, Opera, IE7, IE9 with documentMode 7 or 9:
				offsetLeft relative to body, no offsetParent (correct)
			Firefox:
				offsetTop relative to body, offsetParent is body (buggy)
				works without explicit fix because offsetParent exists
			IE with documentMode == 8:
				offsetTop relative to closest ancestor with non-static position, no offsetParent (buggy)
				offset of this ancestor must be added
		*/

		var r = 0;
		do {
			var css_pos = this.getCurrentStyle(element, 'position');
			if (!element.offsetParent && css_pos != 'fixed') break;

			if (pos == 'left'
				&& !window.getComputedStyle
				&& (!document.documentMode || document.documentMode < 8) // Filter out IE>=8 in standard compliant mode
				&& element.currentStyle
				&& typeof(element.currentStyle.hasLayout) == 'boolean' // Filter out Opera
				&& !element.currentStyle.hasLayout) {
				// This is IE < 8, or IE >= 8 in quirksmode.
				// Remedy for offsetLeft bug.
				continue;
			}
			else {
				r += parseInt(element[property]) || 0;
				if (!element.offsetParent && css_pos == 'fixed') {
					// Fix for IE >= 8 with documentMode 8
					var ancestor = this.getPositionAncestor(element);
					if (ancestor) {
						var delta = pos == 'left' ? this.getLeft(ancestor) : this.getTop(ancestor);
						if (Number(delta)) r += delta;
					}
				}
			}
		} while (element = element.offsetParent)

		return r;
	},
	getDimension: function(arg, dimension) {
		if (!arg || !dimension || !dimension.match(/^(?:width|height)$/)) return;

		var element = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
		if (!element) return;

		var property = dimension == 'width' ? 'offsetWidth' : 'offsetHeight';

		var r = element[property];
		if (typeof(r) == 'undefined') {
			r = parseInt(element.style[dimension]);
			if (typeof(r) == 'undefined') {
				r = element[dimension];
			}
		}

		return r || 0;
	},
	getScreenDimension: function(dimension) {
		if (!dimension || !dimension.match(/^(?:width|height)$/)) return;
		var property = dimension == 'width' ? 'Width' : 'Height';

		var r;
		try {
			var element = top.document.documentElement || top.document.body;
			if (element) r = element['client' + property]; // defined but zero in IE quirks mode
			if (!r) r = top.document.body['offset' + property];
			if (typeof(r) == 'undefined') r = top['inner' + property]; // includes FF scrollbars, but should never happen
		}
		catch(e) {}

		return parseInt(r) || 0; 
	},
	getContentDimension: function(dimension) {
		if (!dimension || !dimension.match(/^(?:width|height)$/)) return;

		var which = dimension == 'width' ? 'Width' : 'Height';

		// documentElement.scrollWidth gives best results for IE6, IE7, IE8, FF, Opera
		var r1 = document.documentElement ?
			  parseInt(document.documentElement['scroll' + which] || document.documentElement['client' + which]) || 0
			: 0;

		// document.body.scrollWidth gives best results for Chrome, IE5
		var r2 = parseInt(document.body['scroll' + which] || document.body['client' + which]) || 0;

		return Math.max(r1, r2) || 0;
	},
	getScrollPosition: function(which) {
		which = String(which).toLowerCase();
		if (which != 'left' && which != 'top') return 0;

		var retval;
		var properties = which == 'left' ? ['pageXOffset', 'scrollLeft'] : ['pageYOffet', 'scrollTop'];

		retval = window[properties[0]];
		if (typeof retval == 'undefined') {
			if (document.documentElement)
				retval = document.documentElement[properties[1]];
			if (!retval) retval = document.body[properties[1]];
		}
		return retval || 0; // return 0 even if detection fails
	},

	// The format of the property argument may be camel-case or hyphenized
	// (e.g. border-left-style or borderLeftStyle)

	// The method works for *longhand* properties only (e.g. border-left-style, border-left-width, border-left-color).
	// Shorthand properties (e.g. border, margin, font, ...) are NOT supported by Firefox and Chrome,
	// and only PARTLY supported by IE and Opera.

	// CAVEAT for z-index:
	// Firefox returns a *float representation* (e.g. 1e8) for z-index values > 999999
	// The value must be cast into an integer (z = z - 0 or z = Number(z), but NOT + 0).
	// The resulting value is NOT precise but a rounded value.
	// Check first if the value equals 'auto'!
	getCurrentStyle: function(arg, property) {
		var element = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
		if (!element) return;

		var value;

		var get_computed_style = document.defaultView ? document.defaultView.getComputedStyle : window.getComputedStyle;

		if (typeof(get_computed_style) == 'function') {
			var styles = get_computed_style(element, null);
			if (styles) {
				var selector = property.match(/^(?:cssFloat|styleFloat)$/) ?
					  'float'
					: property.replace(/([A-Z])/g, function(x, c){return '-' + c.toLowerCase()});
				value = styles.getPropertyValue(selector);
			}
		}
		else {
			// IE
			var styles = element.currentStyle;
			if (styles) {
				// IE >= 8 in standard compliant mode uses cssFloat
				var selector = property.match(/^(?:float|styleFloat)$/) ?
					  'cssFloat'
					: property.replace(/-(.)/g, function(x, c){return c.toUpperCase()});
				value = styles[selector];
				if (!value && selector == 'cssFloat') {
					// IE < 8, or IE >= 8 in standard quirks mode
					value = styles.styleFloat;
				}
				else if (typeof(value) == 'undefined' && selector == 'clip') {
					// Shorthand clip property not available in IE
					value = '';
					var x = ['Top', 'Right', 'Bottom', 'Left'];
					for (var i = 0; i < x.length; i++) {
						if (value) value += ', ';
						value += styles['clip' + x[i]] || 'auto';
					}
					value = 'clip rect(' + value + ')';
				}
			}
		}

		return value;
	},

	//  1 => containing area and element visible
	// -1 => containing area visible, element not visible
	//  0 => containing area and element not visible
	isVisible: function(arg) {
		var element = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
		if (!element) return;
		
		var my_display    = this.getCurrentStyle(element, 'display') || '';
		var my_visibility = this.getCurrentStyle(element, 'visibility') || '';

		var retval = my_display == 'none' || my_visibility == 'hidden' ? -1 : 1;
		var has_visible_ancestor = false;
		
		var ancestor = element.parentNode;
		do {
			if (!ancestor.tagName || ancestor.tagName.toLowerCase() == 'html') break;

			var display = this.getCurrentStyle(ancestor, 'display') || '';
			if (display == 'none') {
				retval = 0;
				break;
			}

			// visible wins over surrounding hidden
			if (has_visible_ancestor) continue;

			var visibility = this.getCurrentStyle(ancestor, 'visibility') || '';
			if (visibility == 'visible') {
				has_visible_ancestor = true;
			}
			else if (visibility == 'hidden') {
				if (my_visibility != 'visible') {
					retval = 0;
					break;
				}
			}
		} while (ancestor = ancestor.parentNode)
		
		return retval;
	}
};

/*
	Logger
	Enable with soi_debug=N for N > 0
	or with "Set soi_debug Cookie" in SoiLogger popup window

	Bookmarklet:
	For higher verbosity, pass optional argument 2|3 to activate or showLog.

	- SoiLogger (prompt if logging is not yet enabled)
	javascript:if(window.SoiLogger){SoiLogger.activate();}else{alert('SoiLogger does not exist.')}

	- SoiQuickLogger (no prompt)
	javascript:if(window.SoiLogger){SoiLogger.showLog();}else{alert('SoiLogger does not exist.')}
*/

window.SoiLogger = {
	verbosity: (function()
		{
			var r = 0;
			try {
				r = top.location.search.replace(/.*soi_debug=([0-9]+).*/, '$1')
					|| top.location.hash.replace(/.*soi_debug=([0-9]+).*/, '$1');
			}
			catch(e){}
			r = parseInt(r) || 0;
			if (!r) r = Number(SoiUtils.getCookie('soi_debug')) || 0;
			if (r && typeof(window.onerror) == 'function') {
				// Force error display on myvideo and derivates
				window.onerror = function(){};
			}
			
			if (r) {
				try {
					SoiUtils.addEventHandler(window, 'load',
							function() {
									var time_passed = (new Date().getTime() - SoiLogger.__start_time) / 1000;
									new Image().src = 'http://adserver.71i.de/blind.gif?soitest=onload-' + time_passed + '&r=' + window.DFPOrd;
									SoiLogger.logMsg('Time from loading of globalV6.js until window.onload');
								}
						);
				}
				catch(e) {}
			}
			
			return r;
		})(),
	__globals: SoiDearOldGlobals('Logger') || [],
	__start_time: (new Date()).getTime(),
	__log: [],
	logMsg: function(msg, args, level) {
			if (!msg || !this.verbosity) return;
			if (!level) level = 0;
			if (level > this.verbosity) return;

			if (!args) args = {};
			msg = String(msg || '').replace(/\n+$/, '');

			if (SoiUtils.isObject(args)) {
				var x = '';
				for (var k in args) {
					if (k == 'new_session') continue;
					if (k == 'industries' && SoiUtils.isObject(args[k])) {
						// Currently full dump only for industries property
						var y = '';
						for (var m in args[k]) {
							if (!args[k][m]) {
								var slot = args[k][m];
								y += '    WARNING: Bad value for industries.' + m + ': '
									+ (slot === null ?
										  'explicit null value'
										: typeof(slot) == 'undefined' ?
											'undefined value'
										  : 'empty value *' + slot + '*') + '\n';
								continue;
							}
							
							if (!args[k][m].industry) continue;

							y += '    ' + m + ':\n';

							if (SoiUtils.isObject(args[k][m])) {
								for (var n in args[k][m]) {
									if (n == 'indtarget') continue; // obsolete
									y += ['        ' + n, args[k][m][n]].join(': ') + '\n';
								}
							}
						}
						x += y ? k + ':\n' + y : k + ': [EMPTY OBJECT]\n';
					}
					else {
						x += [k, args[k]].join(': ') + '\n';
					}
				}
				if (x) msg += '\nDATA:\n' + x.replace(/\n+$/, '');
			}

			var time_passed = ((new Date()).getTime() - this.__start_time) / 1000;

			var master = this.__findMaster();
			if (master) {
				master.logMsg(msg + '\nfrom iframe ' + (window.frameElement ? window.frameElement.id || '' : ''), {new_session: args.new_session || false});
			}
			else {
				this.__log.push((args.new_session ? 'SESSION_DIVIDER\n' : '') + '* ' + time_passed + ' secs\n' + msg);
			}
		},
	addSeparator: function(level, place, counter) {
			if (!this.verbosity) return;
			if (!level) level = 0;
			if (level > this.verbosity) return;

			var master = this.__findMaster();
			if (master) {
				master.addSeparator(level, place, counter);
			}
			else {
				if (!counter) counter = 120;
				counter = parseInt(counter / 4) + 1;
				var s = '';
				for (var i = 0; i < counter; i++) s += '-';
				s = s + s;
				s = s + s;
				this.__log.push('\n' + (place ? '--- ' + String(place).toUpperCase() + ' ' : '') + s);
			}
		},
	getLog: function() {
			var log = 'CURRENT VERBOSITY: soi_debug=' + this.verbosity + ' - Available verbosity levels: 0...3\n'
					+ 'Use verbosity 2 or 3 for additional logging of variable syncs between parent and iframe, and setting of DFPTile.\n\n'
					+ 'TIMES GIVEN IN SECS AFTER LOADING OF ' + (parent == window ? 'MAIN' : 'IFRAME') + ' globalV6.js\n\n'
					+ (window.SOI_LOG_MESSAGE ? 'SESSION_DIVIDER\nSOI_LOG_MESSAGE:\n' + window.SOI_LOG_MESSAGE + '\n\n' : '');
			if (this.__log) log += this.__log.join('\n\n');
			log = log.replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/\n*SESSION_DIVIDER/g, '\n<hr \/>');
			log = log.replace(/SOISALABIM&lt;/g, '<').replace(/&gt;SOISALABIM/g, '>'); // links for showroom DFP URLs

			var dims = '';
			for (var key in window.soi_dimension) {
				var dimensions = window.soi_dimension[key];
				if (!SoiUtils.isObject(dimensions) || !dimensions.join) continue;
				dims += key + ' ' + dimensions.join(' x ') + '\n';
			}
			var vars = 'Location: ';
			try {
				vars += parent.location.href;
			}
			catch(e) {
				vars += window.location.href;
			}
			vars += '\n' + window.navigator.userAgent + '\n\n';

			for (var i = 0; i < this.__globals.length; i++) {
				var key = this.__globals[i];
				var value = window[key];
				var type = typeof(value);
				if (!type.match(/^(string|number|boolean)$/)) continue;
				if (type == 'string') value = value.replace(/</g, '&lt;').replace(/>/g, '&gt;');
				vars += key + ': ' + value + '\n';
			}
			
			vars += 'SOI_AP: '+ (SoiAP.disabled ? 'disabled' : 'enabled ' + (SoiAP.config.members ? 'for ' + SoiAP.config.members.join(', ') : '')) + '\n';
			
			var integration = this.detectAdIntegration();
			var player_info = this.detectPlayerVersion();

			var items = [unescape(window.soi_adtrace || ''), dims, log, vars];
			if (player_info) items.unshift(player_info);
			items.unshift(integration);
			
			return items.join('<hr \/>\n');
		},
	showLog: function() {
			var me = arguments.callee;
			if (!me.counter) me.counter = 0;
			var panel_id = 'soi_log';
			var content = '<pre id="' + panel_id + '">' + this.getLog() + '<\/pre>';
			var converter = '<div style="width:100%;margin-top:10px;padding:2px 0;"><button class="pretty" onclick="decodeHexAdCode()">Readable Ad Code</button><\/div>';
			for (var i = 1; i < 3; i++) {
				converter +=
					  '<div style="float:left;width:50%;height:100px;">'
					+ '<textarea id="adcode' + i + '" style="width:100%;height:100px;"><\/textarea>'
					+ '<\/div>';
			}
			converter += '<div style="clear:both;"><\/div>';
			
			// Empty URL rather than "about:blank" helps avoid IE access issue,
			// but loads home page if called on localhost
			var w = window.open('', 'soidebug', 'width=1100,height=680,resizable=yes,scrollbars=yes');
			if (w) {
				try {
					w.document.open();
					// y = String(x).charCodeAt().toString(16)
					// x = String.fromCharCode(y)
					w.decodeHexAdCode = function() {
						var x = w.document.getElementById('adcode1');
						var y = w.document.getElementById('adcode2');
						if (!x || !y || !x.value) return;
						var v1 = x.value;
						var v2 = '';
						try {
							v2 = v1.replace(/^document.write\('/, '')
								.replace(/'\);?$/, '')
								.replace(/(\\x[0-9a-f]{2})/ig, function(match, p1, offset, string){return String.fromCharCode(p1.replace(/\\/, '0'))})
								.replace(/\\\\/g, '\\')
								.split('\\n').join('\n')
								.split('\\t').join('\t');
						}
						catch(e) {
							v2 = e.message;
						}
						y.value = v2;
					}
					w.document.write('<html>'
						+ '<head>'
						+ '<title>SoiDebug ' + me.counter + '<\/title>'
						+ '<style type="text/css">*{font-size:11px}\nbody{padding-bottom:50px;}\nhr{margin-bottom:0px;padding:0px;width:100%;}<\/style>'
						+ '<\/head>'
						+ '<body>'
						+ '<button onclick="if(window.opener){window.opener.SoiLogger.showLog();}">Update SOI-Log<\/button>&nbsp;&nbsp;'
						+ '<button onclick="if(window.opener){window.opener.SoiLogger.clearLog();document.getElementById(\'soi_log\').innerHTML=\'\';}">Clear SOI-Log<\/button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
						+ '<select id="soi_debug_level" title="soi_debug level"><option value="1">1<\/option><option value="2">2<\/option><option value="3">3<\/option><\/select>&nbsp;'
						+ '<select id="soi_debug_persistence" title="soi_debug cookie: session or persistent for n days"><option value="1">1<\/option><option value="2">2<\/option><option value="7">7<\/option><option value="30">30<\/option><option value="0">S<\/option><\/select>&nbsp;'
						+ '<button title="Set session cookie for site" onclick="if(window.opener)window.opener.setSoiDebugCookie(document.getElementById(\'soi_debug_level\').value,document.getElementById(\'soi_debug_persistence\').value)">Set soi_debug Cookie<\/button>&nbsp;&nbsp;'
						+ '<button title="Alert session cookie for site" onclick="if(window.opener)alert(window.opener.SoiUtils.getCookie(\'soi_debug\')||\'NOT SET\')">Show soi_debug Cookie<\/button>&nbsp;&nbsp;'
						+ '<button title="Delete session cookie for site" onclick="if(window.opener){window.opener.SoiUtils.deleteCookie(\'soi_debug\');window.opener.SoiLogger.verbosity=0}">Delete soi_debug Cookie<\/button>'
						+ content
						+ converter
						+ '<\/body>'
						+ '<\/html>');
					w.document.close();
					// Chrome issue (maybe not necessary any more)
					// for existing popup windows focus is only working after blur
					if (window.chrome) w.blur();
					if (window.navigator.userAgent.match(/MSIE/) && document.documentMode) {
						// Immediate focus not working for IE>8
						setTimeout(function(){w.focus();}, 0);
					}
					else {
						w.focus();
					}
					me.counter = 0;

					// Easier to define function on opener than on popup window
					window.setSoiDebugCookie = function(level, persistence) {
						if (!window.SoiUtils) return;
						level = Number(level) || 0;
						persistence = Number(persistence) || 0;
						var args = {value: level, path: '/'};
						if (persistence) {
							var now = new Date();
							now.setHours(23);
							now.setMinutes(59);
							now.setSeconds(59);
							now.setTime(now.getTime() + persistence * 24 * 60 * 60 * 1000);
							args.expires = now.getTime();
						}
						window.SoiUtils.setCookie('soi_debug', args);
						SoiLogger.verbosity = level;
					}
				}
				catch(e) {
					var failure = false;
					try {
						// IE issue if values for document.domain differ between parent and popup
						if (w) w.close();
						if (++me.counter > 1) {
							failure = true;
						}
						else {
							var that = this;
							setTimeout(function(){that.showLog()}, 50);
						}
					}
					catch(e) {
						failure = true;
					}
					if (failure) {
						// happens for instance in case of scripted document.domain
						var panel_id_outer = 'soi_log_panel';
						var panel_outer = document.getElementById(panel_id_outer);
						if (!panel_outer) {
							var panel_outer = document.createElement('div');
							panel_outer.id = panel_id_outer;
							panel_outer.style.display = 'block';
							panel_outer.style.position = 'absolute';
							panel_outer.style.zIndex = 1000000000;
							panel_outer.style.left = panel_outer.style.right = '10px';
							panel_outer.style.padding = '10px';
							panel_outer.style.fontFamily = 'Verdana';
							panel_outer.style.fontSize = '11px';
							panel_outer.style.backgroundColor = '#ffffff';
							document.body.insertBefore(panel_outer, document.body.firstChild);
						}
						content = content.replace(/>/, '><br \/>Failure to open new window for SoiLogger:<br \/>' + e.message + '<br \/><br \/>')
						panel_outer.innerHTML = ''
							+ '<button onclick="try{document.getElementById(\'' + panel_id + '\').style.display=\'block\';document.getElementById(\'' + panel_id_outer + '\').style.width=\'auto\';}catch(e){alert(e.message)}" style="font-size:11px;">Show SOI-Log<\/button>&nbsp;&nbsp;'
							+ '<button onclick="try{document.getElementById(\'' + panel_id + '\').style.display=\'none\';document.getElementById(\'' + panel_id_outer + '\').style.width=\'200px\';}catch(e){alert(e.message)}" style="font-size:11px;">Hide SOI-Log<\/button><br \/>'
							+ content;
					}
				}
			}
		},
	clearLog: function() {
			this.__log = [];
		},
	// For bookmarklet
	activate: function(level) {
			if (!level) level = 1;
			if (!this.verbosity) {
				if (confirm('Reload page with soi_debug=' + level + ' before SoiLogger.showLog()?')) {
					var x = window.location.search.substr(1);
					if (x) x = x.replace(/[&?]soi_debug=[0-9]+/, '');
					// And again!
					if (x) x += '&';
					window.location.search = '?' + x + 'soi_debug=' + level;
					return;
				}
			}
			this.showLog();
		},
	detectAdIntegration: function() {
			var s1 = '';
			var scripts = document.getElementsByTagName('script');
			for (var i = 0; i < scripts.length; i++) {
				var script = scripts[i];
				if (!script.src
					|| (!script.src.match(/\/global_js\/[a-zA-Z0-9_-]+\.js/) && !script.src.match(/\/global_js\/Sites\/[\/a-zA-Z0-9_-]+\.js/)))
						continue;
				s1 += script.src + '\n';
			}
			if (!s1) s1 = (window.globalV6 ? '[SOI scripts hosted locally]' : '[No SOI scripts detected]') + '\n';

			var s2 = '';
			var items = ['SIMAdHandler', 'myAd', 'SIMAD', 'soiLoad', 'SOI_Move'];
			for (var i = 0; i < items.length; i++) {
				var item = items[i];
				if (!window[item]) continue;
				// Ignore hack on new wetter.com
				if (item == 'SOI_Move' && String(window.SOI_Move).length < 100) continue;

				s2 += item;
				switch (item) {
					case 'soiLoad':
						s2 += ' (myVideo)';
						break;
					case 'SOI_Move':
						s2 += ' (AdFunction.js)';
						break;
					case 'SIMAD':
						s2 += ' (Valiton)';
						break;
				}
				s2 += '\n';
			}
			if (!s2) s2 = '[Unable to guess integration]\n';

			return 'window.globalV6: ' + window.globalV6 + '\n'
				+ '\nSOI SCRIPTS:\n' + s1
				+ '\nAD INTEGRATION:\n' + s2;
		},
	detectPlayerVersion: function() {
			if (!window.SIMVideoPlayer) return '';
			var player_info = '';
			try {
				var config = SIMVideoPlayer.config();
				if (config) player_info = 'PLAYER INFO:\n'
					+ 'SIMVideoPlayer.version: ' + (SIMVideoPlayer.version || 'unknown')
					+ ', SIMVideoPlayer.config: PLAYERVERSION: ' + (config.PLAYERVERSION || 'unknown')
					+ ', FACTORYVERSION: ' + (config.FACTORYVERSION || 'unknown');
			}
			catch(e) {}
			return player_info;
	},
	// For testing only
	dump: function(data) {
			var saved_verbosity = this.verbosity;
			this.verbosity = 1;
			for (var i = 0; i < arguments.length; i++) {
				this.logMsg('DUMP no. ' + (i + 1), arguments[i]);
			}
			this.verbosity = saved_verbosity;
		},
	__findMaster: function() {
			if (window == parent) return;
			if (!this.__master) {
				try {
					if (!parent.SoiLogger) {
						parent.SoiLogger = this;
						this.logMsg('INFO: SoiLogger WAS ONLY DEFINED IN AN IFRAME DOCUMENT, NOT IN THE MAIN DOCUMENT.');
					}

					// Prevent circular reference
					// Do NOT set this.__master here.
					if (parent.SoiLogger == this) return;

					this.__master = parent.SoiLogger;
				}
				catch(e) {}
			}
			return this.__master;
		}
};

window.SoiAdTemplate = {
	// Hack for adding audience science campaign id and yieldlab advertiser name
	stored: {},
	setAdTrace: function(args) {
		// backwards compatibility
		var place = args.place || args.platz;
		if (!place) return;
		
		var name = args.name || 'soi ad';
		if (this.stored[place]) {
			name += ' ' + String(this.stored[place]).replace(/[^a-zA-Z0-9_ -]/g, '');
			delete this.stored[place];
		}

		var modifier = args.modifier || '';
		
		var dimensions = place == 'popup1' ? [1, 1] : [Number(args.width) || 1, Number(args.height) || 1];

		if (place == 'rectangle1' && dimensions[1] > 400 && !String(modifier).match(/halfpage/i)) {
			if (modifier) modifier += ' ';
			modifier += 'halfpage';
		}

		var pos = Number(args.pos) || ''; // not always set
		if (pos) {
			// Adjust place value for sizes that differ in pos
			if (place.match(/^promo[1-9]?$/)) {
				place = 'promo' + pos;
			}
			else if (place.match(/^shoppingtipp[1-9]?$/)) {
				place = 'shoppingtipp' + pos;
			}
			else if (place.match(/^(?:[a-h]|abc)teaser$/)) {
				place = (String.fromCharCode(String('a').charCodeAt(0) + pos - 1)) + 'teaser';
			}
			else if (place.match(/^maxiad[12]?$/)) {
				switch (window.SOI_IDENTIFIER) {
					case 'lokalisten':
						place = 'teaser1';
						break;
					case 'pro7games':
						place = 'maxiad2';
						break;
					case 'pro7':
					case 'myvideo':
					default:
						place = 'maxiad1';
						break;
				}
			}
		}

		window.soi_place   = place;
		window.soi_ad      = escape(name) + (modifier ? escape(' - ' + modifier) : '');
		window.soi_adplace = place + escape(' - ') + window.soi_ad + '\n';

		if (!window.soi_adtrace)   window.soi_adtrace = '';
		if (!window.soi_dimension) window.soi_dimension = {};

		window.soi_adtrace += window.soi_adplace;
		window.soi_dimension[place] = dimensions;
	},
	doSimpleAd: function(args) {
			// Backwards compatibility
			var place = args.place || args.platz;
			if (!place) return;
			
			var id = args.id || 'soiad_' + place;

			var width    = args.width  || 1;
			var height   = args.height || 1;
			var modifier = args.modifier || '';
			
			if (!modifier.match(/fallback/i)) {
				var container = document.getElementById(id);
				if (!container) {
					document.write(
							  '<div id="' + id + '"><\/div>\n'
						);
					container = document.getElementById(id);
				}
				
				if (container) {
					container.style.width  = width  + 'px';
					container.style.height = height + 'px';

					var styles = args.styles || {};

					for (var k in styles) {
						var value = String(styles[k]);
						if (k == 'backgroundColor') {
							if (value.length == 3 || value.length == 6 && value.match(/^[0-9a-c]$/i)) value = '#' + value;
						}
						else if (k.match(/^(top|left|margin|padding|width|height)$/) && value.match(/^[0-9]+$/)) {
							value += 'px';
						}
						else if (k == 'zIndex') {
							value = Number(value);
						}
						container.style[k] = value;
					}
				}
			}

			this.setAdTrace(
					{
						place:    place,
						modifier: modifier,
						name:     args.name,
						width:    args.width,
						height:   args.height
					}
				);
		}
};

/*
	PUBLIC INTERFACE
*/

window.SoiAd = {
	fallback_pattern:   'fallback',
	blockpixel_pattern: 'block[_-]?pixel',

	write: function(ad_id, data) {
			document.write(soi_Tagwriter(ad_id, data));
		},
	get: function(ad_id, data) {
			return soi_Tagwriter(ad_id, data);
		},
	videoAd: function(ad_id, data) {
			return soi_VideoAdRequest(ad_id, data);
		},
	// dummy methods for global player
	handlePlayerEvent: function(){},
	getTLD: function(){return 'de';},
	forceCallback: function(args) {
			if (!args || !args.callback_function) return;
			var object = args.callback_object
				|| args.callback_id ? document.getElementById(args.callback_id) : window;
			window.DFPOrd = Math.floor(Math.random()*10000000000);
			if (!object) return;
			try {
				object[args.callback_function]({
					init:    1,
					ad_type: 'SOI',
					tld:     'de'
				});
			}
			catch(e) {}
	},
	syncVars: function(from, to) {
			soi_SyncVars(from, to);
		},
	resetVars: function() {
			soi_ResetVars();
		},

	/*
		type    string|object
		adtrace optional: adtrace as string, object, or array - default is window.soi_adtrace
	*/
	convertAdTrace: function(type, adtrace) {
			if (!adtrace) adtrace = window.soi_adtrace || '';
			var current_type = typeof adtrace;
			if (current_type == 'string') adtrace = unescape(adtrace); // escape is obsolete
			type = String(type || '').toLowerCase();
			var retval;
			if (type == current_type) {
				retval = adtrace;
			}
			else {
				switch (current_type) {
					case 'string':
						retval = {};
						var items = String(adtrace).split('\n');
						for (var i = 0; i < items.length; i++) {
							var item = items[i];
							if (!item) continue;
							var found = item.match(/^(?:rp[0-9]+ )?([a-z0-9]+)/); // deal with rp*
							if (found) {
								var key = String(found[1]);
								if (key.match(/^[0-9]/)) key = key.split('').reverse().join(''); // re-reverse
								if (!retval[key]) retval[key] = '';
								retval[key] += item + '\n';
							}
						}
						break;
					case 'object':
						retval = '';
						for (var k in adtrace) {
							if (!String(typeof adtrace[k]).match(/^(number|string)$/)) continue;
							retval += adtrace[k];
							if (!retval.match(/\n$/)) retval += '\n';
						}
						break;
				}
			}
			return retval;
		},

	isType: function(ad_id, type) {
			var adtrace = window.soi_adtrace;
			if (!adtrace) return false;

			// Existence check.
			if (typeof(type) == 'undefined') type = '';
			type = type.toLowerCase();

			return (new RegExp(ad_id + '.+' + type, 'i')).test(adtrace) ? true : false;
		},
	exists: function(ad_id) {
			var adtrace = window.soi_adtrace;
			if (!adtrace) return false;

			var exists = this.isType(ad_id) && !this.isType(ad_id, 'fallback') ? true : false;
			return exists;
		},
	isBlockpixel: function(ad_id) {
			var blockpixel = this.isType(ad_id, 'block[_-]?pixel') ? true : false;
			return blockpixel;
		},
	reserveSowefoSpace: function(ad_id) {
			// FIXME: probably obsolete
			return this.isType(ad_id, 'block[_-]?pixel.+' + ad_id) ? true : false;
		},
	isPowerbanner: function(ad_id) {
			return ad_id == 'fullbanner2'
				&& (this.isType(ad_id, 'PB2') || this.isType(ad_id, 'powerbanner'));
		},
	isPushdown: function(ad_id) {
			return ad_id == 'fullbanner2' && this.isType(ad_id, 'pushdown');
		},
	isWallpaper: function(ad_id) {
			return ad_id == 'fullbanner2'
				&& (this.isType(ad_id, 'wp') || this.isType(ad_id, 'wallpaper'));
		},
	isFireplace: function(ad_id) {
			return ad_id == 'fullbanner2' && this.isType(ad_id, 'fireplace');
		},
	isHalfpage: function(ad_id) {
			return ad_id == 'rectangle1' && this.isType(ad_id, 'halfpage');
		},
	isPowerrectangle: function(ad_id) {
			return ad_id == 'rectangle1'
				&& (this.isType(ad_id, 'PR1') || this.isType(ad_id, 'powerrectangle'));
		},
	isPowercurtain: function(ad_id) {
			return ad_id == 'popup1' && this.isType(ad_id, 'powercurtain');
		},
	isXXL: function(ad_id) {
			return ad_id == 'popup1' && this.isType(ad_id, 'xxl');
		},
	isBillboard: function(ad_id) {
			return ad_id == 'fullbanner2' && this.isType(ad_id, 'billboard');
		},
	isBaseboard: function(ad_id) {
			return ad_id == 'popup1' && this.isType(ad_id, 'baseboard');
		},
	isSidebar: function(ad_id) {
			return ad_id == 'skyscraper1'
				&& (this.isSticky(ad_id) || this.isType(ad_id, 'sidebar') || this.isType(ad_id, 'sitebar'));
		},
	isSidekick: function(ad_id) {
			return ad_id == 'skyscraper1' && (this.isType(ad_id, 'sidekick') || this.isType(ad_id, 'sitekick'));
		},
	isPopunder: function(ad_id) {
			return ad_id == 'popup1' && this.isType(ad_id, 'popunder');
		},
	isSticky: function(ad_id) {
			return this.isType(ad_id, 'sticky');
		},
	// Not yet available
	isExpandable: function(ad_id) {
			return this.isType(ad_id, 'expand');
		},

	getWidth: function(ad_id) {
			var dimensions = window.soi_dimension ? window.soi_dimension[ad_id] || [0, 0] : [0, 0];
			var retval = dimensions[0];
			return retval == 1 ? 0 : Number(retval);
		},
	getHeight: function(ad_id) {
			var dimensions = window.soi_dimension ? window.soi_dimension[ad_id] || [0, 0] : [0, 0];
			var retval = dimensions[1];
			return retval == 1 ? 0 : Number(retval);
		},

	setAutoHeight: function(ad_id, arg) {
			if (this.isBlockpixel(ad_id)) return;

			var container = typeof arg == 'string' ? document.getElementById(arg) : arg;
			if (!container) return;

			var has_layout = false;
			if (container.currentStyle) {
				// IE only: check before changing height to 'auto'
				has_layout = container.currentStyle.hasLayout;
			}
			else {
				// Remedy for FF vertical space between object and embed tag
				// Noticeable only in case of height 'auto'
				this.fixEmbedStyle(container);
			}

			container.style.height = 'auto';

			// Remedy for IE layout issues
			if (has_layout && !container.currentStyle.hasLayout) container.style.zoom = 1;
		},
	fixEmbedStyle: function(arg) {
			var container = typeof arg == 'string' ? document.getElementById(arg) : arg;
			if (!container) return;

			// Remedy for FF vertical space between object and embed tag
			var objects = container.getElementsByTagName('object');
			for (var i = 0; i < objects.length; i++) {
				var embeds = objects[i].getElementsByTagName('embed');
				for (var j = 0; j < embeds.length; j++) {
					embeds[j].style.verticalAlign = 'middle';
				}
			}
		},
	// Reinforce class-defined styles
	removeStyleAttribute: function(arg, display) {
			var elem = typeof(arg) == 'string' ? document.getElementById(arg) : arg;
			if (!elem) return;

			// Remedy for Chrome bug:
			// In certain situations, removeAttribute works only *after* getAttribute.
			var xxx = elem.getAttribute('style');

			// Let class-defined styles win (in particular display property).
			elem.removeAttribute('style');

			// Remedy for IE bug:
			// Force class-defined styles because IE applies wrong defaults
			// after removal of style attribute.
			// Must be set even if className is empty.
			if (elem.currentStyle) elem.className = elem.className || '';

			// Just in case style removal did not work ...
			if (display && elem.style.display && elem.style.display != display)
				elem.style.display = display;

			// Remedy for IE bug:
			// After ad_reload, ads are not rendered if the inner wrapper container
			// was previously empty and has display inline-block.
			// This forces re-rendering of the container.
			if (elem.currentStyle && !elem.currentStyle.hasLayout) elem.style.zoom = 1;
		},

	// Method for moving ad to final location
	// special_suffix: suffix for non-standard target container for special ad types (e.g. billboard)
	//                 undefined    => default suffix
	//                 empty string => no suffix
	moveAd: function(ad_id, source_id, target_id, special_suffix) {
			var exists = this.exists(ad_id);
			if (!exists) return;

			var source_element = document.getElementById(source_id);
			if (!source_element) return;
			
			var is_billboard = this.isBillboard(ad_id);
			var special = is_billboard ? 'billboard' : '';
			
			if (special) {
				if (typeof(special_suffix) == 'undefined')
					special_suffix = '-' + special;
			}
			else {
				special_suffix = '';
			}

			// Already in place
			if (source_id == target_id + special_suffix) return;

			var target_element = document.getElementById(target_id + special_suffix);

			if (!target_element) {
				if (!special) return; // hopeless

				var interval = 100;
				var max_wait = 4 * 1000; // millisecs
				var max_rounds = parseInt(max_wait / interval);

				if (!this[special + '_counter']) this[special + '_counter'] = 0;
				if (++this[special + '_counter'] <= max_rounds) {
					// Closure
					var that = this;
					switch (special) {
						case 'billboard':
							setTimeout(
									function() {
										that.moveAd(ad_id, source_id, target_id, special_suffix);
									},
									interval
								);
							break;
					}
					return;
				}
				else {
					// FIXME: use ordinary fullbanner2 target for billboard
					return;
				}
			}
			
			// Remedy for IE bug:
			// Prevent IE duplicate request of script src when moving content of container.
			var embedded_scripts = source_element.getElementsByTagName('script');
			for (var i = 0; i < embedded_scripts.length; i++) {
				if (!embedded_scripts[i].src) continue;
				embedded_scripts[i].removeAttribute('src');
			}

			// Remedy for IE8 CSS bug on inline elements with explicit dir attribute (mediamind issue)
			// (does not help for ads that are not moved to final position)
			try {
				if (window.navigator.userAgent.match(/MSIE 8\.0/)) {
					var divs = source_element.getElementsByTagName('div');
					for (var i = 0; i < divs.length; i++) {
						var x = divs[i];
						if (x.dir && SoiQuery.getCurrentStyle(x, 'display') == 'inline')
							x.removeAttribute('dir');
					}
				}
			}
			catch(e) {}

			var target_parent = target_element.parentNode;

			// Set original id before replacement (css issue with iframe ads)
			source_element.id = target_id + special_suffix;
			target_parent.replaceChild(source_element, target_element);
		}
	};

/******************************************
Initialisation
******************************************/

SoiInitDFPVars();
if (window.DFPSite && window.DFPZone) {
	SoiInitMoreVars();
	SoiAP.init(); // must always happen

	// Load init scripts
	// Must happen *after* definition of SoiLogger.
	if (!window.SOI_INIT_DONE) {
		SoiNugg.init();
		try {
			SoiAP.initAP();
			SoiAP.doProfiling();
		}
		catch(e) {}
		SoiRogator.init();
		SoiYieldProbe.init();
	}
	if (window == parent) SoiPrivacyInfo.init();
}
