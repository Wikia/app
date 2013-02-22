
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

		url = dartUrl.urlBuilder(
			subdomain + '.doubleclick.net',
			pathPrefix + 'wka.' + site + '/' + zone1 + '/' + zone2
		);
		url.addParam('s0', site);
		url.addParam('s1', zone1);
		url.addParam('s2', zone2);
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
			url.addParam('u', Krux.user);
			url.addParam('ksgmnt', Krux.segments, true);
		}
		url.addParam('cat', getCategories(), categoryStrMaxLength);
		url.addParam('loc', params.loc);
		url.addParam('dcopt', params.dcopt);
		url.addParam('src', src);
		url.addParam('sz', size);
		url.addParam('ab', getAb());

		url.addString('mtfIFPath=/extensions/wikia/AdEngine/;');
		url.addParam('mtfInline', 'true');	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220
		url.addString(getCustomKeyValues(), true);

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
