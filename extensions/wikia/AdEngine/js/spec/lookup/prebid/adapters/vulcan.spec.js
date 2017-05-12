/*global describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.vulcan', function () {
	'use strict';

	var mocks = {
		instantGlobals: {
			wgAdDriverRubiconVulcanCountries: ['PL']
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
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.vulcan'](
			mocks.slotsContext,
			mocks.geo,
			mocks.instantGlobals,
			mocks.log
		);
	}

	it('isEnabled checks the countries instant global', function () {
		var indexExchange = getBidder();
		indexExchange.isEnabled();
		expect(mocks.geo.isProperGeo).toHaveBeenCalledWith(['PL']);
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var bidder = getBidder();
		expect(bidder.prepareAdUnit('TOP_LEADERBOARD', {
			sizes: [
				[640, 480]
			],
			siteId: 55412,
			zoneId: 519058,
			accountId: 7450,
			name: 'outstream-desktop',
			position: 'atf',
			video: 'foo'
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
						name: 'outstream-desktop',
						position: 'atf',
						video: 'foo'
					}
				}
			]
		});
	});
});
