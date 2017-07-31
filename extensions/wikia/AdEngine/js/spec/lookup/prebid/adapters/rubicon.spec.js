/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return {
					targeting: {
						hasFeaturedVideo: false
					}
				};
			}
		},
		instantGlobals: {
			wgAdDriverRubiconPrebidCountries: ['PL']
		},
		geo: {
			isProperGeo: jasmine.createSpy('isProperGeo')
		},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		log: function () {}
	};

	mocks.log.levels = {};

	function getBidder() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.rubicon'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var bidder = getBidder();
		bidder.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var bidder = getBidder();
		expect(bidder.prepareAdUnit('TOP_LEADERBOARD', {
			zoneId: 519058,
			position: 'atf'
		})).toEqual({
			code: 'TOP_LEADERBOARD',
			sizes: [
				[640, 480]
			],
			mediaType: 'video',
			bids: [
				{
					bidder: 'rubicon',
					params: {
						accountId: 7450,
						siteId: 55412,
						zoneId: 519058,
						name: 'TOP_LEADERBOARD',
						position: 'atf',
						video: {
							playerHeight: 480,
							playerWidth: 640,
							size_id: 203
						}
					}
				}
			]
		});
	});
});
