describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexus', function () {
	'use strict';

	function getAppNexus() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexus'](
			mocks.geo,
			mocks.instantGlobals
		);
	}

	var mocks = {
		instantGlobals: {
			wgAdDriverAppNexusBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		}
	};

	it('isEnabled checks the countries instant global', function () {
		var appNexus = getAppNexus();
		appNexus.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var appNexus = getAppNexus();
		expect(appNexus.prepareAdUnit('TOP_LEADERBOARD', {
			sizes: [
				[728, 90],
				[970, 250]
			],
			placementId: '5823300'
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			sizes: [[728, 90], [970, 250]],
			bids: [
				{
					bidder: 'appnexus',
					params: {
						placementId: '5823300'
					}
				}
			]
		});
	});
});
