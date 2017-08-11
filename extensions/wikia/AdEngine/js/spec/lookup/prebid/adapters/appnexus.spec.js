/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexus', function () {
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
		},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		log: function() {}
	};

	mocks.log.levels = {};

	function getAppNexus() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexus'](
			mocks.slotsContext,
			mocks.appNexusPlacements,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

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
						placementId: '123'
					}
				}
			]
		});
	});
});
