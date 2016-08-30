/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.rubiconVulcan', function () {
	'use strict';
	function noop() {
	}

	var mocks = {
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
			doc: {
				node: {
					addEventListener: function (ignore, callback) {
						callback();
					},
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
			recoveryHelper: {
				addOnBlockingCallback: noop
			},
			rubiconTargeting: {
				getTargeting: function () {
					return {
						lang: 'en',
						passback: 'vulcan',
						s0: 'life',
						s1: '_dragonball',
						s2: 'article',
						src: 'gpt'
					};
				}
			},
			slot: {
				id: 'INCONTENT_LEADERBOARD',
				getBestCpm: function () {
					return {
						cpm: 16.2343446,
						status: 'ok',
						type: 'vast'
					};
				}
			},
			targeting: {
				skin: 'oasis'
			},
			tiers: [],
			win: {
				rubicontag: {
					video: {
						run: function (onResponse) {
							onResponse();
						},
						defineSlot: function () {
							return mocks.slot;
						},
						getAllSlots: function () {
							return [mocks.slot];
						}
					}

				}
			}
		};

	function getFactory() {
		return modules['ext.wikia.adEngine.lookup.lookupFactory'](
			mocks.adContext,
			mocks.adTracker,
			mocks.recoveryHelper,
			mocks.lazyQueue,
			mocks.log
		);
	}

	function getVulcan() {
		return modules['ext.wikia.adEngine.lookup.rubiconVulcan'](
			getFactory(),
			mocks.rubiconTargeting,
			modules['ext.wikia.adEngine.utils.math'](),
			mocks.doc,
			mocks.log,
			mocks.win
		);
	}
	
	function assertRequestParam(call, param) {
		expect(Object.keys(call).indexOf(param)).not.toEqual(-1);
	}

	beforeEach(function () {
	});

	it('Returns module name', function () {
		var vulcan = getVulcan();

		expect(vulcan.getName()).toEqual('rubicon_vulcan');
		expect(vulcan.wasCalled()).toBeFalsy();
	});

	it('Returns true when was called', function () {
		var vulcan = getVulcan();

		vulcan.call();

		expect(vulcan.wasCalled()).toBeTruthy();
	});

	it('Defines slot with rubiconTargeting params', function () {
		var defineSlotsCalls,
			vulcan = getVulcan();

		spyOn(mocks.win.rubicontag.video, 'defineSlot').and.callThrough();
		vulcan.call();
		defineSlotsCalls = mocks.win.rubicontag.video.defineSlot.calls;

		expect(defineSlotsCalls.count()).toEqual(1);
		expect(defineSlotsCalls.argsFor(0)[0]).toEqual('INCONTENT_LEADERBOARD');

		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'account_id');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'site_id');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'size_id');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'zone_id');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'width');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'height');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'rand');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.loc');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.lang');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.passback');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.s0');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.s1');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.s2');
		assertRequestParam(defineSlotsCalls.argsFor(0)[1], 'tg_i.src');
	});

	it('Returns proper tier format based on response', function () {
		var vulcan = getVulcan();

		vulcan.call();

		expect(vulcan.hasResponse()).toBeTruthy();
		expect(vulcan.getSlotParams('INCONTENT_LEADERBOARD')).toEqual({
			'rpfl_video': '203_tier1600'
		});
	});
});
