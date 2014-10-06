/*global define*/
define('ext.wikia.adEngine.adLogicPageParamsLegacy', [
	'wikia.log',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adLogicPageParams',
	'ext.wikia.adEngine.krux',
	'ext.wikia.adEngine.dartUrl'
], function (log, adContext, adLogicPageParams, Krux, dartUrl) {
	'use strict';

	var pageParams = adLogicPageParams.getPageLevelParams({
		includeRawDbName: true
	});

	function getCustomKeyValues() {
		var wikiCustomKeyValues = adContext.getContext().targeting.wikiCustomKeyValues;

		if (wikiCustomKeyValues) {
			return dartUrl.trimParam(wikiCustomKeyValues + ';');
		}

		return '';
	}

	function getS1KeyValue() {
		return dartUrl.decorateParam('s1', pageParams.rawDbName);
	}

	function getEsrbKeyValue() {
		return dartUrl.decorateParam('esrb', pageParams.esrb);
	}

	function getDomainKV() {
		return dartUrl.decorateParam('dmn', pageParams.dmn);
	}

	function getHostnamePrefix() {
		return dartUrl.decorateParam('hostpre', pageParams.hostpre);
	}

	function getKruxKeyValues() {
		if (Krux && Krux.dartKeyValues) {
			return dartUrl.trimParam(Krux.dartKeyValues);
		}
		return '';
	}

	return {
		getCustomKeyValues: getCustomKeyValues,
		getEsrbKeyValue: getEsrbKeyValue,
		getS1KeyValue: getS1KeyValue,
		getDomainKV: getDomainKV,
		getHostnamePrefix: getHostnamePrefix,
		getKruxKeyValues: getKruxKeyValues
	};
});
