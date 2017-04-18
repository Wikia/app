/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.aRecoveryEngine.adBlockDetection', function () {
	'use strict';

	function noop() {}

	var mocks = {
			log: noop,
			context: {
				opts: {},
				targeting: {
					skin: 'oasis'
				}
			},
			adContext: {
				addCallback: noop,
				getContext: function () {
					return mocks.context;
				}
			},
			lazyQueue: {
				makeQueue: noop
			},
			pageFair: {
				isBlocking: noop,
				isEnabled: noop
			},
			sourcePoint: {
				isBlocking: noop,
				isEnabled: noop
			}
		};

	mocks.log.levels = {};

	function getModule() {
		return modules['ext.wikia.aRecoveryEngine.adBlockDetection'](
			mocks.adContext,
			mocks.sourcePoint,
			null,
			null,
			mocks.lazyQueue,
			mocks.log,
			null,
			mocks.pageFair
		);
	}

	it('isBlocking is true when sourcePointDetection is enabled and PF is blocking', function () {
		spyOn(mocks.pageFair, 'isBlocking');

		mocks.context.opts.sourcePointDetection = true;
		mocks.pageFair.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeTruthy();
	});

	it('isBlocking is true when sourcePointDetection is enabled and SP is blocking', function () {
		spyOn(mocks.sourcePoint, 'isBlocking');

		mocks.context.opts.sourcePointDetection = true;
		mocks.sourcePoint.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeTruthy();
	});

	it('isBlocking is false when sourcePointDetection is enabled, SP is not blocking and PF is not blocking', function () {
		spyOn(mocks.sourcePoint, 'isBlocking');
		spyOn(mocks.pageFair, 'isBlocking');

		mocks.context.opts.sourcePointDetection = true;
		mocks.pageFair.isBlocking.and.returnValue(false);
		mocks.sourcePoint.isBlocking.and.returnValue(false);

		expect(getModule().isBlocking()).toBeFalsy();
	});

	it('isBlocking is false when sourcePointDetection is disabled and PF is blocking', function () {
		spyOn(mocks.sourcePoint, 'isBlocking');
		spyOn(mocks.pageFair, 'isBlocking');

		mocks.context.opts.sourcePointDetection = false;
		mocks.pageFair.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeFalsy();
	});
});
