/*global define*/
define('ext.wikia.adEngine.evolveHelper', [
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.krux',
	'ext.wikia.adEngine.dartUrl'
], function (log, adContext, adLogicPageParams, Krux, dartUrl) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.evolveHelper',
		pageParams = adLogicPageParams.getPageLevelParams({
			includeRawDbName: true
		});

	function getSect() {
		log('getSect', 5, logGroup);

		var context = adContext.getContext(),
			kv = context.targeting.wikiCustomKeyValues || '',
			vertical = context.targeting.wikiVertical || '',
			sect;

		if (context.targeting.wikiDbName === 'wikiaglobal') {
			sect = 'home';
			if (context.targeting.pageName === 'Video_Games') {
				sect = 'gaming';
			}
			if (context.targeting.pageName === 'Entertainment') {
				sect = 'entertainment';
			}
		} else if (kv.indexOf('movie') !== -1) {
			sect = 'movies';
		} else if (kv.indexOf('tv') !== -1) {
			sect = 'tv';
		} else if (vertical === 'Entertainment') {
			sect = 'entertainment';
		} else if (vertical === 'Gaming') {
			sect = 'gaming';
		} else {
			sect = 'ros';
		}

		log(sect, 7, logGroup);
		return sect;
	}

	function getCustomKeyValues() {
		var wikiCustomKeyValues = adContext.getContext().targeting.wikiCustomKeyValues;

		if (wikiCustomKeyValues) {
			return dartUrl.trimParam(wikiCustomKeyValues + ';');
		}

		return '';
	}

	function getKruxKeyValues() {
		if (Krux && Krux.dartKeyValues) {
			return dartUrl.trimParam(Krux.dartKeyValues);
		}
		return '';
	}

	function getTargeting() {
		var i, decorated, additionalParams = getCustomKeyValues() + getKruxKeyValues(),
			params = {
				s1: pageParams.rawDbName,
				esrb: pageParams.esrb,
				dmn: pageParams.dmn,
				hostpre: pageParams.hostpre,
				lang: pageParams.lang
			}, result = [];

		for (i in params) {
			if (params.hasOwnProperty(i)) {
				decorated = dartUrl.decorateParam(i, params[i]);
				if (decorated) {
					result[result.length] = decorated;
				}
			}
		}

		if (additionalParams) {
			result[result.length] = additionalParams;
		}

		return result.join('');
	}

	return {
		getSect: getSect,
		getTargeting: getTargeting
	};
});
