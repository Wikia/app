/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.prebid', function () {
	'use strict';

	var insertBefore = jasmine.createSpy('insertBefore'),
		mocks = {
			adContext: {
				get: function () {
					return false;
				},
				getContext: function () {
					return {
						opts: mocks.opts,
						slots: noop,
						targeting: mocks.targeting
					};
				}
			},
			uapContext: {
				isFanTakeoverLoaded: function () {
					return false;
				}
			},
			tracker: {
				measureDiff: function () {
					return mocks.tracker;
				},
				track: noop
			},
			adTracker: {
				measureTime: function () {
					return mocks.tracker;
				},
				track: noop
			},
			adSlot: {
				getShortSlotName: function (slotName) {
					return slotName;
				}
			},
			adLogicZoneParams: {
				getSite: function () {
					return 'life';
				},
				getName: function () {
					return '_dragonball';
				},
				getPageType: function () {
					return 'article';
				},
				getLanguage: function () {
					return 'en';
				}
			},
			lazyQueue: {
				makeQueue: function (queue, callback) {
					queue.push = function () {
						callback();
					};
					queue.start = noop;
				}
			},
			log: noop,
			bidResponses: {
				TOP_LEADERBOARD: {
					bids: [
						{
							bidder: 'bidder_1',
							cpm: 10,
							timeToRespond: 200,
							adserverTargeting: {
								hb_bidder: 'bidder_1'
							}
						},
						{
							bidder: 'bidder_2',
							cpm: 15,
							timeToRespond: 100,
							adserverTargeting: {
								hb_bidder: 'bidder_2'
							}
						}
					]
				}
			},
			win: {
				addEventListener: noop,
				pbjs: {
					que: [],
					requestBids: function () {
					},
					getBidResponsesForAdUnitCode: function (slotName) {
						return mocks.bidResponses[slotName];
					}
				}
			},
			trackingOptIn: {
				pushToUserConsentQueue: function (cb) {
					cb(true);
				}
			},
			adaptersPricesTracker: {},
			adaptersPriorities: {
				bidder_1: 1,
				bidder_2: 0
			},
			adaptersRegistry: {
				setupCustomAdapters: noop,
				registerAliases: noop,
				getPriorities: function () {
					return mocks.adaptersPriorities;
				}
			},
			prebidHelper: {
				setupAdUnits: function () {
					return [
						{
							code: 'TOP_LEADERBOARD',
							sizes: [
								[728, 90],
								[970, 250]
							],
							placementId: '5823300'
						},
						{
							code: 'TOP_RIGHT_BOXAD',
							sizes: [
								[300, 250],
								[300, 600]
							],
							placementId: '5823309'
						}
					];
				}
			},
			prebidSettings: {
				create: noop
			},
			adaptersPerformanceTracker: {
				setupPerformanceMap: noop
			}
		},
		prebid;

	function noop() {}
	mocks.log.levels = {};

	function getFactory() {
		return modules['ext.wikia.adEngine.lookup.lookupFactory'](
			mocks.adContext,
			mocks.adTracker,
			mocks.lazyQueue,
			mocks.log
		);
	}

	function getPrebid() {
		return modules['ext.wikia.adEngine.lookup.prebid'](
			mocks.adContext,
			mocks.uapContext,
			mocks.adaptersPerformanceTracker,
			mocks.adaptersPricesTracker,
			mocks.adaptersRegistry,
			mocks.prebidHelper,
			mocks.prebidSettings,
			getFactory(),
			mocks.log,
			mocks.trackingOptIn,
			mocks.win
		);
	}

	beforeEach(function () {
		mocks.targeting = {
			pageType: 'article'
		};
		mocks.targeting.skin = 'oasis';
		prebid = getPrebid();
		spyOn(mocks.adTracker, 'track');
		spyOn(mocks.win.pbjs.que, 'push');

		mocks.log.levels = {};
	});

	it('Ad slots are pushed', function () {
		prebid.call('oasis', function () {});
		expect(mocks.win.pbjs.que.push).toHaveBeenCalled();
	});

	it('Prebid auction is performed and the best bid is returned', function () {
		prebid.call();
		expect(prebid.getSlotParams('TOP_LEADERBOARD').hb_bidder).toEqual('bidder_2');
		mocks.bidResponses.TOP_LEADERBOARD.bids[1].cpm = 10;
		expect(prebid.getSlotParams('TOP_LEADERBOARD').hb_bidder).toEqual('bidder_1');
		mocks.adaptersPriorities.bidder_2 = 1;
		expect(prebid.getSlotParams('TOP_LEADERBOARD').hb_bidder).toEqual('bidder_2');
	});
});
