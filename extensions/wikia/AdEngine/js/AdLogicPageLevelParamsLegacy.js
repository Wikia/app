/**
 * Extension of AdLogicPageLevelParams for Evolve
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
		getCustomKeyValues: getCustomKeyValues,
		getDomainKV: getDomainKV,
		getHostnamePrefix: getHostnamePrefix,
		getKruxKeyValues: getKruxKeyValues
	};
};
