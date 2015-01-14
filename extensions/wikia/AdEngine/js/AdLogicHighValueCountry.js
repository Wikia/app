/*global define*/
define('ext.wikia.adEngine.adLogicHighValueCountry', ['wikia.instantGlobals'], function (globals) {
	'use strict';

	var highValueCountries = globals.wgHighValueCountries || {
		'CA': 3,
		'DE': 3,
		'DK': 3,
		'ES': 3,
		'FI': 3,
		'FR': 3,
		'GB': 3,
		'IT': 3,
		'NL': 3,
		'NO': 3,
		'SE': 3,
		'UK': 3,
		'US': 3
	};

	function isHighValueCountry(country) {
		if (country && highValueCountries) {
			return !!highValueCountries[country.toUpperCase()];
		}
		return false;
	}

	function getMaxCallsToDART(country) {
		if (country && highValueCountries) {
			return highValueCountries[country.toUpperCase()] || 0;
		}
		return false;
	}

	return {
		isHighValueCountry: isHighValueCountry,
		getMaxCallsToDART: getMaxCallsToDART
	};
});
