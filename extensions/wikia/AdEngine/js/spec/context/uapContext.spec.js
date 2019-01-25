/*global beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.context.uapContext', function () {
	'use strict';

	function noop() {
	}

	var mocks = {
		adEngineBridge: {
			context: {
				onChange: noop
			},
			universalAdPackage: {
				isFanTakeoverLoaded: function () {
					return false;
				},
				getUapId: function () {
					return 'none';
				},
				reset: noop
			}
		},
		eventDispatcher: {
			dispatch: noop
		},
		log: noop
	};

	function getContext() {
		return modules['ext.wikia.adEngine.context.uapContext'](
			mocks.adEngineBridge,
			mocks.eventDispatcher,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.eventDispatcher.dispatch = noop;
	});

	it('getters', function () {
		var context = getContext();

		spyOn(mocks.adEngineBridge.universalAdPackage, 'getUapId').and.returnValue('123456');

		expect(context.getUapId()).toEqual('123456');
	});

	it('dispatch uap event when uap id set and event not dispatched yet', function () {
		var context = getContext();
		spyOn(mocks.eventDispatcher, 'dispatch');
		spyOn(mocks.adEngineBridge.universalAdPackage, 'isFanTakeoverLoaded').and.returnValue(true);

		context.dispatchEvent();

		expect(mocks.eventDispatcher.dispatch.calls.mostRecent().args[0]).toEqual('wikia.uap');
	});

	it('dispatch not_uap event when uap id not set and event not dispatched yet', function () {
		var context = getContext();
		spyOn(mocks.eventDispatcher, 'dispatch');

		context.dispatchEvent();

		expect(mocks.eventDispatcher.dispatch.calls.mostRecent().args[0]).toEqual('wikia.not_uap');
	});

	it('should dispatch event for leaderboard', function () {
		var context = getContext();

		expect(context.shouldDispatchEvent('TOP_LEADERBOARD')).toBeTruthy();
	});

	it('should not dispatch event for other slots', function () {
		var context = getContext();

		expect(context.shouldDispatchEvent('INVISIBLE_SKIN')).toBeFalsy();
		expect(context.shouldDispatchEvent('TOP_BOXAD')).toBeFalsy();
	});

	it('should dispatch event only once', function () {
		var context = getContext();

		expect(context.shouldDispatchEvent('MOBILE_TOP_LEADERBOARD')).toBeTruthy();
		context.dispatchEvent();
		expect(context.shouldDispatchEvent('MOBILE_TOP_LEADERBOARD')).toBeFalsy();
	});

	it('should dispatch not_uap event twice when reset was used', function () {
		var context = getContext();

		expect(context.shouldDispatchEvent('TOP_LEADERBOARD')).toBeTruthy();
		context.dispatchEvent();
		expect(context.shouldDispatchEvent('TOP_LEADERBOARD')).toBeFalsy();
		context.reset();
		expect(context.shouldDispatchEvent('TOP_LEADERBOARD')).toBeTruthy();
	});
});
