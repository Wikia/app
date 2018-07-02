/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.indexExchange', function () {
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

	function getIndexExchange() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.indexExchange'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.babDetection
		);
	}

	it('enables bidder if flag is on and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
		expect(getIndexExchange().isEnabled()).toBeTruthy();
	});

	it('disables bidder if flag is off and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		expect(getIndexExchange().isEnabled()).toBeFalsy();
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var indexExchange = getIndexExchange();
		expect(indexExchange.prepareAdUnit('TOP_LEADERBOARD', {
			sizes: [
				[728, 90],
				[970, 250]
			],
			siteId: 183423
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			mediaTypes: {
				banner: {
					sizes: [[728, 90], [970, 250]]
				}
			},
			bids: [
				{
					bidder: 'indexExchange',
					params: {
						siteId: '183423',
						size: [728, 90]
					}
				},
				{
					bidder: 'indexExchange',
					params: {
						siteId: '183423',
						size: [970, 250]
					}
				}
			]
		});
	});
});
