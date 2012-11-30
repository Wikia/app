
var WikiaDartHelper = function (log, window, document, Geo, Krux, adLogicShortPage) {
	'use strict';

	var logGroup = 'WikiaDartHelper'
		, getUrl
		, ord = Math.round(Math.random() * 23456787654)
		, tile = 1
		, initSiteAndZones

		, kvStrMaxLength = 500
		, categoryStrMaxLength = 300

		, decorateAsKv, trimKvs
		, isWikiaHub, isAutoHub, getSite, getZone1, getZone2
		, getSubdomain, getCustomKeyValues, getArticleKV
		, getDomainKV, getHostnamePrefix, getTitle, getLanguage
		, getResolution, getPrefooterStatus, getImpressionCount
		, getPartnerKeywords, getCategories

		, site, zone1, zone2
	;

	trimKvs = function(kvs, limit) {
		return kvs.substr(0, limit).replace(/;[^;]*$/, ';');
	};

	decorateAsKv = function(key, value) {
		if (value) {
			return key + '=' + value + ';';
		}
		return '';
	};

	// TODO @rychu refactor out?
	isWikiaHub = function() {
		return !!window.wgWikiaHubType;	// defined in source of hub article
	};

	// TODO @rychu refactor out?
	// TODO: this function doesn't really work
	isAutoHub = function() {
		var key;

		if (window.wgDBname !== 'wikiaglobal') {
			return false;
		}

		if (!window.wgHubsPages) {
			return false;
		}

		for (key in window.wgHubsPages) {
			if (window.wgHubsPages.hasOwnProperty(key)) {
				if (window.wgPageName.toLowerCase() === key.toLowerCase()) {
					return true;
				}
			}
		}

		return false;
	};

	getSite = function(hub) {
		return 'wka.' + hub;
	};

	// Effectively the dbname, defaulting to wikia.
	getZone1 = function(dbname){
		// Zone1 is prefixed with "_" because zone's can't start with a number, and some dbnames do.
		if (dbname) {
			return '_' + dbname.replace('/[^0-9A-Z_a-z]/', '_');
		}
		return '_wikia';
	};

	// Page type, ie, "home" or "article"
	getZone2 = function(pageType){
		if (pageType) {
			return pageType;
		}
		return 'article';
	};

	getSubdomain = function() {
		var subdomain;

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

		return subdomain;
	};

	getCustomKeyValues = function() {
		if (window.wgDartCustomKeyValues) {
			return trimKvs(window.wgDartCustomKeyValues + ';', kvStrMaxLength);
		}
		return '';
	};

	getArticleKV = function() {
		return decorateAsKv('artid', window.wgArticleId);
	};

	getDomainKV = function(hostname) {
		var lhost, pieces, sld='', np;
		lhost = hostname.toLowerCase();

		pieces = lhost.split(".");
		np = pieces.length;

		if (pieces[np-2] === 'co'){
			// .co.uk or .co.jp
			sld = pieces[np-3] + '.' + pieces[np-2] + '.' + pieces[np-1];
		} else {
			sld = pieces[np-2] + '.' + pieces[np-1];
		}

		return decorateAsKv('dmn', sld.replace(/\./g, ''));
	};

	getHostnamePrefix = function(hostname) {
		var lhost = hostname.toLowerCase()
			, pieces = lhost.split('.')
			;
		if (pieces.length) {
			return decorateAsKv('hostpre', pieces[0]);
		}

		return '';
	};

	getTitle = function () {
		if (window.wgPageName) {
			return "wpage=" + encodeURIComponent(window.wgPageName.toLowerCase()) + ";";	// DFP lowercases values of keys
		}
		return "";
	};

	getLanguage = function () {
		var lang = 'unknown';
		if (window.wgContentLanguage) {
			lang = window.wgContentLanguage;
		}
		return 'lang=' + lang + ';';
	};

	getResolution = function() {
		var width = document.documentElement.clientWidth || document.body.clientWidth;
		if (width > 1024) {
			return 'dis=large;';
		}
		return '';
	};

	getPrefooterStatus = function() {
		if (adLogicShortPage && adLogicShortPage.hasPreFooters()) {
			return 'hasp=yes;';
		}
		return 'hasp=no;';
	};

	// TODO FIXME? remove?
	getImpressionCount = function(slotname) {
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
	};

	// TODO remove?
	getPartnerKeywords = function() {
		var kw = '';
		if (!window.partnerKeywords) {
			return kw;
		}

		kw = 'pkw=' + encodeURIComponent(window.partnerKeywords) + ';';

		return kw;
	};

	getCategories = function() {
		var i, categories = '';

		if (!window.wgCategories) {
			return '';
		}

		for (i = 0; i < window.wgCategories.length; i += 1) {
			categories += 'cat=' + encodeURIComponent(window.wgCategories[i].toLowerCase().replace(/ /g, '_')) + ';';
		}

		return trimKvs(categories, categoryStrMaxLength);
	};

	/**
	 * Get URL for DART call
	 *
	 * @param params {
	 *   REQUIRED:
	 *     slotname
	 *     slotsize
	 *   OPTIONAL:
	 *     adType (default: adj, adi, jwplayer, mobile)
	 *     src (default: driver)
	 *     subdomain (default: by geo)
	 *     loc, dcopt, tile, positionfixed
	 * }
	 * @return {String} URL of DART script
	 */
	getUrl = function(params) {
		var slotname = params.slotname,
			size = params.slotsize,
			adType = params.adType || 'adj',
			pathPrefix,
			loc = decorateAsKv('loc', params.loc),
			dcopt = decorateAsKv('dcopt', params.dcopt),
			src = params.src || 'driver',
			localTile,
			kruxKV = '',
			url,
			subdomain = params.subdomain || getSubdomain(),
			endTag = params.omitEndTag ? '' : 'endtag=$;';

		if (adType === 'jwplayer') {
			pathPrefix = 'pfadx/';
		}

		if (adType === 'mobile') {
			pathPrefix = 'DARTProxy/mobile.handler?k=';
		}

		pathPrefix = pathPrefix || adType + '/';

		if (params.tile) {
			localTile = params.tile;
		} else {
			localTile = tile;
			tile += 1;
		}

		if (Krux && Krux.dartKeyValues) {
			kruxKV = trimKvs(Krux.dartKeyValues, kvStrMaxLength);
		}

		log(['getUrl', slotname, size], 5, logGroup);

		initSiteAndZones();

		/*
		 http://ad.doubleclick.net/adj/wka.ent/_glee/article;s0=ent;s1=_glee;s2=article;media=tv;sex=f;age=13-17;age=18-34;eth=asian;hhi=0-30;aff=fashion;aff=teens;age=teen;aff=video;aff=communities;artid=2102;dmn=wikia-devcom;hostpre=glee;pos=TOP_RIGHT_BOXAD;wpage=the_rhodes_not_taken;lang=en;dis=large;hasp=yes;u=H5feJdXS;ksgmnt=l4ml7tc6y;ksgmnt=l7drxohb5;ksgmnt=mhu7kdyz5;ksgmnt=mkwaoxp2x;ksgmnt=mkcdphvyq;ksgmnt=l4ipfweef;ksgmnt=mhu6miy43;ksgmnt=l5g2q8ndp;ksgmnt=l6dwvwk4q;ksgmnt=mlhkv0y2u;ksgmnt=l60oj8o6a;ksgmnt=l65e7q72q;ksgmnt=mdfzhvp3x;ksgmnt=mczlqdo8q;ksgmnt=l9cwgqxmx;ksgmnt=miqlt2xrx;ksgmnt=mhu6jt32u;ksgmnt=l5hqg89ks;ksgmnt=md0socy4l;ksgmnt=mnbz18cpv;ksgmnt=l8cvx4q0q;
		 impct=4;cat=episodes;cat=season_one;cat=april_rhodes;cat=glee_episodes;cat=cabaret;cat=episode_5;cat=carrie_underwood;cat=queen;cat=terri_schuester;cat=will_schuester;cat=finn-centric;cat=kristin_chenoweth;
		 loc=top;admeld=-1.00;ab=e1g1;src=driver;sz=300x250,300x600;mtfInline=true;tile=2;endtag=$;ord=17177439419?


		 http://ad.doubleclick.net/adj/wka.ent/_glee/article;s0=ent;s1=_glee;s2=article;media=tv;sex=f;age=13-17;age=18-34;eth=asian;hhi=0-30;aff=fashion;aff=teens;age=teen;aff=video;aff=communities;artid=2102;dmn=wikia-devcom;hostpre=glee;pos=TOP_LEADERBOARD;wpage=the_rhodes_not_taken;lang=en;dis=large;hasp=unknown;
		 cat=episodes;cat=season_one;cat=april_rhodes;cat=glee_episodes;cat=cabaret;cat=episode_5;cat=carrie_underwood;cat=queen;cat=terri_schuester;cat=will_schuester;cat=finn-centric;cat=kristin_chenoweth;
		 loc=top;dcopt=ist;admeld=-1.00;mtfIFPath=/extensions/wikia/AdEngine/;src=driver;sz=728x90,468x60,980x130,980x65;mtfInline=true;tile=1;endtag=$;ord=2097541707?

		 http://ad.doubleclick.net/adj/wka.ent/_glee/article;s0=ent;s1=_glee;s2=article;media=tv;sex=f;age=13-17;age=18-34;eth=asian;hhi=0-30;aff=fashion;aff=teens;age=teen;aff=video;aff=communities;           dmn=wikia-devcom;hostpre=glee;pos=TOP_LEADERBOARD;                           lang=en;dis=large;hasp=unknown;
		 loc=top;                          dcopt=ist;mtfIFPath=/extensions/wikia/AdEngine/;src=driver;sz=728x90,468x60,980x130,980x65;mtfInline=true;tile=1;endtag=$;ord=21889937933?
		 */
		url = 'http://' +
			subdomain +
			'.doubleclick.net/' +
			pathPrefix +
			site + '/' + zone1 + '/' + zone2 + ';' +
			's0=' + site.replace(/wka\./, '') + ';' +
			's1=' + zone1 + ';' +
			's2=' + zone2 + ';' +
			getCustomKeyValues() +
			getArticleKV() + // TODO FIXME missing in adsinhead
			getDomainKV(window.location.hostname) + // TODO inconsistent, most func just read window.*
			getHostnamePrefix(window.location.hostname) + // TODO inconsistent, most func just read window.*
			'pos=' + slotname + ';' +
			getTitle() + // TODO FIXME missing in adsinhead
			getLanguage() +
			getResolution() +
			getPrefooterStatus() + // TODO FIXME just height
			decorateAsKv('positionfixed', params.positionfixed) +
			kruxKV +
			// getImpressionCount(slotname) + // TODO remove missing
			// getPartnerKeywords() + // TODO remove missing
			getCategories() + // TODO FIXME missing in adsinhead
			loc +
			dcopt +
			(window.AdMeldAPIClient ? window.AdMeldAPIClient.getParamForDART(slotname) : '') + // TODO FIXME missing in adsinhead
			'src=' + src + ';' +
			'sz=' + size + ';' +
			'mtfIFPath=/extensions/wikia/AdEngine/;' +
			'mtfInline=true;' +	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
			'tile=' + localTile + ';' +
			endTag +
			'ord=' + ord + '?';

		log(url, /* 7 */ 5, logGroup);
		return url;
	};

	initSiteAndZones = function() {
		if (isWikiaHub()) {
			site = getSite('hub');
			zone1 = getZone1(window.wgWikiaHubType+'_hub');
			zone2 = 'hub';
		}
		else if (isAutoHub()) {
			var hubsPages = window.wgHubsPages[window.wgPageName.toLowerCase()];
			site = getSite(hubsPages.site);
			zone1 = getZone1(hubsPages.name);
			zone2 = 'hub';
		}

		if (!site) {
			site = getSite(window.cityShort);
		}
		if (!zone1) {
			zone1 = getZone1(window.wgDBname);
		}
		if (!zone2) {
			zone2 = getZone2(window.wikiaPageType);
		}
	};

	return {
		getUrl: getUrl,
		getCustomKeyValues: getCustomKeyValues
	};
};

var WikiaDartMobileHelper = function(log, window, document) {
	'use strict';

	var wikiaDartHelper = WikiaDartHelper(log, window, document);

	return {
		/**
		 * Get URL for a mobile ad
		 *
		 * @param params (slotname, positionfixed, uniqueId)
		 * @return {String} URL of DART script
		 */
		getMobileUrl: function(params) {
			return wikiaDartHelper.getUrl({
				slotname: params.slotname,
				positionfixed: params.positionfixed,
				subdomain: 'ad.mo',
				adType: 'mobile',
				src: 'mobile',
				slotsize: '5x5',
				omitEndTag: true
			}) + '&csit=1&dw=1&u=' + params.uniqueId;
		}
	};
};
