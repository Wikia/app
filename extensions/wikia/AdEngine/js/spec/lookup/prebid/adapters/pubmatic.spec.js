/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.pubmatic', function () {
	'use strict';

	var mocks = {
		instantGlobals: {
			wgAdDriverPubMaticBidderCountries: ['PL']
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
		},
		log: function () {}
	};

	mocks.log.levels = {};

	function getPubMatic() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.pubmatic'](
			mocks.slotsContext,
			mocks.instartLogic,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	it('isEnabled checks whether user is not blocking ads', function () {
		var pubmatic = getPubMatic();
		spyOn(mocks.instartLogic, 'isBlocking').and.returnValue(false);
		spyOn(mocks.geo, 'isProperGeo').and.returnValue(true);

		expect(pubmatic.isEnabled()).toBeTruthy();
	});

	it('', function () {
		var pubmatic = getPubMatic(),
			isProperGeoSpy = spyOn(mocks.geo, 'isProperGeo');

		pubmatic.isEnabled();
		expect(isProperGeoSpy).toHaveBeenCalledWith(['PL']);
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
			sizes: [[728, 90], [970, 250]],
			bids: [
				{
					bidder: 'pubmatic',
					params: {
						adSlot: '/5441/TOP_LEADERBOARD_728x90@728x90',
						publisherId: 156260
					}
				},
				{
					bidder: 'pubmatic',
					params: {
						adSlot: '/5441/TOP_LEADERBOARD_970x250@970x250',
						publisherId: 156260
					}
				}
			]
		});
	});
});
