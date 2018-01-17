/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.btfBlocker', function () {
	'use strict';

	function noop() {}

	var mocks = {
		log: noop,
		context: {
			opts: {},
			slots: {}
		},
		fillInSlot: noop,
		adContext: {
			addCallback: noop,
			getContext: function () {
				return mocks.context;
			}
		},
		methodCalledInsideFillInSlot: noop,
		uapContext: {
			isUapLoaded: function () {
				return false;
			},
			isRoadblockLoaded: function () {
				return false;
			}
		},
		win: {
			addEventListener: noop
		}
	};

	mocks.log.levels = {info: 'info', debug: 'debug'};
	beforeEach(function () {
		mocks.context.opts.delayBtf = true;
		spyOn(mocks, 'methodCalledInsideFillInSlot');
	});

	function getBtfBlocker() {
		return modules['ext.wikia.adEngine.provider.btfBlocker'](
			mocks.adContext,
			mocks.uapContext,
			modules['wikia.lazyqueue'](),
			mocks.log,
			mocks.win
		);
	}

	function getFakeProvider() {
		return {
			config: {
				atfSlots: [
					'ATF_SLOT'
				],
				highlyViewableSlots: [
					'HIVI_BTF_SLOT',
					'INVISIBLE_HIGH_IMPACT_2'
				]
			},
			fillInSlot: function (slot) {
				mocks.methodCalledInsideFillInSlot();
				slot.success();
			}
		};
	}

	function getFakeSlot(slotName) {
		var slot = {
			name: slotName,
			callback: noop,
			collapse: noop,
			success: function () {
				this.callback();
			},
			pre: function (result, callback) {
				this.callback = callback;
			}
		};

		spyOn(slot, 'success').and.callThrough();
		spyOn(slot, 'collapse');

		return slot;
	}

	it('Do not change fillInSlot method when delayBtf is disabled', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			slot = getFakeSlot('BTF_SLOT'),
			fakeFillInSlot = function (slot) {
				slot.success();
			};
		mocks.context.opts.delayBtf = false;

		fillInSlot = btfBlocker.decorate(fakeFillInSlot);
		fillInSlot(slot);

		expect(slot.success).toHaveBeenCalled();
	});

	it('Process with ATF slot immediately', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			fakeProvider = getFakeProvider(),
			slot = getFakeSlot('ATF_SLOT');

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(slot);

		expect(slot.success).toHaveBeenCalled();
	});

	it('Postpone process of BTF slot when there is no response from ATF', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			fakeProvider = getFakeProvider(),
			slot = getFakeSlot('BTF_SLOT');

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(slot);

		expect(slot.success).not.toHaveBeenCalled();
	});

	it('Process BTF slots when all ATF slots respond', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			fakeProvider = getFakeProvider();

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(getFakeSlot('ATF_SLOT'));
		fillInSlot(getFakeSlot('BTF_SLOT'));

		expect(mocks.methodCalledInsideFillInSlot.calls.count()).toEqual(2);
	});

	it('Collapse BTF slot when BTF is disabled', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			btfSlot = getFakeSlot('BTF_SLOT'),
			fakeProvider = getFakeProvider();

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(getFakeSlot('ATF_SLOT'));
		mocks.win.ads.runtime.disableBtf = true;
		fillInSlot(btfSlot);

		expect(mocks.methodCalledInsideFillInSlot.calls.count()).toEqual(1);
		expect(btfSlot.collapse).toHaveBeenCalled();
	});

	it('Process BTF slot when BTF is disabled but slot is unblocked', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			fakeProvider = getFakeProvider();

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(getFakeSlot('ATF_SLOT'));
		mocks.win.ads.runtime.disableBtf = true;
		btfBlocker.unblock('BTF_SLOT');
		fillInSlot(getFakeSlot('BTF_SLOT'));

		expect(mocks.methodCalledInsideFillInSlot.calls.count()).toEqual(2);
	});

	it('Process HIVI BTF slot when BTF is disabled and unblocking HIVI slots is enabled', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			btfSlot = getFakeSlot('BTF_SLOT'),
			fakeProvider = getFakeProvider();

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(getFakeSlot('ATF_SLOT'));
		mocks.win.ads.runtime.disableBtf = true;
		mocks.win.ads.runtime.unblockHighlyViewableSlots = true;
		fillInSlot(getFakeSlot('HIVI_BTF_SLOT'));
		fillInSlot(btfSlot);

		expect(mocks.methodCalledInsideFillInSlot.calls.count()).toEqual(2);
		expect(btfSlot.collapse).toHaveBeenCalled();
	});

	it('Do fill INVISIBLE_HIGH_IMPACT_2 slot when no UAP on page', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			btfSlot = getFakeSlot('BTF_SLOT'),
			fakeProvider = getFakeProvider();

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(getFakeSlot('ATF_SLOT'));
		mocks.win.ads.runtime.disableBtf = true;
		mocks.win.ads.runtime.unblockHighlyViewableSlots = true;
		fillInSlot(getFakeSlot('HIVI_BTF_SLOT'));
		fillInSlot(btfSlot);
		fillInSlot(getFakeSlot('INVISIBLE_HIGH_IMPACT_2'));
		fillInSlot(btfSlot);

		expect(mocks.methodCalledInsideFillInSlot.calls.count()).toEqual(3);
		expect(btfSlot.collapse).toHaveBeenCalled();
	});

	it('Do not fill INVISIBLE_HIGH_IMPACT_2 slot when UAP on page', function () {
		var fillInSlot,
			btfBlocker = getBtfBlocker(),
			btfSlot = getFakeSlot('BTF_SLOT'),
			fakeProvider = getFakeProvider();

		fillInSlot = btfBlocker.decorate(fakeProvider.fillInSlot, fakeProvider.config);
		fillInSlot(getFakeSlot('ATF_SLOT'));
		mocks.win.ads.runtime.disableBtf = true;
		mocks.win.ads.runtime.unblockHighlyViewableSlots = true;
		spyOn(mocks.uapContext, 'isUapLoaded').and.returnValue(true);
		fillInSlot(getFakeSlot('HIVI_BTF_SLOT'));
		fillInSlot(btfSlot);
		fillInSlot(getFakeSlot('INVISIBLE_HIGH_IMPACT_2'));
		fillInSlot(btfSlot);

		expect(mocks.methodCalledInsideFillInSlot.calls.count()).toEqual(2);
		expect(btfSlot.collapse).toHaveBeenCalled();
	});
});
