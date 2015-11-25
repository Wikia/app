/*global beforeEach, describe, it, modules, expect, spyOn*/
describe('ext.wikia.adEngine.lookup.rubiconFastlane', function () {
	'use strict';
	function noop() {}

	var mocks = {
			adContext: {
				getContext: function () {
					return {
						targeting: {
							pageType: 'article'
						}
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
			adLogicZoneParams: {
				getSite: function () {
					return 'life';
				},
				getMappedVertical: function () {
					return '_dragonball';
				},
				getPageType: function () {
					return 'article';
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
			log: noop,
			slot: {
				setPosition: noop,
				getAdServerTargeting: function () {
					return [{
						key: 'rpflKey',
						values: ['1_tier', '3_tier']
					}];
				}
			},
			win: {
				rubicontag: {
					cmd: [],
					run: function (onResponse) {
						onResponse();
					},
					defineSlot: function () {
						return mocks.slot;
					}
				}
			}
		};

	function getRubiconFastlane() {
		return modules['ext.wikia.adEngine.lookup.rubiconFastlane'](
			mocks.adContext,
			mocks.adTracker,
			mocks.adLogicZoneParams,
			mocks.doc,
			mocks.log,
			mocks.win
		);
	}

	beforeEach(function () {
		mocks.win.rubicontag.cmd.push = function (callback) {
			callback();
		};
	});

	it('Returns falsy status without initialise', function () {
		var rubiconFastlane = getRubiconFastlane();

		expect(rubiconFastlane.wasCalled()).toBeFalsy();
	});

	it('Returns truthy status after initialise', function () {
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('oasis');

		expect(rubiconFastlane.wasCalled()).toBeTruthy();
	});

	it('Define all 7 slots for oasis skin', function () {
		spyOn(mocks.win.rubicontag, 'defineSlot').and.callThrough();
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('oasis');

		expect(mocks.win.rubicontag.defineSlot.calls.count()).toEqual(7);
	});

	it('Define all 3 slots for mercury skin', function () {
		spyOn(mocks.win.rubicontag, 'defineSlot').and.callThrough();
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('mercury');

		expect(mocks.win.rubicontag.defineSlot.calls.count()).toEqual(3);
	});

	it('Define /TOP/ slot as atf', function () {
		spyOn(mocks.slot, 'setPosition');
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('oasis');

		expect(mocks.slot.setPosition.calls.argsFor(0)[0]).toEqual('atf');
	});

	it('Define not-/TOP/ slot as btf', function () {
		spyOn(mocks.slot, 'setPosition');
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('oasis');

		expect(mocks.slot.setPosition.calls.argsFor(2)[0]).toEqual('btf');
	});

	it('Do not define position on mobile', function () {
		spyOn(mocks.slot, 'setPosition');
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('mercury');

		expect(mocks.slot.setPosition).not.toHaveBeenCalled();
	});

	it('Returns empty parameters list on not defined slot', function () {
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('mercury');

		expect(rubiconFastlane.getSlotParams('TOP_LEADERBOARD')).toEqual({});
	});

	it('Returns parameters list on defined slot', function () {
		var rubiconFastlane = getRubiconFastlane();

		rubiconFastlane.call('mercury');

		expect(rubiconFastlane.getSlotParams('MOBILE_TOP_LEADERBOARD')).toEqual({
			rpflKey: ['1_tier', '3_tier']
		});
	});
});
