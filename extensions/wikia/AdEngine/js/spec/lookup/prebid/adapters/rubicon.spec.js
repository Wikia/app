/*global beforeEach, describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', function () {
	'use strict';

	var mocks = {
		adContext: {
			get: function () {
				return true;
			}
		},
		context: {},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		log: function () {},
		babDetection: {
			isBlocking: function () {
				return false;
			}
		},
		adaptersHelper: {
			getTargeting: function () {
				return {
					pos: ['TOP_LEADERBOARD'],
					src: ['gpt'],
					s0: ['life'],
					s1: ['test'],
					s2: ['article'],
					lang: ['en']
				}
			}
		}
	};

	mocks.log.levels = {};

	function getBidder() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.rubicon'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.adaptersHelper,
			mocks.babDetection,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.context = {
			bidders: {
				rubicon: true
			},
			targeting: {
				wikiIsTop1000: true
			}
		};
	});

	it('Is disabled when context is disabled', function () {
		spyOn(mocks.adContext, 'get').and.returnValue(false);
		var rubicon = getBidder();

		expect(rubicon.isEnabled()).toBeFalsy();
	});

	it('Is enabled when context is enabled', function () {
		var rubicon = getBidder();

		expect(rubicon.isEnabled()).toBeTruthy();
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var bidder = getBidder();
		expect(bidder.prepareAdUnit('TOP_LEADERBOARD', {
			siteId: 55412,
			sizeId: 203,
			zoneId: 519058,
			position: 'atf'
		}, 'oasis')).toEqual({
			code: 'TOP_LEADERBOARD',
			mediaType: 'video',
			mediaTypes: {
				video: {
					playerSize: [640, 480]
				}
			},
			bids: [
				{
					bidder: 'rubicon',
					params: {
						accountId: '7450',
						siteId: 55412,
						zoneId: 519058,
						name: 'TOP_LEADERBOARD',
						position: 'atf',
						inventory: {
							pos: ['TOP_LEADERBOARD'],
							src: ['gpt'],
							s0: ['life'],
							s1: ['test'],
							s2: ['article'],
							lang: ['en']
						},
						video: {
							playerHeight: '480',
							playerWidth: '640',
							size_id: 203,
							language: 'en'
						}
					}
				}
			]
		});
	});
});
