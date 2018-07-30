/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.openx', function () {
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
		}
	};

	function getOpenx() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.openx'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.babDetection
		);
	}

	it('enables bidder if flag is on and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
		expect(getOpenx().isEnabled()).toBeTruthy();
	});

	it('disables bidder if flag is off and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		expect(getOpenx().isEnabled()).toBeFalsy();
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
			mediaTypes: {
				banner: {
					sizes: [[728, 90], [970, 250]]
				}
			},
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
