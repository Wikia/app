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
			null
		);
	}

	it('isBlocking is true when sourcePointDetection is enabled and SP detects blocking', function () {
		spyOn(mocks.sourcePoint, 'isBlocking');

		mocks.context.opts.sourcePointDetection = true;
		mocks.sourcePoint.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeTruthy();
	});

	it('isBlocking is false when sourcePointDetection is enabled, SP does not detect blocking', function () {
		spyOn(mocks.sourcePoint, 'isBlocking');

		mocks.context.opts.sourcePointDetection = true;
		mocks.sourcePoint.isBlocking.and.returnValue(false);

		expect(getModule().isBlocking()).toBeFalsy();
	});

	it('isBlocking is false when sourcePointDetection is disabled, SP detects blocking', function () {
		spyOn(mocks.sourcePoint, 'isBlocking');

		mocks.context.opts.sourcePointDetection = false;
		mocks.sourcePoint.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeFalsy();
	});
});
