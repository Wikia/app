/*global define*/
/**
 * AMD module exporting Wikia.InstantGlobals object
 */
define('wikia.instantGlobals', [
	'wikia.querystring',
	'wikia.window'
], function(Querystring, window) {
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

	if (window.Wikia && window.Wikia.InstantGlobals) {
		if (isUrlParameterSet('disabletracking')) {
			return filterBlacklist(window.Wikia.InstantGlobals);
		}

		return window.Wikia.InstantGlobals;
	}

	return {};
});
