/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/wikia/modules/cookies.js
 */

describe("Geo", function () {
	'use strict';

	// mock cookies
	document.cookies = 'wikia_beacon_id=mCizgIam7U; varnish-stat=/server/FRA/cache-f10-FRA/SESSION/; foo=bar';

	var cookies = define.getModule();

	it('registers AMD module', function() {
		expect(typeof cookies).toBe('object');

		expect(typeof cookies.get).toBe('function');
		expect(typeof cookies.set).toBe('function');
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
