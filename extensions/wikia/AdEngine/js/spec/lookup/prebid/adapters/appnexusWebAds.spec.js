/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds', function () {
	'use strict';

	var mocks = {
		instantGlobals: {
			wgAdDriverAppNexusWebAdsBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		log: function() {}
	};

	mocks.log.levels = {};

	function getAppNexusWebAds() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds'](
			mocks.slotsContext,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var appNexusWebAds = getAppNexusWebAds();
		appNexusWebAds.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var appNexusWebAds = getAppNexusWebAds();
		expect(appNexusWebAds.prepareAdUnit('INCONTENT_BOXAD_1', {
			sizes: [
				[300, 600],
				[300, 250],
				[120, 600],
				[160, 600]
			],
			placementId: '11283988'
		})).toEqual({
			code: 'INCONTENT_BOXAD_1',
			sizes: [[300, 600], [300, 250], [120, 600], [160, 600]],
			bids: [
				{
					bidder: 'appnexusWebAds',
					params: {
						placementId: '11283988'
					}
				}
			]
		});
	});
});
