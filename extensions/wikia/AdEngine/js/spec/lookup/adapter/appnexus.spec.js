describe('ext.wikia.adEngine.lookup.adapter.appnexus', function () {
	'use strict';

	var mocks = {
		instantGlobals: {
			wgAdDriverAppNexusBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		},
		appNexusPlacements: {
			getPlacement: function () {
				return '123';
			}
		}
	};

	function getAppNexus() {
		return modules['ext.wikia.adEngine.lookup.adapter.appnexus'](
			mocks.geo,
			mocks.instantGlobals,
			mocks.appNexusPlacements
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var appNexus = getAppNexus();
		appNexus.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('getAdUnits returns adUnits correctly', function () {
		var appNexus = getAppNexus();
		expect(appNexus.getAdUnits('oasis')).toEqual([
			{
				code: 'TOP_LEADERBOARD',
				sizes: [[728, 90], [970, 250]],
				bids: [
					{
						bidder: 'appnexus',
						params: {
							placementId: '123'
						}
					}
				]
			}, {
				code: 'TOP_RIGHT_BOXAD',
				sizes: [[300, 250], [300, 600]],
				bids: [
					{
						bidder: 'appnexus',
						params: {
							placementId: '123'
						}
					}
				]
			}
		]);
	})

});
