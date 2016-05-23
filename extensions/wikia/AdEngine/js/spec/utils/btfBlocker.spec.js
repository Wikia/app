/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.utils.btfBlocker', function () {
	'use strict';

	function noop () {}

	var mocks = {
		delayBtf: noop,
		skin: noop,
		btfSlotName: noop,
		atfSlotName: noop,
		adContext: {
			getContext: function () {
				return {
					opts: {
						delayBtf: mocks.delayBtf
					}
				};
			}
		},
		slotTweaker: {
			hide: noop
		},
		log: noop,
		win: {
			ads: {
				runtime: {
					disableBtf: noop
				}
			}
		},
		fillInSlot: noop
	};

	function getModule() {
		return modules['ext.wikia.adEngine.utils.btfBlocker'](
			mocks.adContext,
			mocks.slotTweaker,
			modules['wikia.lazyqueue'](),
			mocks.log,
			mocks.win
		);
	}

	beforeEach(function () {
		mocks.delayBtf = true;
		mocks.win.ads.runtime.disableBtf = true;
		mocks.skin = 'oasis';
		mocks.btfSlotName = 'BTF_SLOT_NAME';
		mocks.atfSlotName = 'TOP_LEADERBOARD';
	});

	it('Should call fillInSlot for BTF slot if delayBtf is false', function () {
		spyOn(mocks, 'fillInSlot');
		mocks.delayBtf = false;

		var btfBlocker = getModule();
		btfBlocker.init(mocks.skin, mocks.fillInSlot);
		btfBlocker.fillInSlotWithDelay({ name: mocks.btfSlotName });

		expect(mocks.fillInSlot.calls.mostRecent().args[0].name).toBe(mocks.btfSlotName);
	});

	it('Should call fillInSlot for ATF slot', function () {
		spyOn(mocks, 'fillInSlot');

		var btfBlocker = getModule();
		btfBlocker.init(mocks.skin, mocks.fillInSlot);
		btfBlocker.fillInSlotWithDelay({ name: mocks.atfSlotName });

		expect(mocks.fillInSlot.calls.mostRecent().args[0].name).toBe(mocks.atfSlotName);
	});

	it('Should not call fillInSlot for BTF slot', function () {
		spyOn(mocks, 'fillInSlot');

		var btfBlocker = getModule();
		btfBlocker.init(mocks.skin, mocks.fillInSlot);
		btfBlocker.fillInSlotWithDelay({ name: mocks.btfSlotName });

		expect(mocks.fillInSlot.calls.mostRecent()).not.toBeDefined();
	});

	it('Should disable BTF slot', function () {
		spyOn(mocks.slotTweaker, 'hide');

		var btfBlocker = getModule();
		btfBlocker.init(mocks.skin, mocks.fillInSlot);
		btfBlocker.fillInSlotWithDelay({ name: mocks.btfSlotName, success: noop });
		btfBlocker.fillInSlotWithDelay({ name: mocks.atfSlotName });
		btfBlocker.onSlotResponse(mocks.atfSlotName);

		expect(mocks.slotTweaker.hide.calls.mostRecent().args[0]).toBe(mocks.btfSlotName);
	});

	it('Should not disable BTF slot if disableBtf is false', function () {
		spyOn(mocks.slotTweaker, 'hide');
		spyOn(mocks, 'fillInSlot');
		mocks.win.ads.runtime.disableBtf = false;

		var btfBlocker = getModule();
		btfBlocker.init(mocks.skin, mocks.fillInSlot);
		btfBlocker.fillInSlotWithDelay({ name: mocks.btfSlotName, success: noop });
		btfBlocker.fillInSlotWithDelay({ name: mocks.atfSlotName });
		btfBlocker.onSlotResponse(mocks.atfSlotName);

		expect(mocks.slotTweaker.hide.calls.mostRecent()).not.toBeDefined();
		expect(mocks.fillInSlot.calls.mostRecent().args[0].name).toBe(mocks.btfSlotName);
	});
});
