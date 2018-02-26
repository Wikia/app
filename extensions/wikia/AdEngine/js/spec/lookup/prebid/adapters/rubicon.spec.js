/*global beforeEach, describe, expect, it, jasmine, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.rubicon', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		context: {},
		slotsContext: {
			filterSlotMap: function (map) {
				return map;
			}
		},
		log: function () {},
		adLogicZoneParams: {
			getLanguage: function () {
				return 'en';
			},
			getName: function () {
				return 'test';
			},
			getPageType: function () {
				return 'article';
			},
			getSite: function () {
				return 'life';
			}
		},
		instartLogic: {
			isBlocking: function() {
				return false;
			}
		}
	};

	mocks.log.levels = {};

	function getBidder() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.rubicon'](
			mocks.adContext,
			mocks.slotsContext,
			mocks.adLogicZoneParams,
			mocks.instartLogic,
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
		mocks.context.bidders.rubicon = false;
		var rubicon = getBidder();

		expect(rubicon.isEnabled()).toBeFalsy();
	});

	it('Is disabled when context is enabled but is blocking', function () {
		var rubicon = getBidder();
		spyOn(mocks.instartLogic, 'isBlocking').and.returnValue(true);

		expect(rubicon.isEnabled()).toBeFalsy();
	});

	it('Is enabled when context is enabled', function () {
		var rubicon = getBidder();

		expect(rubicon.isEnabled()).toBeTruthy();
	});

	it('prepareAdUnit returns data in correct shape', function () {
		var bidder = getBidder();
		expect(bidder.prepareAdUnit('TOP_LEADERBOARD', {
			zoneId: 519058,
			position: 'atf'
		}, 'oasis')).toEqual({
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
						inventory: {
							pos: 'TOP_LEADERBOARD',
							src: 'gpt',
							s0: 'life',
							s1: 'test',
							s2: 'article',
							lang: 'en'
						},
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
