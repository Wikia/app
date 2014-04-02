/**
 * Extension of AdLogicPageLevelParams for Evolve
 */
/*global define*/
define('ext.wikia.adEngine.adLogicPageParamsLegacy', [
	'wikia.log',
	'wikia.window',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.krux',
	'ext.wikia.adEngine.dartUrl'
], function (log, window, adLogicPageParams, Krux, dartUrl) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adLogicPageParamsLegacy',
		pageParams = adLogicPageParams.getPageLevelParams(),
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
});
