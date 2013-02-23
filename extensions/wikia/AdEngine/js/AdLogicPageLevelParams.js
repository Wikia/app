// TODO: less dependencies, move optional stuff to separate modules
// TODO: don't depend of dartUrl, remove methods relying on it and uses of it
// TODO: remove the unused document depenedency (update uses and tests)

var AdLogicPageLevelParams = function (log, window, document, /* optional */ Krux, /* optional */ adLogicShortPage, /* optional */ abTest, dartUrl) {
	'use strict';

	var logGroup = 'AdLogicPageLevelParams',
		getCustomKeyValues,
		getDomain,
		getDomainKV,
		getDartHubName,
		getHostname,
		getHostnamePrefix,
		getKruxKeyValues,
		getCategories,
		getAb,
		getPageLevelParams;

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
			return dartUrl.trimParam(window.wgDartCustomKeyValues + ';');
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

	getPageLevelParams = function () {
		log('getPageLevelParams', 9, logGroup);

		var site,
			zone1,
			zone2,
			params,
			customParams,
			customParamsNumber,
			customParam,
			i,
			key,
			value;

		if (window.wikiaPageIsHub) {
			site = 'hub';
			zone1 = '_' + getDartHubName() + '_hub';
			zone2 = 'hub';
		} else {
			site = window.cityShort;
			zone1 = '_' + (window.wgDBname || 'wikia').replace('/[^0-9A-Z_a-z]/', '_');
			zone2 = window.wikiaPageType || 'article';
		}

		params = {
			s0: site,
			s1: zone1,
			s2: zone2,
			artid: window.wgArticleId,
			dmn: getDomain(window.location.hostname),
			hostpre: getHostname(window.location.hostname),
			wpage: window.wgPageName && window.wgPageName.toLowerCase(),
			lang: window.wgContentLanguage || 'unknown',
			cat: getCategories(),
			ab: getAb()
		};

		if (adLogicShortPage && adLogicShortPage.hasPreFooters()) {
			params.hasp = 'yes';
		} else {
			params.hasp = 'no';
		}

		if (Krux) {
			params.u = Krux.user;
			params.ksgmnt = Krux.segments;
		}

		if (window.wgDartCustomKeyValues) {
			customParams = window.wgDartCustomKeyValues.split(';');
			customParamsNumber = customParams.length;
			for (i = 0; i < customParamsNumber; i += 1) {
				customParam = customParams[i].split('=');
				key = customParam[0];
				value = customParam[1];
				params[key] = params[key] || [];
				params[key].push(value);
			}
		}

		log(params, 9, logGroup);
		return params;
	};

	getKruxKeyValues = function () {
		if (Krux && Krux.dartKeyValues) {
			return dartUrl.trimParam(Krux.dartKeyValues);
		}
		return '';
	};

	return {
		getCustomKeyValues: getCustomKeyValues,
		getDomainKV: getDomainKV,
		getHostnamePrefix: getHostnamePrefix,
		getKruxKeyValues: getKruxKeyValues,
		getPageLevelParams: getPageLevelParams
	};
};
