/*jshint camelcase:false*/
/*global define, require*/
define('ext.wikia.adEngine.adLogicPageParams', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageViewCounter',
	'ext.wikia.adEngine.utils.adLogicZoneParams',
	'wikia.document',
	'wikia.geo',
	'wikia.location',
	'wikia.log',
	'wikia.window',
	require.optional('wikia.abTest'),
	require.optional('wikia.krux')
], function (adContext, pvCounter, zoneParams, doc, geo, loc, log, win, abTest, krux) {
	'use strict';

	var context = {},
		logGroup = 'ext.wikia.adEngine.adLogicPageParams',
		skin = adContext.getContext().targeting.skin;

	function updateContext() {
		context = adContext.getContext();
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
	 * Get the AbPerformanceTesting experiment name
	 *
	 * @returns {string}
	 */
	function getPerformanceAb() {
		return win.wgABPerformanceTest;
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
				if (key && value && key !== 'esrb') {
					params[key] = params[key] || [];
					params[key].push(value);
				}
			}
		}

		return params;
	}

	function getRefParam() {
		var hostnameMatch,
			ref = doc.referrer,
			refHostname,
			searchDomains = /(google|search\.yahooo|bing|baidu|ask|yandex)/,
			wikiDomains = [
				'wikia.com', 'ffxiclopedia.org', 'jedipedia.de',
				'memory-alpha.org', 'uncyclopedia.org',
				'websitewiki.de', 'wowwiki.com', 'yoyowiki.org'
			],
			wikiDomainsRegex = new RegExp('(^|\\.)(' + wikiDomains.join('|').replace(/\./g, '\\.') + ')$');

		if (!ref || typeof ref !== 'string') {
			return 'direct';
		}

		refHostname = ref.match(/\/\/([^\/]+)\//);

		if (refHostname) {
			refHostname = refHostname[1];
		}

		hostnameMatch = refHostname === loc.hostname;

		if (hostnameMatch && ref.indexOf('search=') > -1) {
			return 'wiki_search';
		}
		if (hostnameMatch) {
			return 'wiki';
		}

		hostnameMatch = wikiDomainsRegex.test(refHostname);

		if (hostnameMatch && ref.indexOf('search=') > -1) {
			return 'wikia_search';
		}

		if (hostnameMatch) {
			return 'wikia';
		}

		if (searchDomains.test(refHostname)) {
			return 'external_search';
		}

		return 'external';
	}

	function getAspectRatio() {
		return win.innerWidth > win.innerHeight ? '4:3' : '3:4';
	}

	/**
	 * Returns page level params
	 * @param {Object} options
	 * @param {Boolean} options.includeRawDbName - to include raw db name or not
	 * @returns object
	 */
	function getPageLevelParams(options) {
		// TODO: cache results (keep in mind some of them may change while executing page)
		log('getPageLevelParams', 9, logGroup);

		var params,
			targeting = context.targeting,
			pvs = pvCounter.get();

		options = options || {};

		params = {
			s0: zoneParams.getSite(),
			s0v: zoneParams.getVertical(),
			s0c: zoneParams.getWikiCategories(),
			s1: zoneParams.getName(),
			s2: zoneParams.getPageType(),
			ab: getAb(),
			ar: getAspectRatio(),
			perfab: getPerformanceAb(),
			artid: targeting.pageArticleId && targeting.pageArticleId.toString(),
			cat: zoneParams.getPageCategories(),
			dmn: zoneParams.getDomain(),
			hostpre: zoneParams.getHostnamePrefix(),
			skin: targeting.skin,
			lang: zoneParams.getLanguage(),
			wpage: targeting.pageName && targeting.pageName.toLowerCase(),
			ref: getRefParam(),
			esrb: targeting.esrbRating,
			geo: geo.getCountryCode()
		};

		if (pvs) {
			params.pv = pvs.toString();
		}

		if (options.includeRawDbName) {
			params.rawDbName = zoneParams.getRawDbName();
		}

		if (krux && targeting.enableKruxTargeting) {
			params.u = krux.getUser();
			params.ksgmnt = krux.getSegments();
		}

		if (targeting.wikiIsTop1000) {
			params.top = '1k';
		}

		extend(params, decodeLegacyDartParams(targeting.wikiCustomKeyValues));

		log(params, 9, logGroup);
		return params;
	}

	if (skin && skin !== 'mercury') {
		pvCounter.increment();
	}

	updateContext();
	adContext.addCallback(updateContext);

	return {
		getPageLevelParams: getPageLevelParams
	};
});
