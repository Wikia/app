/*global define*/
define('ext.wikia.adEngine.adLogicHighValueCountry', ['wikia.window', 'wikia.instantGlobals'], function (window, globals) {
	'use strict';

	var highValueCountries,
		isHighValueCountry,
		getMaxCallsToDART;

	highValueCountries = globals && globals.wgHighValueCountries ?  globals.wgHighValueCountries : window.wgHighValueCountriesDefault;

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