/*global define*/
define('ext.wikia.adEngine.adLogicHighValueCountry', ['wikia.instantGlobals'], function (globals) {
	'use strict';

	var highValueCountries = globals.wgHighValueCountries || {
		'CA': true,
		'DE': true,
		'DK': true,
		'ES': true,
		'FI': true,
		'FR': true,
		'GB': true,
		'IT': true,
		'NL': true,
		'NO': true,
		'SE': true,
		'UK': true,
		'US': true
	};

	function isHighValueCountry(country) {
		return !!(country && highValueCountries && highValueCountries[country.toUpperCase()]);
	}

	return {
		isHighValueCountry: isHighValueCountry
	};
});
