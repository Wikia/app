/*jshint camelcase:false*/
/*global define, require*/
define('ext.wikia.adEngine.adLogicPageParams', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adContext',
	require.optional('ext.wikia.adEngine.krux'),
	require.optional('ext.wikia.adEngine.adLogicPageDimensions'),
	require.optional('wikia.abTest')
], function (log, window, adContext, Krux, adLogicPageDimensions, abTest) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adLogicPageParams',
		hostname = window.location.hostname.toString(), // TODO: move to wikia.location module
		adsInHeadExperiment = adContext.getContext().opts.adsInHead && abTest && abTest.getGroup('ADS_IN_HEAD'),
		maxNumberOfCategories = 3,
		maxNumberOfKruxSegments = 27; // keep the DART URL part for Krux segments below 500 chars

	function getDartHubName() {
		var context = adContext.getContext();

		if (context.targeting.wikiVertical === 'Entertainment') {
			return 'ent';
		}
		if (context.targeting.wikiVertical === 'Gaming') {
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
		var categories = adContext.getContext().targeting.pageCategories,
			outCategories;

		if (categories instanceof Array && categories.length > 0) {
			outCategories = categories.slice(0, maxNumberOfCategories);
			return outCategories.join('|').toLowerCase().replace(/ /g, '_').split('|');
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
				if (key && value) {
					params[key] = params[key] || [];
					params[key].push(value);
				}
			}
		}

		return params;
	}

	/**
	 * options
	 * @param options {includeRawDbName: bool}
	 * @returns object
	 */
	function getPageLevelParams(options) {
		// TODO: cache results (keep in mind some of them may change while executing page)

		log('getPageLevelParams', 9, logGroup);

		var site,
			dbName,
			zone1,
			zone2,
			params,
			targeting = adContext.getContext().targeting;

		options = options || {};

		dbName = '_' + (targeting.wikiDbName || 'wikia').replace('/[^0-9A-Z_a-z]/', '_');

		if (targeting.pageIsHub) {
			site = 'hub';
			zone1 = '_' + getDartHubName() + '_hub';
			zone2 = 'hub';
		} else {
			site = targeting.wikiCategory;
			zone1 = dbName;
			zone2 = targeting.pageType || 'article';
		}

		params = {
			s0: site,
			s1: zone1,
			s2: zone2,
			artid: targeting.pageArticleId && targeting.pageArticleId.toString(),
			dmn: getDomain(),
			hostpre: getHostname(),
			wpage: targeting.pageName && targeting.pageName.toLowerCase(),
			lang: targeting.wikiLanguage || 'unknown',
			cat: getCategories(),
			ab: getAb()
		};

		if (options.includeRawDbName) {
			params.rawDbName = dbName;
		}

		if (targeting.pageArticleId) {
			params.pageid = zone1 + '/' + targeting.pageArticleId;
		}

		if (adLogicPageDimensions && adLogicPageDimensions.hasPreFooters()) {
			params.hasp = 'yes';
		} else {
			params.hasp = 'no';
		}

		if (Krux && !targeting.wikiDirectedAtChildren) {
			params.u = Krux.user;
			params.ksgmnt = Krux.segments && Krux.segments.slice(0, maxNumberOfKruxSegments);
		}

		if (targeting.wikiIsTop1000) {
			params.top = '1k';
		}

		extend(params, decodeLegacyDartParams(targeting.wikiCustomKeyValues));

		if (!params.esrb) {
			params.esrb = targeting.wikiDirectedAtChildren ? 'ec' : 'teen';
		}

		if (!adsInHeadExperiment) {
			// This is set in client side (don't move to adContext)
			extend(params, decodeLegacyDartParams(window.amzn_targs));
		}

		log(params, 9, logGroup);
		return params;
	}

	return {
		getPageLevelParams: getPageLevelParams
	};
});
