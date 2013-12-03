var AdLogicPageLevelParams = function (
	log,
	window,
	Krux,             // optional
	adLogicPageDimensions, // optional
	abTest            // optional
) {
	'use strict';

	var logGroup = 'AdLogicPageLevelParams',
		hostname = window.location.hostname.toString(),
		maxNumberOfCategories = 3,
		maxNumberOfKruxSegments = 27; // keep the DART URL part for Krux segments below 500 chars

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
		if (window.wgCategories instanceof Array && window.wgCategories.length > 0) {
			var categories = window.wgCategories.slice(0, maxNumberOfCategories);
			return categories.join('|').toLowerCase().replace(/ /g, '_').split('|');
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

	/**
	 * Adds the info from the second hash into the first.
	 * If the same key is in both, the key in the second object overrides what's in the first object.
	 *
	 * @param {Object} target object to extend (modified in-place AND returned)
	 * @param {Object} obj extending object
	 * @return {Object} the extended object
	 */
	function extend(target, obj) {
		var key;

		for (key in obj) {
			if (obj.hasOwnProperty(key)) {
				target[key] = obj[key];
			}
		}

		return target;
	}

	/**
	 * Decode legacy dart string
	 *
	 * @param {string} dartString the string to decode
	 * @return {Object} decoded parameters as plain object
	 */
	function decodeLegacyDartParams(dartString) {
		var params = {},
			kvs,
			kv,
			key,
			value,
			i,
			len;

		log(['decodeLegacyDartParams', dartString], 9, logGroup);

		if (typeof dartString === 'string') {
			kvs = dartString.split(';');
			for (i = 0, len = kvs.length; i < len; i += 1) {
				kv = kvs[i].split('=');
				key = kv[0];
				value = kv[1];
				params[key] = params[key] || [];
				params[key].push(value);
			}
		}

		return params;
	}

	function getPageLevelParams() {
		log('getPageLevelParams', 9, logGroup);

		var site,
			zone1,
			zone2,
			params;

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

		if (adLogicPageDimensions && adLogicPageDimensions.hasPreFooters()) {
			params.hasp = 'yes';
		} else {
			params.hasp = 'no';
		}

		if (Krux && !window.wgWikiDirectedAtChildren) {
			params.u = Krux.user;
			params.ksgmnt = Krux.segments && Krux.segments.slice(0, maxNumberOfKruxSegments);
		}

		extend(params, decodeLegacyDartParams(window.wgDartCustomKeyValues));
		extend(params, decodeLegacyDartParams(window.amzn_targs));

		log(params, 9, logGroup);
		return params;
	}

	return {
		getPageLevelParams: getPageLevelParams
	};
};

(function (context) {
	'use strict';
	if (context.define && context.define.amd) {
		context.define('wikia.adlogicpageparams', ['wikia.log', 'wikia.window'], AdLogicPageLevelParams);
	}
}(this));
