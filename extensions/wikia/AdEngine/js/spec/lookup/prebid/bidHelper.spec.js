/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.bidHelper', function () {
	'use strict';

	var mocks = {
		bidHelper: {
			transformPriceFromCpm: function() {}
		}
	};


	function getModule() {
		return modules['ext.wikia.adEngine.lookup.prebid.bidHelper'](
			mocks.bidHelper
		);
	}

	it('transformPriceFromBid calls priceGranularityHelper with maxCpm: 20 by default', function () {
		var module = getModule();

		spyOn(mocks.bidHelper, 'transformPriceFromCpm');

		[
			{
				bidder: 'openx',
				cpm: 1.27
			},
			{
				bidder: 'aol',
				cpm: 3.11
			},
			{
				bidder: 'fan',
				cpm: 4.50
			}
		].forEach(function (bid) {

			module.transformPriceFromBid(bid);

			expect(mocks.bidHelper.transformPriceFromCpm).toHaveBeenCalledWith(bid.cpm, 20);
		});
	});

	it('should call priceGranularityHelper with maxCpm: 50 when bidder code in [appnexusAst, rubicon]', function () {
		var module = getModule();

		spyOn(mocks.bidHelper, 'transformPriceFromCpm');

		[
			{
				bidder: 'appnexusAst',
				cpm: 24.00
			},
			{
				bidder: 'rubicon',
				cpm: 52.00
			}
		].forEach(function (bid) {

			module.transformPriceFromBid(bid);

			expect(mocks.bidHelper.transformPriceFromCpm).toHaveBeenCalledWith(bid.cpm, 20);
		});
	});
});
