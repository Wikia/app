/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/geo.js
 */

describe("Geo", function () {
	'use strict';

	window.Wikia = {
		Cookies: {}
	};

	// mock geo cookie
	var cookieData = '{"city":"Poznan","country":"PL","continent":"EU","region":"72"}',
		cookieName = 'Geo',
		cookiesMock = {
			get: function(name) {
				expect(name).toBe(cookieName);
				return cookieData;
			}
		},
		geo = modules['wikia.geo'](cookiesMock);

	it('registers AMD module', function() {
		expect(typeof geo).toBe('object');

		expect(typeof geo.getGeoData).toBe('function');
		expect(typeof geo.getCountryCode).toBe('function');
		expect(typeof geo.getContinentCode).toBe('function');
	});

	it('getGeoData returns parsed data', function() {
		var geoData = geo.getGeoData();

		expect(typeof geoData).toBe('object');
		expect(geoData.city).toBe('Poznan');
	});

	it('returns country and continent code', function() {
		expect(geo.getCountryCode()).toBe('PL');
		expect(geo.getContinentCode()).toBe('EU');
	});

	it('returns region code', function() {
		expect(geo.getRegionCode()).toBe('72');
	});

	it('isProperCountry test', function() {
		expect(geo.isProperCountry(['ZZ', 'PL'])).toBeTruthy();
		expect(geo.isProperCountry(['ZZ', 'YY'])).toBeFalsy();
	});

	it('isProperRegion test', function() {
		expect(geo.isProperRegion(['ZZ', 'PL-72'])).toBeTruthy();
		expect(geo.isProperRegion(['ZZ', 'PL-33'])).toBeFalsy();
	});

	it('isProperContinent test', function() {
		expect(geo.isProperContinent(['XX-NA','XX-EU'])).toBeTruthy();
		expect(geo.isProperContinent(['XX-NA','XX-SA'])).toBeFalsy();
	});

	it('isProperContinent test - any region (XX)', function() {
		expect(geo.isProperContinent(['XX'])).toBeTruthy();
	});

	it('isProperGeo test', function() {
		expect(geo.isProperGeo(['PL'])).toBeTruthy();
		expect(geo.isProperGeo(['XX-EU'])).toBeTruthy();
		expect(geo.isProperGeo(['XX'])).toBeTruthy();
		expect(geo.isProperGeo(['PL-72'])).toBeTruthy();

		expect(geo.isProperGeo()).toBeFalsy();
	});
});
