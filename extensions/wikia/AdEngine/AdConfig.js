/* global Features */
var AdConfig = {
	adSlotsRequiringJSInvocation: { INVISIBLE_TOP:1, INVISIBLE_1:1, INVISIBLE_2:1 },
	geo: null,

	isHighValueCountry: function(country) {
		country = country.toUpperCase();
		if (window.wgHighValueCountries) {
			return window.wgHighValueCountries[country] || false;
		}
	},

	isHighValueSlot: function(slotname) {
		switch (slotname) {
			case 'CORP_TOP_LEADERBOARD':
			case 'CORP_TOP_RIGHT_BOXAD':
			case 'EXIT_STITIAL_BOXAD_1':
			case 'HOME_TOP_LEADERBOARD':
			case 'HOME_TOP_RIGHT_BOXAD':
			case 'HUB_TOP_LEADERBOARD':
			case 'INVISIBLE_MODAL':
			case 'INVISIBLE_TOP':	// skin
			case 'LEFT_SKYSCRAPER_2':
			case 'MIDDLE_RIGHT_BOXAD':
			case 'MODAL_RECTANGLE':
			case 'MODAL_INTERSTITIAL':
			case 'MODAL_VERTICAL_BANNER':
			case 'TEST_HOME_TOP_RIGHT_BOXAD':
			case 'TEST_TOP_RIGHT_BOXAD':
			case 'TOP_LEADERBOARD':
			case 'TOP_RIGHT_BOXAD':
				return true;
			default:
				return false;
		}
	},

	/* Set/get cookies. Borrowed from a jquery plugin. Note that options.expires is either a date object,
	 * or a number of *milli*seconds until the cookie expires */
	cookie: function(name, value, options){
		// name and value given, set cookie
	    if (arguments.length > 1) {
			return Wikia.Cookies.set(name, value, options);
		}
		return Wikia.Cookies.get(name);
	},

	init: function() {
		// Pull the geo data from cookie
		AdConfig.geo = Wikia.geo.getGeoData();
	}
};

/* DART Configuration */
AdConfig.DART = {
	adDriverNumCall: null,
	categories: null,
	categoryStrMaxLength: 300,
	kvStrMaxLength: 500,
	corporateDbName: 'wikiaglobal',
	hasPrefooters: null,
	height: null,
	largeWidth: 1024,
	ord: Math.round(Math.random() * 23456787654), // The random number should be generated once and the same for all
	size: null,
	tile: 1,
	width: null,
	zone1: null,
	zone2: null,

	sizeMap: {
	   '300x250': '300x250,300x600',
	   '600x250': '600x250,300x250',
	   '728x90': '728x90,468x60,980x130,980x65',
	   '160x600': '160x600,120x600',
	   '0x0': '1x1',
	   '300x100': '300x100',
	   '120x240': '120x240',
	   '242x90': '242x90',
       '320x240': '320x240'
	},

	slotMap: {
       'CORP_TOP_LEADERBOARD': {'tile':2, 'loc': 'top', 'dcopt': 'ist'},
       'CORP_TOP_RIGHT_BOXAD': {'tile':1, 'loc': 'top'},
	   'DOCKED_LEADERBOARD': {'tile': 8, 'loc': "bottom"},
	   'EXIT_STITIAL_BOXAD_1': {'tile':2, 'loc': "exit"},
	   'EXIT_STITIAL_BOXAD_2': {'tile':3, 'loc': "exit"},
	   'EXIT_STITIAL_INVISIBLE': {'tile':1, 'loc': "exit", 'dcopt': "ist"},
	   'FOOTER_BOXAD': {'tile': 5, 'loc': "footer"},
	   'HOME_LEFT_SKYSCRAPER_1': {'tile':3, 'loc': "top"},
	   'HOME_LEFT_SKYSCRAPER_2': {'tile':3, 'loc': "middle"},
	   'HOME_TOP_LEADERBOARD': {'tile': 2, 'loc': "top", 'dcopt': "ist"},
	   'HOME_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
	   'HOME_TOP_RIGHT_BUTTON': {'tile': 3, 'loc': "top"},
	   'HUB_TOP_LEADERBOARD': {'tile':2, 'loc': 'top', 'dcopt': 'ist'},
	   'INCONTENT_BOXAD_1': {'tile':4, 'loc': "middle"},
	   'INCONTENT_BOXAD_2': {'tile':5, 'loc': "middle"},
	   'INCONTENT_BOXAD_3': {'tile':6, 'loc': "middle"},
	   'INCONTENT_BOXAD_4': {'tile':7, 'loc': "middle"},
	   'INCONTENT_BOXAD_5': {'tile':8, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_1': {'tile':4, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_2': {'tile':5, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_3': {'tile':6, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_4': {'tile':7, 'loc': "middle"},
	   'INCONTENT_LEADERBOARD_5': {'tile':8, 'loc': "middle"},
	   'INVISIBLE_1': {'tile':10, 'loc': "invisible"},
	   'INVISIBLE_2': {'tile':11, 'loc': "invisible"},
	   'INVISIBLE_MODAL': {'tile':14, 'loc': "invisible"},
	   'INVISIBLE_TOP': {'tile':13, 'loc': "invisible"},
	   'JWPLAYER': {'tile': 2, 'loc': "top"},
	   'LEFT_SKYSCRAPER_1': {'tile': 3, 'loc': "top"},
	   'LEFT_SKYSCRAPER_2': {'tile': 3, 'loc': "middle"},
	   'LEFT_SKYSCRAPER_3': {'tile': 6, 'loc': "footer"},
	   'MIDDLE_RIGHT_BOXAD': {'tile': 1, 'loc': "middle"},
	   'MODAL_RECTANGLE': {'tile':2, 'loc': "modal"},
	   'MODAL_INTERSTITIAL': {'tile':2, 'loc': "modal"},
	   'MODAL_VERTICAL_BANNER': {'tile':2, 'loc': "modal"},
	   'PREFOOTER_BIG': {'tile': 5, 'loc': "footer"},
	   'PREFOOTER_LEFT_BOXAD': {'tile': 5, 'loc': "footer"},
	   'PREFOOTER_RIGHT_BOXAD': {'tile': 5, 'loc': "footer"},
	   'TOP_BUTTON': {'tile': 3, 'loc': 'top'},
	   'TOP_LEADERBOARD': {'tile': 2, 'loc': "top", 'dcopt': "ist"},
	   'TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
	   'TEST_HOME_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
	   'TEST_TOP_RIGHT_BOXAD': {'tile': 1, 'loc': "top"},
	   'TOP_RIGHT_BUTTON': {'tile': 3, 'loc': "top"}
	}
};

AdConfig.DART.getUrl = function(slotname, size, useIframe, adProvider) {
	var mtfIFPath = '',
		src = '',
		DART = AdConfig.DART,
		hostname = window.location.hostname;

	if (DART.sizeMap[size]) {
		size = DART.sizeMap[size];
	}


	switch (adProvider) {
		case 'AdDriver':
			src = 'driver';
			break;
		case 'DART':
			src = 'direct';
			mtfIFPath = 'mtfIFPath=/extensions/wikia/AdEngine/;';  // http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117857, http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117427
			break;
		default: // Liftium
			src = 'liftium';
			mtfIFPath = 'mtfIFPath=/extensions/wikia/AdEngine/;';  // http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117857, http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=117427
			break;
	}

	DART.initSiteAndZones();

	return 'http://' +
		DART.getSubdomain() +
		'.doubleclick.net/' +
		DART.getAdType(useIframe) + '/' +
		DART.site + '/' + DART.zone1 + '/' + DART.zone2 + ';' +
		's0=' + DART.site.replace(/wka\./, '') + ';' +
		's1=' + DART.zone1 + ';' +
		's2=' + DART.zone2 + ';' +
		DART.getCustomKeyValues() +
		DART.getArticleKV() +
		DART.getDomainKV(hostname) +
		DART.getHostnamePrefix(hostname) +
		'pos=' + slotname + ';' +
		DART.getTitle() +
		DART.getLanguage() +
		// TODO when we get better at search, support "kw" key-value
		DART.getResolution() +
		DART.getPrefooterStatus() +
		(window.wgEnableKruxTargeting && window.Krux && window.Krux.dartKeyValues ? DART.rebuildKruxKV(window.Krux.dartKeyValues) : '') +
		DART.getImpressionCount(slotname) +
		DART.getPartnerKeywords() +
		DART.getCategories() +
		DART.getLocKV(slotname) +
		DART.getDcoptKV(slotname) +
		((typeof window.top.wgEnableAdMeldAPIClient != 'undefined' && window.top.wgEnableAdMeldAPIClient) ? window.top.AdMeldAPIClient.getParamForDART(slotname) : '') +
		DART.getCustomVarAB() +
		mtfIFPath +
		'src=' + src + ';' +
		'sz=' + size + ';' +
		'mtfInline=true;' +	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
		DART.getTileKV(slotname, adProvider) +
		'endtag=$;' +
		'ord=' + DART.ord + '?';
};

AdConfig.DART.getMobileUrl = function(slotname, size, useIframe, adProvider) {
		size = '5x5';

	var DART = AdConfig.DART,
		hostname = window.location.hostname;

	DART.initSiteAndZones();

	return 'http://' +
		'ad.mo' +
		'.doubleclick.net/' +
		'DARTProxy/mobile.handler?k=' +
		DART.site + '/' + DART.zone1 + '/' + DART.zone2 + ';' +
		's0=' + DART.site.replace(/wka\./, '') + ';' +
		's1=' + DART.zone1 + ';' +
		's2=' + DART.zone2 + ';' +
		DART.getCustomKeyValues() +
		DART.getArticleKV() +
		DART.getDomainKV(hostname) +
		DART.getHostnamePrefix(hostname) +
		'pos=' + slotname + ';' +
		DART.getTitle() +
		DART.getLanguage() +
		// TODO when we get better at search, support "kw" key-value
		DART.getResolution() +
		DART.getPrefooterStatus() +
		DART.getImpressionCount(slotname) +
		DART.getPartnerKeywords() +
		DART.getCategories() +
		DART.getLocKV(slotname) +
		DART.getDcoptKV(slotname) +
		'positionfixed=' + (Features.positionfixed ? 'css' : 'js') + ';' +
		'src=mobile;' +
		'ord=' + DART.ord + ';' +
		'sz=' + size + ';' +
		'mtfInline=true;' +	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
		DART.getTileKV(slotname, adProvider) +
		//force pixel tracking to happen on the client-side
		//FB#47681
		'&csit=1' +
		'&dw=1' +
		'&u=' + DART.getUniqueId();
};

AdConfig.DART.getSubdomain = function() {
	var subdomain = 'ad';

	if (AdConfig.geo) {
		switch (AdConfig.geo.continent) {
			case 'AF':
			case 'EU':
				subdomain = 'ad-emea';
				break;
			case 'AS':
				switch (AdConfig.geo.country) {
					// Middle East
					case 'AE':
					case 'CY':
					case 'BH':
					case 'IL':
					case 'IQ':
					case 'IR':
					case 'JO':
					case 'KW':
					case 'LB':
					case 'OM':
					case 'PS':
					case 'QA':
					case 'SA':
					case 'SY':
					case 'TR':
					case 'YE':
						subdomain = 'ad-emea';
						break;
					default:
						subdomain = 'ad-apac';
				}
				break;
			case 'OC':
				subdomain = 'ad-apac';
				break;
			default: // NA, SA
				subdomain = 'ad';
		}
	}

	return subdomain;
};

AdConfig.DART.getAdType = function(useIframe) {
	if (useIframe === 'jwplayer') {
		return 'pfadx';
	}

	if (useIframe) {
		return 'adi';
	}

	return 'adj';
};

AdConfig.DART.initSiteAndZones = function() {
	var DART = AdConfig.DART;

	if (DART.isWikiaHub()) {
		DART.site = DART.getSite('hub');
		DART.zone1 = DART.getZone1(window.wgWikiaHubType+'_hub');
		DART.zone2 = 'hub';
	}
	else if (DART.isAutoHub()) {
		var hubsPages = window.wgHubsPages[wgPageName.toLowerCase()];
		DART.site = DART.getSite(hubsPages['site']);
		DART.zone1 = DART.getZone1(hubsPages['name']);
		DART.zone2 = 'hub';
	}

	if (!DART.site) {
		DART.site = DART.getSite(window.cityShort);
	}
	if (!DART.zone1) {
		DART.zone1 = DART.getZone1(window.wgDBname);
	}
	if (!DART.zone2) {
		DART.zone2 = DART.getZone2(window.wikiaPageType);
	}
};

AdConfig.DART.isWikiaHub = function() {
	return !!window.wgWikiaHubType;	// defined in source of hub article
};

AdConfig.DART.isAutoHub = function() {
	if (wgDBname != AdConfig.DART.corporateDbName) {
		return false;
	}

	if (!window.wgHubsPages) {
		return false;
	}

	for (var key in window.wgHubsPages) {
		if (typeof key == 'object' && key['name']) {
			key = key['name'];
		}

		if (wgPageName.toLowerCase() == key.toLowerCase()) {
			return true;
		}
	}

	return false;
};

AdConfig.DART.getSite = function(hub) {
	return 'wka.' + hub;
};

// Effectively the dbname, defaulting to wikia.
AdConfig.DART.getZone1 = function(dbname){
	// Zone1 is prefixed with "_" because zone's can't start with a number, and some dbnames do.
	if (typeof dbname != 'undefined' && dbname){
		return '_' + dbname.replace('/[^0-9A-Z_a-z]/', '_');
	} else {
		return '_wikia';
	}
};

// Page type, ie, "home" or "article"
AdConfig.DART.getZone2 = function(pageType){
	if (typeof pageType != 'undefined' && pageType) {
		return pageType;
	} else {
		return 'article';
	}
};

AdConfig.DART.getCustomKeyValues = function(){
	if (window.wgDartCustomKeyValues) {
		var kv = window.wgDartCustomKeyValues + ';';
		kv = kv.substr(0, AdConfig.DART.kvStrMaxLength);
		kv = kv.replace(/;[^;]*$/, ';');

		return kv;
	}

	return '';
};

AdConfig.DART.getArticleKV = function(){
	if (window.wgArticleId) {
		return "artid=" + wgArticleId + ';';
	} else {
		return '';
	}
};

AdConfig.DART.getDomainKV = function (hostname){
	var lhost, pieces, sld='', np;
	lhost = hostname.toLowerCase();

	pieces = lhost.split(".");
	np = pieces.length;

	if (pieces[np-2] == 'co'){
		// .co.uk or .co.jp
		sld = pieces[np-3] + '.' + pieces[np-2] + '.' + pieces[np-1];
	} else {
		sld = pieces[np-2] + '.' + pieces[np-1];
	}

	if (sld !== ''){
		return 'dmn=' + sld.replace(/\./g, '') + ';';
	} else {
		return '';
	}

};

AdConfig.DART.getHostnamePrefix = function (hostname) {
	lhost = hostname.toLowerCase();
	pieces = lhost.split('.');
	if (pieces.length) {
		return 'hostpre=' + pieces[0] + ';';
	}

	return '';
};

AdConfig.DART.getTitle = function(){
	if (window.wgPageName) {
		return "wpage=" + encodeURIComponent(wgPageName.toLowerCase()) + ";";	// DFP lowercases values of keys
	} else {
		return "";
	}
};

AdConfig.DART.getLanguage = function(){
	var lang = 'unknown';
	if (typeof wgContentLanguage != 'undefined' && wgContentLanguage) {
		lang = wgContentLanguage;
	}
	return 'lang=' + lang + ';';
};

AdConfig.DART.getResolution = function () {
	var DART = AdConfig.DART;

	if (!DART.width || !DART.height) {
		DART.width = document.documentElement.clientWidth || document.body.clientWidth;
		DART.height = document.documentElement.clientHeight || document.body.clientHeight;
	}
	if (DART.width > DART.largeWidth) {
		return 'dis=large;';
	} else {
		return '';
	}
};

AdConfig.DART.getPrefooterStatus = function () {
	if (AdConfig.DART.hasPrefooters == null) {
		if (typeof AdEngine != "undefined") {
			if (AdEngine.isSlotDisplayableOnCurrentPage("PREFOOTER_LEFT_BOXAD")) {
				AdConfig.DART.hasPrefooters = "yes";
			} else {
				AdConfig.DART.hasPrefooters = "no";
			}
		} else {
			AdConfig.DART.hasPrefooters = "unknown";
		}
	}

	return "hasp=" + AdConfig.DART.hasPrefooters + ";";
};

AdConfig.DART.getImpressionCount = function (slotname) {
	// return key-value only if impression cookie exists

	if (AdConfig.DART.adDriverNumCall == null) {
		var cookie = AdConfig.cookie('adDriverNumAllCall');
		if (typeof cookie != 'undefined' && cookie) {
			AdConfig.DART.adDriverNumCall = eval('(' + cookie + ')');
		}
	}

	if (AdConfig.DART.adDriverNumCall != null) {
		for (var i=0; i < AdConfig.DART.adDriverNumCall.length; i++) {
			if (AdConfig.DART.adDriverNumCall[i].slotname == slotname) {
				// check cookie expiration
				if (parseInt(AdConfig.DART.adDriverNumCall[i].ts) + wgAdDriverCookieLifetime*3600000 > wgNow.getTime()) {  // wgAdDriverCookieLifetime in hours, convert to msec
					var num = parseInt(AdConfig.DART.adDriverNumCall[i].num);
					return 'impct=' + num + ';';
				}
			}
		}
	}

	return '';
};

AdConfig.DART.getPartnerKeywords = function() {
	var kw = '';
	if (typeof window.partnerKeywords == 'undefined' || !window.partnerKeywords) {
		return kw;
	}

	kw = 'pkw=' + encodeURIComponent(window.partnerKeywords) + ';';

	return kw;
};

AdConfig.DART.initCategories = function() {
	if (typeof wgCategories != 'object' || !wgCategories) {
		AdConfig.DART.categories = '';
		return;
	}

	var categories = '';

	for (var i=0; i < wgCategories.length; i++) {
		categoryStr = 'cat=' + encodeURIComponent(wgCategories[i].toLowerCase().replace(/ /g, '_')) + ';';
		if (categories.length + categoryStr.length <= AdConfig.DART.categoryStrMaxLength) {
			categories += categoryStr;
		}
	}

	AdConfig.DART.categories = categories;
};

AdConfig.DART.getCategories = function() {
	if (!AdConfig.DART.categories) {
		AdConfig.DART.initCategories();
	}

	return AdConfig.DART.categories;
};

AdConfig.DART.getLocKV = function (slotname){
	if (AdConfig.DART.slotMap[slotname] && AdConfig.DART.slotMap[slotname].loc){
		return 'loc=' + AdConfig.DART.slotMap[slotname].loc + ';';
	} else {
		return '';
	}
};

AdConfig.DART.getDcoptKV = function(slotname){
	if (window.wgUserName && !window.wgUserShowAds) {
		return '';
	}
	else if (AdConfig.DART.slotMap[slotname] && AdConfig.DART.slotMap[slotname].dcopt){
		return 'dcopt=' + AdConfig.DART.slotMap[slotname].dcopt + ';';
	} else {
		return '';
	}
};

AdConfig.DART.getCustomVarAB = function() {
	var ab;

	if ( typeof window.top.Wikia.AbTest != 'undefined' ) {
		ab = window.top.Wikia.AbTest.getTreatmentGroup( "AD_LOAD_TIMING" );
	}

	return ab ? 'ab=e1g' + ab + ';' : '';
};

AdConfig.DART.getTileKV = function (slotname, adProvider){
	switch (adProvider) {
		case 'AdDriver':
			return 'tile=' + AdConfig.DART.tile++ + ';';
			break;
		default:
			if (AdConfig.DART.slotMap[slotname] && AdConfig.DART.slotMap[slotname].tile){
				return 'tile=' + AdConfig.DART.slotMap[slotname].tile + ';';
			}
	}

	return '';
};

AdConfig.DART.rebuildKruxKV = function(kv) {
	if (kv) {
		kv = kv.substr(0, AdConfig.DART.kvStrMaxLength);
		kv = kv.replace(/;[^;]*$/, ';');

		return kv;
	}

	return '';
};

AdConfig.DART.getUniqueId = function () {
	/* not available on the 1st pv, not useful for ads
	var wikia_beacon_id = AdConfig.cookie('wikia_beacon_id');
	if (typeof wikia_beacon_id != 'undefined' && wikia_beacon_id) {
//console.log('wikia_beacon_id: ' + wikia_beacon_id);
		return wikia_beacon_id;
	}
	*/

	var wikia_mobile_id = AdConfig.cookie('wikia_mobile_id');
	if (typeof wikia_mobile_id != 'undefined' && wikia_mobile_id) {
//console.log('wikia_mobile_id: ' + wikia_mobile_id);
		return wikia_mobile_id;
	} else {
		wikia_mobile_id = Math.round(Math.random() * 23456787654); // c&p from dart unique id method
//console.log('new mobile_id: ' + wikia_mobile_id);
		// 180 is c&p from wikia_beacon_id definition
		AdConfig.cookie('wikia_mobile_id', wikia_mobile_id, {expires: 1000*60*60*24*180, path: wgCookiePath, domain: wgCookieDomain});
		return wikia_mobile_id;
	}

//console.log('unique id not available');
	//return '';
};

AdConfig.init();
