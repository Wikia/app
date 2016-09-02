describe('ext.wikia.adEngine.lookup.prebid.adapters.indexExchange', function () {
	'use strict';

	function getIndexExchange() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.indexExchange'](
			mocks.geo,
			mocks.instantGlobals
		);
	}

	var mocks = {
		instantGlobals: {
			wgAdDriverIndexExchangeBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		}
	};

	it('isEnabled checks the countries instant global', function () {
		var indexExchange = getIndexExchange();
		indexExchange.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var appNexus = getIndexExchange();
		expect(appNexus.prepareAdUnit('TOP_LEADERBOARD', {
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
