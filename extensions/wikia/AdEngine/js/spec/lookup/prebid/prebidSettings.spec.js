/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.prebidSettings', function () {
	'use strict';

	var mocks = {
			bidderResponse: {
				bidderCode: 'wikia',
				adId: '1209ab9b9660621',
				size: '728x90',
				cpm: 0
			}
		},
		prebidSettings;

	function getPrebidSettings() {
		return modules['ext.wikia.adEngine.lookup.prebid.prebidSettings']();
	}

	beforeEach(function () {
		prebidSettings = getPrebidSettings();
	});

	function getFunction(settings, key) {
		var targeting = settings.standard.adserverTargeting,
			result;

		for (var i = 0; i < targeting.length && !result; i++) {
			var element = targeting[i];

			if (element.key === key) {
				result = element.val;
			}
		}

		return result;
	}

	it('settings hb_bidder function should retrieve bidder code from bidder response', function () {
		var settings = prebidSettings.create(),
			hb_bidder = getFunction(settings, 'hb_bidder');

		var actual = hb_bidder(mocks.bidderResponse);

		expect(actual).toEqual('wikia');
	});

	it('settings hb_adid function should retrieve ad id from bidder response', function () {
		var settings = prebidSettings.create(),
			hb_adid = getFunction(settings, 'hb_adid');

		var actual = hb_adid(mocks.bidderResponse);

		expect(actual).toEqual('1209ab9b9660621');
	});

	it('settings hb_size function should retrieve size from bidder response', function () {
		var settings = prebidSettings.create(),
			hb_size = getFunction(settings, 'hb_size');

		var actual = hb_size(mocks.bidderResponse);

		expect(actual).toEqual('728x90');
	});

	var cpms = [
		// test 0 -> 0.00
		{actual: 0, expected: '0.00'},
		// test <0.01, 0.05) -> increment 0.01
		{actual: 0.01, expected: '0.01'},
		{actual: 0.02, expected: '0.01'},
		{actual: 0.03, expected: '0.01'},
		{actual: 0.04, expected: '0.01'},
		// test <0.05, 5.00) -> increment 0.05
		{actual: 0.05, expected: '0.05'},
		{actual: 0.06, expected: '0.05'},
		{actual: 0.11, expected: '0.10'},
		{actual: 4.99, expected: '4.95'},
		// test <5.00, 10.00) -> increment 0.10
		{actual: 5.00, expected: '5.00'},
		{actual: 5.01, expected: '5.00'},
		{actual: 5.11, expected: '5.10'},
		{actual: 9.99, expected: '9.90'},
		// test <10.00, 20.00) -> increment 0.5
		{actual: 10.00, expected: '10.00'},
		{actual: 10.01, expected: '10.00'},
		{actual: 10.51, expected: '10.50'},
		{actual: 11.21, expected: '11.00'},
		{actual: 19.99, expected: '19.50'},
		// test <20.00, infinity) -> return 20.00
		{actual: 20.00, expected: '20.00'},
		{actual: 100.00, expected: '20.00'}
	];

	cpms.forEach(function (cpm) {
		it('settings hb_pb function should transform ' + cpm.actual + ' cpm from bidder response to ' + cpm.expected, function () {
			var settings = prebidSettings.create(),
				hb_pb = getFunction(settings, 'hb_pb');

			mocks.bidderResponse.cpm = cpm.actual;
			var actual = hb_pb(mocks.bidderResponse);

			expect(actual).toEqual(cpm.expected);
		});
	});
});
