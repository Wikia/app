/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.slot.service.actionHandler', function () {
	'use strict';

	function noop() {}

	var handler,
		mocks = {
			abTest: {
				getGroup: function () {
					return false;
				}
			},
			log: noop,
			messageListener: {
				callback: null,
				register: function (data, callback) {
					this.callback = callback;
				},
				sendFakeMessage: function (data) {
					this.callback(data);
				}
			},
			slotTweaker: {
				collapse: noop,
				expand: noop,
				hide: noop,
				makeResponsive: noop,
				show: noop
			},
			viewabilityHandler: {
				refreshOnView: noop
			}
		},
		testCasesForAvailableActions = [
			{
				action: 'collapse',
				api: mocks.slotTweaker,
				method: 'collapse'
			},
			{
				action: 'expand',
				api: mocks.slotTweaker,
				method: 'expand'
			},
			{
				action: 'hide',
				api: mocks.slotTweaker,
				method: 'hide'
			},
			{
				action: 'make-responsive',
				api: mocks.slotTweaker,
				method: 'makeResponsive'
			},
			{
				action: 'show',
				api: mocks.slotTweaker,
				method: 'show'
			},
			{
				action: 'refresh-on-view',
				api: mocks.viewabilityHandler,
				method: 'refreshOnView'
			}
		];

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.actionHandler'](
			mocks.messageListener,
			mocks.slotTweaker,
			mocks.viewabilityHandler,
			mocks.abTest,
			mocks.log
		);
	}

	beforeEach(function () {
		handler = getModule();
		mocks.log.levels = [];
		mocks.messageListener.callback = null;

		handler.registerMessageListener();
	});

	it('Does not call SlotTweaker::collapse when action is not defined', function () {
		spyOn(mocks.slotTweaker, 'collapse');

		mocks.messageListener.sendFakeMessage({
			slotName: 'TOP_LEADERBOARD'
		});

		expect(mocks.slotTweaker.collapse).not.toHaveBeenCalled();
	});

	it('Does not call SlotTweaker::collapse when slotName is not defined', function () {
		spyOn(mocks.slotTweaker, 'collapse');

		mocks.messageListener.sendFakeMessage({
			action: 'collapse'
		});

		expect(mocks.slotTweaker.collapse).not.toHaveBeenCalled();
	});

	testCasesForAvailableActions.forEach(function (testCase) {
		it('Calls action using messageListener', function () {
			spyOn(testCase.api, testCase.method);

			mocks.messageListener.sendFakeMessage({
				action: testCase.action,
				slotName: 'TOP_LEADERBOARD'
			});

			expect(testCase.api[testCase.method]).toHaveBeenCalled();
		});
	});
});
