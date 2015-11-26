/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/geo.js
 */
/*global it, describe, expect, modules, window*/
describe('Geo', function () {
	'use strict';

	window.Wikia = {
		Cookies: {}
	};

	// mock geo cookie
	var cookieData = '{"city":"Poznan","country":"PL","continent":"EU","region":"72"}',
		cookieName = 'Geo',
		cookiesMock = {
			get: function (name) {
				expect(name).toBe(cookieName);
				return cookieData;
			}
		},
		geo = modules['wikia.geo'](cookiesMock);

	it('registers AMD module', function () {
		expect(typeof geo).toBe('object');

		expect(typeof geo.getGeoData).toBe('function');
		expect(typeof geo.getCountryCode).toBe('function');
		expect(typeof geo.getContinentCode).toBe('function');
	});

	it('getGeoData returns parsed data', function () {
		var geoData = geo.getGeoData();

		expect(typeof geoData).toBe('object');
		expect(geoData.city).toBe('Poznan');
	});

	it('returns country and continent code', function () {
		expect(geo.getCountryCode()).toBe('PL');
		expect(geo.getContinentCode()).toBe('EU');
	});

	it('returns region code', function () {
		expect(geo.getRegionCode()).toBe('72');
	});

	it('isProperGeo test', function () {
		expect(geo.isProperGeo()).toBeFalsy();

		// Region
		expect(geo.isProperGeo(['PL-72'])).toBeTruthy();
		expect(geo.isProperGeo(['ZZ', 'PL-72', 'non-PL-33'])).toBeTruthy();
		expect(geo.isProperGeo(['ZZ', 'PL-33'])).toBeFalsy();
		expect(geo.isProperGeo(['non-PL-72'])).toBeFalsy();
		expect(geo.isProperGeo(['ZZ', 'non-PL-72'])).toBeFalsy();
		expect(geo.isProperGeo(['ZZ', 'PL-72', 'non-PL-72'])).toBeFalsy();

		// Country
		expect(geo.isProperGeo(['PL'])).toBeTruthy();
		expect(geo.isProperGeo(['ZZ', 'PL', 'non-YY'])).toBeTruthy();
		expect(geo.isProperGeo(['ZZ', 'YY'])).toBeFalsy();
		expect(geo.isProperGeo(['non-PL'])).toBeFalsy();
		expect(geo.isProperGeo(['ZZ', 'non-PL'])).toBeFalsy();
		expect(geo.isProperGeo(['ZZ', 'PL', 'non-PL'])).toBeFalsy();

		// Continent
		expect(geo.isProperGeo(['XX-EU'])).toBeTruthy();
		expect(geo.isProperGeo(['XX-NA','XX-EU', 'non-XX-SA'])).toBeTruthy();
		expect(geo.isProperGeo(['XX-NA','XX-SA'])).toBeFalsy();
		expect(geo.isProperGeo(['XX-NA','XX-SA', 'non-XX-EU'])).toBeFalsy();
		expect(geo.isProperGeo(['XX-NA','XX-EU', 'non-XX-EU'])).toBeFalsy();
		expect(geo.isProperGeo(['non-XX-EU'])).toBeFalsy();

		// Earth
		expect(geo.isProperGeo(['XX'])).toBeTruthy();
		expect(geo.isProperGeo(['XX', 'non-PL-33'])).toBeTruthy();
		expect(geo.isProperGeo(['XX', 'non-PL-72'])).toBeFalsy();
		expect(geo.isProperGeo(['XX', 'non-DE'])).toBeTruthy();
		expect(geo.isProperGeo(['XX', 'non-PL'])).toBeFalsy();
		expect(geo.isProperGeo(['XX', 'non-XX-SA'])).toBeTruthy();
		expect(geo.isProperGeo(['XX', 'non-XX-EU'])).toBeFalsy();
	});
});
