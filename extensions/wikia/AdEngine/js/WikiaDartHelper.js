
var WikiaDartHelper = function (log, window, document, Krux, adLogicShortPage, dartUrl, abTest) {
	'use strict';

	var logGroup = 'WikiaDartHelper',
		getUrl,
		ord = Math.round(Math.random() * 23456787654),
		tile = 1,

		categoryStrMaxLength = 300,

		getCustomKeyValues,
		getDomain,
		getDomainKV,
		getDartHubName,
		getHostname,
		getHostnamePrefix,
		getKruxKeyValues,
		getCategories,
		getAb;

	getDartHubName = function () {
		if (window.cscoreCat === 'Entertainment') {
			return 'ent';
		}
		if (window.cscoreCat === 'Gaming') {
			return 'gaming';
		}
		return 'life';
	};

	getCustomKeyValues = function () {
		if (window.wgDartCustomKeyValues) {
			return window.wgDartCustomKeyValues + ';';
		}
		return '';
	};

	getDomain = function (hostname) {
		var lhost, pieces, sld = '', np;
		lhost = hostname.toLowerCase();

		pieces = lhost.split('.');
		np = pieces.length;

		if (pieces[np - 2] === 'co') {
			// .co.uk or .co.jp
			sld = pieces[np - 3] + '.' + pieces[np - 2] + '.' + pieces[np - 1];
		} else {
			sld = pieces[np - 2] + '.' + pieces[np - 1];
		}

		return sld.replace(/\./g, '');
	};

	getDomainKV = function (hostname) {
		return dartUrl.decorateParam('dmn', getDomain(hostname));
	};

	getHostname = function (hostname) {
		var lhost = hostname.toLowerCase(),
			pieces = lhost.split('.');

		if (pieces.length) {
			return pieces[0];
		}
	};

	getHostnamePrefix = function (hostname) {
		return dartUrl.decorateParam('hostpre', getHostname(hostname));
	};

	getCategories = function () {
		if (window.wgCategories instanceof Array) {
			return window.wgCategories.join('|').toLowerCase().replace(/ /g, '_').split('|');
		}
	};

	getAb = function () {
		var experiments, i, ab = [];

		if (abTest) {
			experiments = abTest.getExperiments();
			for (i = 0; i < experiments.length; i += 1) {
				ab.push(experiments[i].id + '_' + experiments[i].group.id);
			}
		}

		return ab;
	};

	/**
	 * Get URL for DART call
	 *
	 * @param params {
	 *   REQUIRED:
	 *     subdomain
	 *     slotname
	 *     slotsize
	 *   OPTIONAL:
	 *     adType (default: adj, adi, jwplayer, mobile)
	 *     src (default: driver)
	 *     loc, dcopt, tile, positionfixed
	 * }
	 * @return {String} URL of DART script
	 */
	getUrl = function (params) {
		var slotname = params.slotname,
			size = params.slotsize,
			adType = params.adType || 'adj',
			pathPrefix,
			src = params.src || 'driver',
			localTile,
			localOrd = params.ord || ord,
			url,
			subdomain = params.subdomain,
			site,
			zone1,
			zone2,
			clientWidth = document.documentElement.clientWidth || document.body.clientWidth;

		if (adType === 'jwplayer') {
			adType = 'pfadx';
		}

		if (adType === 'mobile') {
			pathPrefix = 'DARTProxy/mobile.handler?k=' + ( window.wgDFPid ? window.wgDFPid + '/' : '' );
		}

		pathPrefix = pathPrefix || ( window.wgDFPid ? window.wgDFPid + '/' : '' ) + adType + '/';

		if (params.tile) {
			localTile = params.tile;
		} else {
			localTile = tile;
			tile += 1;
		}

		log(['getUrl', slotname, size], 5, logGroup);

		if (window.wikiaPageIsHub) {
			site = 'hub';
			zone1 = '_' + getDartHubName() + '_hub';
			zone2 = 'hub';
		} else {
			site = window.cityShort;
			zone1 = '_' + (window.wgDBname || 'wikia').replace('/[^0-9A-Z_a-z]/', '_');
			zone2 = window.wikiaPageType || 'article';
		}

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
		url = dartUrl.urlBuilder(
			subdomain + '.doubleclick.net',
			pathPrefix + 'wka.' + site + '/' + zone1 + '/' + zone2
		);
		url.addParam('s0', site);
		url.addParam('s1', zone1);
		url.addParam('s2', zone2);
		url.addString(getCustomKeyValues(), true);
		url.addParam('artid', window.wgArticleId);
		url.addParam('dmn', getDomain(window.location.hostname)); // TODO inconsistent, most func just read window.*
		url.addParam('hostpre', getHostname(window.location.hostname)); // TODO inconsistent, most func just read window.*
		url.addParam('pos', params.slotname);
		if (window.wgPageName) {
			url.addParam('wpage', window.wgPageName.toLowerCase());
		}
		url.addParam('lang', window.wgContentLanguage || 'unknown');
		if (clientWidth > 1024) {
			url.addParam('dis', 'large');
		}
		if (adLogicShortPage && adLogicShortPage.hasPreFooters()) {
			url.addParam('hasp', 'yes');
		} else {
			url.addParam('hasp', 'no');
		}
		url.addParam('positionfixed', params.positionfixed);
		if (Krux) {
			url.addString(Krux && Krux.dartKeyValues, true);
		}
		url.addParam('cat', getCategories(), categoryStrMaxLength);
		url.addParam('loc', params.loc);
		url.addParam('dcopt', params.dcopt);
		url.addString(window.AdMeldAPIClient ? window.AdMeldAPIClient.getParamForDART(slotname) : ''); // TODO FIXME missing in adsinhead
		url.addParam('src', src);
		url.addParam('sz', size);
		url.addParam('ab', getAb());
		url.addString('mtfIFPath=/extensions/wikia/AdEngine/;');
		url.addParam('mtfInline', 'true');	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
		url.addParam('tile', localTile);
		if (!params.omitEndTag) {
			url.addString('endtag=$;');
		}
		url.addString('ord=' + localOrd + '?');

		log(url.toString(), 5, logGroup);
		return url.toString();
	};

	getKruxKeyValues = function () {
		if (Krux && Krux.dartKeyValues) {
			return dartUrl.trimParam(Krux.dartKeyValues);
		}
		return '';
	};

	return {
		getUrl: getUrl,
		getCustomKeyValues: getCustomKeyValues,
		getDomainKV: getDomainKV,
		getHostnamePrefix: getHostnamePrefix,
		getKruxKeyValues: getKruxKeyValues
	};
};
