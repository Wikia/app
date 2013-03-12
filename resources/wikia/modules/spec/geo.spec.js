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
	var cookieData = '{"city":"Poznan","country":"PL","continent":"EU"}',
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
});
