/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.indexExchange', function () {
	'use strict';

	var mocks = {
		instantGlobals: {
			wgAdDriverIndexExchangeBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		}
	};

	function getIndexExchange() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.indexExchange'](
			mocks.slotsContext,
			mocks.geo,
			mocks.instantGlobals
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var indexExchange = getIndexExchange();
		indexExchange.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var indexExchange = getIndexExchange();
		expect(indexExchange.prepareAdUnit('TOP_LEADERBOARD', {
			sizes: [
				[728, 90],
				[970, 250]
			],
			id: '1',
			siteID: 183423
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			sizes: [[728, 90], [970, 250]],
			bids: [
				{
					bidder: 'indexExchange',
					params: {
						id: '1',
						siteID: 183423
					}
				}
			]
		});
	});
});
