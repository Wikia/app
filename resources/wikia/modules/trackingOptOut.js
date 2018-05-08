/*global define*/
/**
 * AMD module checking tracking opt-out
 */
define('wikia.trackingOptOut', [
	'wikia.querystring'
], function(Querystring) {
	'use strict';

	var qs = new Querystring(),
		trackingBlacklist = {
			boolean: [
				'wgEnableKruxTargeting'
			],
			country: [
				'wgAdDriverKruxCountries',
				'wgAdDriverKikimoraPlayerTrackingCountries',
				'wgAdDriverKikimoraTrackingCountries',
				'wgAdDriverKikimoraViewabilityTrackingCountries'
			]
		};

	function isUrlParameterSet(parameter) {
		return !!parseInt(qs.getVal(parameter, '0'), 10);
	}

	function filterBlacklist(variables) {
		trackingBlacklist.boolean.forEach(function (variable) {
			variables[variable] = false;
		});

		trackingBlacklist.country.forEach(function (variable) {
			variables[variable] = [];
		});

		return variables;
	}

	function checkOptOut(variables) {
		if (isUrlParameterSet('trackingoptout')) {
			return filterBlacklist(variables);
		}

		return variables;
	}

	return {
		checkOptOut: checkOptOut
	};
});
