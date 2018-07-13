/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexus', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function () {}
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
		babDetection: {
			isBlocking: function () {
				return false;
			}
		},
		log: function() {}
	};

	mocks.log.levels = {};

	function getAppNexus() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexus'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.appNexusPlacements,
			mocks.babDetection,
			mocks.log
		);
	}

	it('enables bidder if flag is on and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
		expect(getAppNexus().isEnabled()).toBeTruthy();
	});

	it('disables bidder if flag is off and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		expect(getAppNexus().isEnabled()).toBeFalsy();
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
			mediaTypes: {
				banner: {
					sizes: [[728, 90], [970, 250]]
				}
			},
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
