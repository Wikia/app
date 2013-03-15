var AdLogicPageLevelParams = function (
	log,
	window,
	Krux,             // optional
	adLogicShortPage, // optional
	abTest            // optional
) {
	'use strict';

	var logGroup = 'AdLogicPageLevelParams',
		hostname = window.location.hostname.toString();

	function getDartHubName() {
		if (window.cscoreCat === 'Entertainment') {
			return 'ent';
		}
		if (window.cscoreCat === 'Gaming') {
			return 'gaming';
		}
		return 'life';
	}

	function getDomain() {
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
	}

	function getHostname() {
		var lhost = hostname.toLowerCase(),
			pieces = lhost.split('.');

		if (pieces.length) {
			return pieces[0];
		}
	}

	function getCategories() {
		if (window.wgCategories instanceof Array) {
			return window.wgCategories.join('|').toLowerCase().replace(/ /g, '_').split('|');
		}
	}

	function getAb() {
		var experiments, experimentsNumber, i, ab = [];

		if (abTest) {
			experiments = abTest.getExperiments();
			experimentsNumber = experiments.length;
			for (i = 0; i < experimentsNumber; i += 1) {
				ab.push(experiments[i].id + '_' + experiments[i].group.id);
			}
		}

		return ab;
	}

	function getPageLevelParams() {
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
			artid: window.wgArticleId && window.wgArticleId.toString(),
			dmn: getDomain(),
			hostpre: getHostname(),
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
	}

	return {
		getPageLevelParams: getPageLevelParams
	};
};
