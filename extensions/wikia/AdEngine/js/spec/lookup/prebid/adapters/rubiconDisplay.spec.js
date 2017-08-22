/*global beforeEach, describe, expect, it, jasmine, modules, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.rubiconDisplay', function () {
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
		instartLogic: {
			isBlocking: function() {
				return false;
			}
		},
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
		log: function () { }
	};

	mocks.log.levels = {};

	function getBidder() {
		return modules['ext.wikia.adEngine.lookup.prebid.adapters.rubiconDisplay'](
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
				rubiconDisplay: true
			},
			targeting: {
				wikiIsTop1000: true
			},
			opts: {}
		};
	});

	it('Is disabled when context is disabled', function () {
		mocks.context.bidders.rubiconDisplay = false;
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
			sizes: [[728, 90], [970, 250]],
			targeting: {loc: 'top'},
			position: 'atf',
			siteId: 41686,
			zoneId: 175094
		}, 'oasis')).toEqual({
			code: 'TOP_LEADERBOARD',
			sizes: [[728, 90], [970, 250]],
			bids: [
				{
					bidder: 'rubicon_display',
					params: {
						accountId: 7450,
						siteId: 41686,
						zoneId: 175094,
						name: 'TOP_LEADERBOARD',
						position: 'atf',
						keywords: ['rp.fastlane'],
						inventory: {
							loc: 'top',
							pos: 'TOP_LEADERBOARD',
							src: 'gpt',
							s0: 'life',
							s1: 'test',
							s2: 'article',
							lang: 'en'
						}
					}
				}
			]
		});
	});
});
