/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function () {}
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
		log: function () {}
	};

	mocks.log.levels = {};

	function getAppNexusWebAds() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusWebAds'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.babDetection,
			mocks.log
		);
	}

	it('enables bidder if flag is on and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
		expect(getAppNexusWebAds().isEnabled()).toBeTruthy();
	});

	it('disables bidder if flag is off and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		expect(getAppNexusWebAds().isEnabled()).toBeFalsy();
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
			mediaTypes: {
				banner: {
					sizes: [[300, 600], [300, 250], [120, 600], [160, 600]]
				}
			},
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
