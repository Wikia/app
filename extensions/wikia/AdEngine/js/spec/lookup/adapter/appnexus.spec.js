describe('ext.wikia.adEngine.lookup.adapter.appnexus', function () {
	'use strict';

	function getAppNexus() {
		return modules['ext.wikia.adEngine.lookup.adapter.appnexus'](
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

	it('getAdUnits returns adUnits correctly', function() {
		var appNexus = getAppNexus();
		expect(appNexus.getAdUnits('oasis')).toEqual([
			{
				code: 'TOP_LEADERBOARD',
				sizes: [ [ 728, 90 ], [ 970, 250 ] ],
				bids: [
					{
						bidder: 'appnexus',
						params: {
							placementId: '5823300' }
					}
				]
			}, {
				code:
					'TOP_RIGHT_BOXAD',
				sizes: [ [ 300, 250 ], [ 300, 600 ] ],
				bids: [
					{
						bidder: 'appnexus',
						params: {
							placementId: '5823309'
						}
					}
				]
			}
		]);
	})

});
