/*global define*/
define('ext.wikia.adEngine.adLogicHighValueCountry', ['wikia.window', 'wikia.instantGlobals'], function (window, globals) {
	'use strict';

	var highValueCountries,
		defaultHighValueCountries,
		isHighValueCountry,
		getMaxCallsToDART;

	// A copy of CommonSettings wgHighValueCountries
	defaultHighValueCountries = {
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

	highValueCountries = globals && globals.wgHighValueCountries ?  globals.wgHighValueCountries : defaultHighValueCountries;

	isHighValueCountry = function (country) {
		if (country && highValueCountries) {
			return !!highValueCountries[country.toUpperCase()];
		}
		return false;
	};

	getMaxCallsToDART = function (country) {
		if (country && highValueCountries) {
			return highValueCountries[country.toUpperCase()] || 0;
		}
		return false;
	};

	return {
		isHighValueCountry: isHighValueCountry,
		getMaxCallsToDART: getMaxCallsToDART
	};
});