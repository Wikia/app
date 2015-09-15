/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.monetizationService.helper', function () {
	'use strict';

	var mocks, monetizationServiceHelper;

	function noop() {
		return;
	}

	function returnEmpty() {
		return {};
	}

	mocks = {
		geo: {
			getCountryCode: returnEmpty
		},
		scriptwriter: noop,
		tracker: {
			buildTrackingFunction: noop
		}
	};

	monetizationServiceHelper = modules['ext.wikia.adEngine.provider.monetizationService.helper'](
		jQuery,
		mocks.geo,
		mocks.scriptwriter,
		mocks.tracker
	);

	var testCasesGetMaxAds = [
		{height: 0, expect: 1},
		{height: 700, expect: 1},
		{height: 1500, expect: 1},
		{height: 1501, expect: 2},
		{height: 5000, expect: 2},
		{height: 5001, expect: 3},
		{height: 7000, expect: 3}
	];

	Object.keys(testCasesGetMaxAds).forEach(function (key) {
		it('Get maximum number of ads. Test: ' + key, function () {
			spyOn(jQuery.fn, 'height').and.returnValue(testCasesGetMaxAds[key].height);
			expect(monetizationServiceHelper.getMaxAds()).toEqual(testCasesGetMaxAds[key].expect);
		});
	});

	var testCasesGetCountryCode = [
		{countryCode: '', expect: 'ROW'},
		{countryCode: 'AU', expect: 'AU'},
		{countryCode: 'CA', expect: 'CA'},
		{countryCode: 'DE', expect: 'DE'},
		{countryCode: 'GB', expect: 'GB'},
		{countryCode: 'HK', expect: 'HK'},
		{countryCode: 'JP', expect: 'JP'},
		{countryCode: 'MX', expect: 'MX'},
		{countryCode: 'PL', expect: 'ROW'},
		{countryCode: 'ROW', expect: 'ROW'},
		{countryCode: 'RU', expect: 'RU'},
		{countryCode: 'TH', expect: 'ROW'},
		{countryCode: 'TW', expect: 'TW'},
		{countryCode: 'US', expect: 'US'}
	];

	Object.keys(testCasesGetCountryCode).forEach(function (key) {
		it('Get country code for the service. Test: ' + key, function () {
			spyOn(mocks.geo, 'getCountryCode').and.returnValue(testCasesGetCountryCode[key].countryCode);
			expect(monetizationServiceHelper.getCountryCode()).toEqual(testCasesGetCountryCode[key].expect);
		});
	});
});
