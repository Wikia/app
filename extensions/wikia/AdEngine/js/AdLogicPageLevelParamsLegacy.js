/**
 * Extension of AdLogicPageLevelParams for Legacy DART AdProviders
 */
var AdLogicPageLevelParamsLegacy = function (log, window, adLogicPageLevelParams, Krux, dartUrl) {
	'use strict';

	var logGroup = 'AdLogicPageLevelParamsLegacy',
		pageParams = adLogicPageLevelParams.getPageLevelParams(),
		getCustomKeyValues,
		getDomainKV,
		getHostnamePrefix,
		getKruxKeyValues;

	getCustomKeyValues = function () {
		if (window.wgDartCustomKeyValues) {
			return dartUrl.trimParam(window.wgDartCustomKeyValues + ';');
		}
		return '';
	};

	getDomainKV = function () {
		return dartUrl.decorateParam('dmn', pageParams.dmn);
	};

	getHostnamePrefix = function () {
		return dartUrl.decorateParam('hostpre', pageParams.hostpre);
	};

	getKruxKeyValues = function () {
		if (Krux && Krux.dartKeyValues) {
			return dartUrl.trimParam(Krux.dartKeyValues);
		}
		return '';
	};

	return {
		getCustomKeyValues: getCustomKeyValues, // Evolve, GamePro
		getDomainKV: getDomainKV,               // Evolve
		getHostnamePrefix: getHostnamePrefix,   // Evolve
		getKruxKeyValues: getKruxKeyValues      // Evolve
	};
};
