/*global define*/
define('ext.wikia.adEngine.wikiaDartMobileHelper', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.dartUrl'
], function (log, window, adLogicPageParams, dartUrl) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.wikiaDartMobileHelper',
		features = window.Features || {},
		ord = Math.round(Math.random() * 23456787654),
		tile = 0,
		categoryStrMaxLength = 300,
		experiments,
		experimentsNumber,
		i,
		ab = [];

	if (window.Wikia && window.Wikia.AbTest) {
		experiments = window.Wikia.AbTest.getExperiments();
		experimentsNumber = experiments.length;

		for (i = 0; i < experimentsNumber; i += 1) {
			ab.push(experiments[i].id + '_' + experiments[i].group.id);
		}
	}

	function getMobileUrl(params) {
		var slotname = params.slotname,
			pageParams = adLogicPageParams.getPageLevelParams(),
			url = dartUrl.urlBuilder(
				'ad.mo.doubleclick.net',
				'DARTProxy/mobile.handler?k=wka.' + pageParams.s0 + '/' + pageParams.s1 + '/' + pageParams.s2
			),
			name,
			value;

		log(['getMobileUrl', slotname], 5, logGroup);

		tile += 1;

		// per page params
		for (name in pageParams) {
			if (pageParams.hasOwnProperty(name)) {
				value = pageParams[name];
				if (value) {
					if (name === 'cat') {
						url.addParam(name, value, categoryStrMaxLength);
					} else {
						url.addParam(name, value);
					}
				}
			}
		}

		// global params
		url.addParam('positionfixed', features.positionfixed ? 'css' : 'js');
		url.addParam('src', 'mobile');
		url.addString('mtfIFPath=/extensions/wikia/AdEngine/;');
		url.addParam('mtfInline', 'true');	// http://www.google.com/support/richmedia/bin/answer.py?hl=en&answer=182220

		// per slot params
		url.addParam('pos', params.slotname);
		url.addParam('loc', params.loc);
		url.addParam('dcopt', params.dcopt);
		url.addParam('sz', params.size);
		url.addParam('ab', ab);

		// sync params
		url.addParam('tile', tile);
		url.addString('ord=' + ord + '?');

		url = url.toString() + '&csit=1&dw=1&u=' + params.uniqueId;

		log(['getMobileUrl', url], 5, logGroup);

		return url;
	}

	return {
		/**
		 * Get URL for a mobile ad
		 *
		 * @param params (slotname, size, uniqueId)
		 * @return {String} URL of DART script
		 */
		getMobileUrl: getMobileUrl
	};
});
