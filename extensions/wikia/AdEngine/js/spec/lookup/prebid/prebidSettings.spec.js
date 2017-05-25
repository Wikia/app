/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.prebidSettings', function () {
	'use strict';

	var mocks = {
			bidderResponse: {
				bidderCode: 'wikia',
				adId: '1209ab9b9660621',
				size: '728x90',
				cpm: 10
			},
			bidHelper: {
				transformPriceFromBid: function(bid) {
					return bid.cpm;
				}
			}
		},
		prebidSettings;

	function getPrebidSettings() {
		return modules['ext.wikia.adEngine.lookup.prebid.prebidSettings'](
			mocks.bidHelper
		);
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
			hb_bidder = getFunction(settings, 'hb_bidder'),
			actual = hb_bidder(mocks.bidderResponse);

		expect(actual).toEqual('wikia');
	});

	it('settings hb_adid function should retrieve ad id from bidder response', function () {
		var settings = prebidSettings.create(),
			hb_adid = getFunction(settings, 'hb_adid'),
			actual = hb_adid(mocks.bidderResponse);

		expect(actual).toEqual('1209ab9b9660621');
	});

	it('settings hb_size function should retrieve size from bidder response', function () {
		var settings = prebidSettings.create(),
			hb_size = getFunction(settings, 'hb_size'),
			actual = hb_size(mocks.bidderResponse);

		expect(actual).toEqual('728x90');
	});

	it('settings hb_pb function should retrive cpm fro bidder response', function () {
		var settings = prebidSettings.create(),
			hb_pb = getFunction(settings, 'hb_pb'),
			actual;

		actual = hb_pb(mocks.bidderResponse);

		expect(actual).toEqual(10);
	});
});
