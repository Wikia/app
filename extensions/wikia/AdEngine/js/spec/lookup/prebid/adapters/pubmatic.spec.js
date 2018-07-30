/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.pubmatic', function () {
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

	function getPubMatic() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.pubmatic'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.babDetection,
			mocks.log
		);
	}

	it('enables bidder if flag is on and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(true);
		expect(getPubMatic().isEnabled()).toBeTruthy();
	});

	it('disables bidder if flag is off and user is not blocking ads', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		expect(getPubMatic().isEnabled()).toBeFalsy();
	});

	it('isEnabled checks the countries instant global', function () {
		var pubmatic = getPubMatic();
		expect(pubmatic.prepareAdUnit('TOP_LEADERBOARD', {
			sizes: [
				[728, 90],
				[970, 250]
			],
			ids: [
				'/5441/TOP_LEADERBOARD_728x90@728x90',
				'/5441/TOP_LEADERBOARD_970x250@970x250'
			]
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			mediaTypes: {
				banner: {
					sizes: [[728, 90], [970, 250]]
				}
			},
			bids: [
				{
					bidder: 'pubmatic',
					params: {
						adSlot: '/5441/TOP_LEADERBOARD_728x90@728x90',
						publisherId: '156260'
					}
				},
				{
					bidder: 'pubmatic',
					params: {
						adSlot: '/5441/TOP_LEADERBOARD_970x250@970x250',
						publisherId: '156260'
					}
				}
			]
		});
	});
});
