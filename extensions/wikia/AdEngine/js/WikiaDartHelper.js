var WikiaDartHelper = function (log, window, document, Geo) {

	// TODO refactor...
	// AdConfig.DART c&p begin

	var sizeMap = {
		'300x250': '300x250,300x600',
		'600x250': '600x250,300x250',
		'728x90': '728x90,468x60,980x130,980x65',
		'160x600': '160x600,120x600',
		'0x0': '1x1',
		'300x100': '300x100',
		'120x240': '120x240',
		'242x90': '242x90',
		'320x240': '320x240'
	};

	var site = null, zone1 = null, zone2 = null;

	var ord = Math.round(Math.random() * 23456787654);

	AdConfig_DART_getUrl = function(slotname, size, useIframe, adProvider) {
		log('AdConfig_DART_getUrl', 5, 'AdProviderAdDriver2');
		log([slotname, size, useIframe, adProvider], 5, 'AdProviderAdDriver2');

		if (sizeMap[size]) {
			size = sizeMap[size];
		}

		initSiteAndZones();

		var url = 'http://' +
			getSubdomain() +
			'.doubleclick.net/' +
			getAdType(useIframe) + '/' +
			site + '/' + zone1 + '/' + zone2 + ';' +
			's0=' + site.replace(/wka\./, '') + ';' +
			's1=' + zone1 + ';' +
			's2=' + zone2 + ';' +
			getCustomKeyValues() +
			getArticleKV() +
			getDomainKV(window.location.hostname) + // TODO inconsistent, most func just read window.*
			getHostnamePrefix(window.location.hostname) + // TODO inconsistent, most func just read window.*
			'pos=' + slotname + ';' +
			getTitle() +
			getLanguage() +
			getResolution() +
			getPrefooterStatus() +
//			(window.wgEnableKruxTargeting && window.Krux && window.Krux.dartKeyValues ? DART.rebuildKruxKV(window.Krux.dartKeyValues) : '') +
			getImpressionCount(slotname) +
			getPartnerKeywords() +
			getCategories() +
			getLocKV(slotname) +
			getDcoptKV(slotname) +
//			((typeof window.top.wgEnableAdMeldAPIClient != 'undefined' && window.top.wgEnableAdMeldAPIClient) ? window.top.AdMeldAPIClient.getParamForDART(slotname) : '') +
			'mtfIFPath=/extensions/wikia/AdEngine/;' +
			'src=driver;' +
			'sz=' + size + ';' +
			'mtfInline=true;' +	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
			getTileKV(slotname, adProvider) +
			'endtag=$;' +
			'ord=' + ord + '?';

		log(url, /* 7 */ 5, 'AdProviderAdDriver2');
		return url;
	}

	function initSiteAndZones() {
		if (isWikiaHub()) {
			site = getSite('hub');
			zone1 = getZone1(window.wgWikiaHubType+'_hub');
			zone2 = 'hub';
		}
		else if (isAutoHub()) {
			var hubsPages = window.wgHubsPages[wgPageName.toLowerCase()];
			site = getSite(hubsPages['site']);
			zone1 = getZone1(hubsPages['name']);
			zone2 = 'hub';
		}

		if (!site) {
			site = getSite(window.cscoreCat.toLowerCase());
		}
		if (!zone1) {
			zone1 = getZone1(window.wgDBname);
		}
		if (!zone2) {
			zone2 = getZone2(window.wikiaPageType);
		}
	}

	// TODO @rychu refactor out?
	function isWikiaHub() {
		return !!window.wgWikiaHubType;	// defined in source of hub article
	}

	// TODO @rychu refactor out?
	function isAutoHub() {
		if (window.wgDBname != 'wikiaglobal') {
			return false;
		}

		if (!window.wgHubsPages) {
			return false;
		}

		for (var key in window.wgHubsPages) {
			if (typeof key == 'object' && key['name']) {
				key = key['name'];
			}

			if (window.wgPageName.toLowerCase() == key.toLowerCase()) {
				return true;
			}
		}

		return false;
	}

	function getSite(hub) {
		return 'wka.' + hub;
	}

	// Effectively the dbname, defaulting to wikia.
	function getZone1(dbname){
		// Zone1 is prefixed with "_" because zone's can't start with a number, and some dbnames do.
		if (typeof dbname != 'undefined' && dbname){
			return '_' + dbname.replace('/[^0-9A-Z_a-z]/', '_');
		} else {
			return '_wikia';
		}
	}

	// Page type, ie, "home" or "article"
	function getZone2(pageType){
		if (typeof pageType != 'undefined' && pageType) {
			return pageType;
		} else {
			return 'article';
		}
	}

	function getSubdomain() {
		var subdomain = 'ad';

		//if (AdConfig.geo) {
			switch (Geo.getContinentCode()) {
				case 'AF':
				case 'EU':
					subdomain = 'ad-emea';
					break;
				case 'AS':
					switch (Geo.getCountryCode()) {
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
		//}

		return subdomain;
	}

	function getAdType(useIframe) {
		if (useIframe === 'jwplayer') {
			return 'pfadx';
		}

		if (useIframe) {
			return 'adi';
		}

		return 'adj';
	}

	var kvStrMaxLength = 500;

	function getCustomKeyValues(){
		if (window.wgDartCustomKeyValues) {
			var kv = window.wgDartCustomKeyValues + ';';
			kv = kv.substr(0, kvStrMaxLength);
			kv = kv.replace(/;[^;]*$/, ';');

			return kv;
		}

		return '';
	}

	function getArticleKV(){
		if (window.wgArticleId) {
			return "artid=" + window.wgArticleId + ';';
		} else {
			return '';
		}
	}

	function getDomainKV(hostname){
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
	}

	function getHostnamePrefix(hostname) {
		lhost = hostname.toLowerCase();
		pieces = lhost.split('.');
		if (pieces.length) {
			return 'hostpre=' + pieces[0] + ';';
		}

		return '';
	}

	function getTitle(){
		if (window.wgPageName) {
			return "wpage=" + encodeURIComponent(wgPageName.toLowerCase()) + ";";	// DFP lowercases values of keys
		} else {
			return "";
		}
	}

	function getLanguage(){
		var lang = 'unknown';
		if (window.wgContentLanguage) {
			lang = window.wgContentLanguage;
		}
		return 'lang=' + lang + ';';
	}

	var width = null;

	function getResolution() {
		if (!width) {
			width = document.documentElement.clientWidth || document.body.clientWidth;
		}
		if (width > 1024) {
			return 'dis=large;';
		} else {
			return '';
		}
	}

	var hasPrefooters = null;

	// TODO FIXME? remove?
	function getPrefooterStatus() {
		if (!hasPrefooters) {
			if (false /* typeof AdEngine != "undefined" */) {
				if (AdEngine.isSlotDisplayableOnCurrentPage("PREFOOTER_LEFT_BOXAD")) {
					hasPrefooters = "yes";
				} else {
					hasPrefooters = "no";
				}
			} else {
				hasPrefooters = "unknown";
			}
		}

		return "hasp=" + hasPrefooters + ";";
	}

	// TODO FIXME? remove?
	function getImpressionCount(slotname) {
		/*
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
					if (parseInt(AdConfig.DART.adDriverNumCall[i].ts) + 1*3600000 > wgNow.getTime()) {  // wgAdDriverCookieLifetime in hours, convert to msec
						var num = parseInt(AdConfig.DART.adDriverNumCall[i].num);
						return 'impct=' + num + ';';
					}
				}
			}
		}
		*/

		return '';
	}

	// TODO remove?
	function getPartnerKeywords() {
		var kw = '';
		if (typeof window.partnerKeywords == 'undefined' || !window.partnerKeywords) {
			return kw;
		}

		kw = 'pkw=' + encodeURIComponent(window.partnerKeywords) + ';';

		return kw;
	}

	var categories = null;
	var categoryStrMaxLength = 300;

	function initCategories() {
		if (typeof window.wgCategories != 'object' || !window.wgCategories) {
			categories = '';
			return;
		}

		for (var i=0; i < window.wgCategories.length; i++) {
			categories += 'cat=' + encodeURIComponent(window.wgCategories[i].toLowerCase().replace(/ /g, '_')) + ';';
		}

		categories = categories.substr(0, categoryStrMaxLength);
		categories = categories.replace(/;[^;]*$/, ';');
	}

	function getCategories() {
		if (!categories) {
			initCategories();
		}

		return categories;
	}

	var slotMap = {
		'CORP_TOP_LEADERBOARD': {'tile':2, 'loc': 'top', 'dcopt': 'ist'},
		'CORP_TOP_RIGHT_BOXAD': {'tile':1, 'loc': 'top'},
		'DOCKED_LEADERBOARD': {'tile': 8, 'loc': "bottom"},
		'EXIT_STITIAL_BOXAD_1': {'tile':2, 'loc': "exit"},
		'EXIT_STITIAL_BOXAD_2': {'tile':3, 'loc': "exit"},
		'EXIT_STITIAL_INVISIBLE': {'tile':1, 'loc': "exit", 'dcopt': "ist"},
		'FOOTER_BOXAD': {'tile': 5, 'loc': "footer"},
		'HOME_INVISIBLE_TOP': {'tile':12, 'loc': "invisible"},
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
	};

	function getLocKV(slotname){
		if (slotMap[slotname] && slotMap[slotname].loc){
			return 'loc=' + slotMap[slotname].loc + ';';
		} else {
			return '';
		}
	}

	function getDcoptKV(slotname){
		// wtf ???
		if (window.wgUserName && !window.wgUserShowAds) {
			return '';
		}
		else if (slotMap[slotname] && slotMap[slotname].dcopt){
			return 'dcopt=' + slotMap[slotname].dcopt + ';';
		} else {
			return '';
		}
	}

	var tile = 1;

	// TODO just tile++ for all?
	function getTileKV(slotname, adProvider){
		switch (adProvider) {
			case 'AdDriver':
				return 'tile=' + tile++ + ';';
				break;
			default:
				if (slotMap[slotname] && slotMap[slotname].tile){
					return 'tile=' + slotMap[slotname].tile + ';';
				}
		}

		return '';
	}

	// AdConfig.DART c&p end

	return {
		AdConfig_DART_getUrl: AdConfig_DART_getUrl
	};
};
