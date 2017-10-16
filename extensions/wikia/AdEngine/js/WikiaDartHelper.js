// TODO: This file is only used by JWPlayer. Remove it when JWPlayer is removed
/*global define*/
define('ext.wikia.adEngine.dartHelper', [
	'wikia.log',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.dartUrl',
	'ext.wikia.adEngine.adLogicDartSubdomain'
], function (log, adLogicPageParams, dartUrl, adLogicDartSubdomain) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.dartHelper',
		getUrl,
		ord = Math.round(Math.random() * 23456787654),
		tile = 1,
		categoryStrMaxLength = 300;

	/**
	 * Get URL for DART call
	 *
	 * @param params {
	 *   REQUIRED:
	 *     subdomain
	 *     slotname
	 *     slotsize
	 *   OPTIONAL:
	 *     adType (default: adj, adi, jwplayer)
	 *     src (default: driver)
	 *     loc, dcopt, tile
	 * }
	 * @return {String} URL of DART script
	 */
	getUrl = function (params) {
		var slotname = params.slotname,
			size = params.slotsize,
			adType = params.adType || 'adj',
			src = params.src || 'driver',
			localTile,
			localOrd = params.ord || ord,
			url,
			subdomain = params.subdomain || (adLogicDartSubdomain && adLogicDartSubdomain.getSubdomain()),
			pageParams = adLogicPageParams.getPageLevelParams(),
			name,
			value;

		if (adType === 'jwplayer') {
			adType = 'pfadx';
		}

		if (params.tile) {
			localTile = params.tile;
		} else {
			localTile = tile;
			tile += 1;
		}

		log(['getUrl', slotname, size], 5, logGroup);

		url = dartUrl.urlBuilder(
			subdomain + '.doubleclick.net',
			adType + '/' + 'wka.' + pageParams.s0 + '/' + pageParams.s1 + '/' + pageParams.s2
		);

		// per page params
		for (name in pageParams) {
			if (pageParams.hasOwnProperty(name)) {
				value = pageParams[name];
				if (value) {
					if (name === 'cat') {
						url.addParam(name, value, categoryStrMaxLength);
					} else if (name === 'ksgmnt') {
						url.addParam(name, value, true);
					} else {
						url.addParam(name, value);
					}
				}
			}
		}

		// global params
		url.addParam('src', src);
		url.addString('mtfIFPath=/extensions/wikia/AdEngine/;');
		url.addParam('mtfInline', 'true');	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220

		// per slot params
		url.addParam('pos', params.slotname);
		url.addParam('loc', params.loc);
		url.addParam('dcopt', params.dcopt);
		url.addParam('sz', size);

		// sync params
		url.addParam('tile', localTile);
		url.addString('endtag=$;');
		url.addString('ord=' + localOrd + '?');

		log(url.toString(), 5, logGroup);
		return url.toString();
	};

	return {
		getUrl: getUrl
	};
});
