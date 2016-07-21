/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.openXBidder', function () {
	'use strict';
	function noop() {
	}

	var slotParams = {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						opts: mocks.opts,
						slots: noop,
						targeting: mocks.targeting
					};
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
				getShortSlotName: function(slotName) {
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
			openXHelper: {
				setSlots: function () {},
				getSlots: function() {
					return {
						TOP_LEADERBOARD: {
							sizes: ['728x90', '970x250']
						}
					}
				},
				setupSlots: function() {},
				getPagePath: function() {
					return '/5441/wka.life/_dragonball//article'
				},
				getSlotPath: function() {
					return 'wikia_gpt/5441/wka.life/_dragonball//article/gpt/TOP_LEADERBOARD'
				},
				isSlotSupported: function() {
					return true;
				}
			},
			doc: {
				node: {
					parentNode: {
						insertBefore: noop
					}
				},
				createElement: function () {
					return mocks.doc.node;
				},
				getElementsByTagName: function () {
					return [mocks.doc.node];
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
			tiers: [],
			win: {
				OX: {
					dfp_bidder: {
						getPriceMap: function() {
							return {
								'TOP_LEADERBOARD': {
									ad: '',
									price: 10,
									size: '728x90'
								}
							};
						}
					}
				}
			}
		},
		openXBidder;


	function getFactory() {
		return modules['ext.wikia.adEngine.lookup.lookupFactory'](
			mocks.adContext,
			mocks.adTracker,
			mocks.lazyQueue,
			mocks.log
		);
	}

	function getOpenXBidder() {
		return modules['ext.wikia.adEngine.lookup.openXBidder'](
			getFactory(),
			mocks.adSlot,
			mocks.openXHelper,
			mocks.doc,
			mocks.log,
			mocks.win
		);
	}

	beforeEach(function () {
		mocks.targeting = {
			pageType: 'article'
		};
		mocks.targeting.skin = 'oasis';
		slotParams = {};
		openXBidder = getOpenXBidder();
		openXBidder.call('oasis', function(){});
		spyOn(mocks.adTracker, 'track');
		mocks.win.OX_dfp_options.callback();

	});

	it('Check if OpenXDFPBidder paramas use expected vertical', function () {
		var openXDfpParams = mocks.win.OX_dfp_ads[0];
		expect(openXDfpParams[0]).toContain('wka.life');
	});

	it('Check if OpenXDFPBidder paramas use given sizes', function () {
		var openXDfpParams = mocks.win.OX_dfp_ads[0];
		expect(openXDfpParams[1][0]).toBe('728x90');
		expect(openXDfpParams[1][1]).toBe('970x250');
	});

	it('Check if OpenXDFPBidder paramas properly define slot name', function () {
		var openXDfpParams = mocks.win.OX_dfp_ads[0];
		expect(openXDfpParams[2]).toContain('TOP_LEADERBOARD');
	});

	it('Check if getSlotsParams works properly', function() {
		var params = openXBidder.getSlotParams('TOP_LEADERBOARD');
		expect(params.ox728x90).toEqual(10);
	});

	it('Check if getPrices work properly', function() {
		expect(mocks.adTracker.track.calls.argsFor(0)[1].TOP_LEADERBOARD).toBe(10);
	});

});
