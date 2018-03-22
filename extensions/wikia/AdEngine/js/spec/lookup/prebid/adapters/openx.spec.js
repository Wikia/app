/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.openx', function () {
	'use strict';

	var mocks = {
		instantGlobals: {
			wgAdDriverOpenXPrebidBidderCountries: ['PL']
		},
		geo: {
			isProperGeo: function() {
			}
		},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		instartLogic: {
			isBlocking: function() {
				return false;
			}
		}
	};

	function getOpenx() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.openx'](
			mocks.slotsContext,
			mocks.instartLogic,
			mocks.geo,
			mocks.instantGlobals
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var openx = getOpenx(),
			isProperGeoSpy = spyOn(mocks.geo, 'isProperGeo');

		openx.isEnabled();
		expect(isProperGeoSpy).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var openx = getOpenx();
		expect(openx.prepareAdUnit('TOP_LEADERBOARD', {
			sizes: [
				[728, 90],
				[970, 250]
			],
			unit: 123
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			sizes: [[728, 90], [970, 250]],
			bids: [
				{
					bidder: 'openx',
					params: {
						unit: 123,
						delDomain: 'wikia-d.openx.net'
					}
				}
			]
		});
	});
});
