/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.slot.highImpact', function () {
	'use strict';

	var mocks = {
		context: {},
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		slotTweaker: {},
		window: {
			adslots2: []
		}
	};

	beforeEach(function () {
		mocks.context.slots = {};
		mocks.window.adslots2 = [];
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.highImpact'](
			mocks.adContext,
			mocks.slotTweaker,
			mocks.window
		);
	}

	it('Do not call slot when it is disabled', function () {
		var highImpact = getModule();

		highImpact.init();

		expect(mocks.window.adslots2.length).toEqual(0);
	});

	it('Call slot when it is disabled', function () {
		var highImpact = getModule();
		mocks.context.slots.invisibleHighImpact2 = true;

		highImpact.init();

		expect(mocks.window.adslots2.length).toEqual(1);
		expect(mocks.window.adslots2[0].slotName).toEqual('INVISIBLE_HIGH_IMPACT_2');
	});
});
