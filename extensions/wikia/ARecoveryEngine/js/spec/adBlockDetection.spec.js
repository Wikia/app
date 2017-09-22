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
			}
		};

	mocks.log.levels = {};

	function getModule() {
		return modules['ext.wikia.aRecoveryEngine.adBlockDetection'](
			mocks.adContext,
			null,
			null,
			mocks.lazyQueue,
			mocks.log,
			mocks.pageFair
		);
	}

	it('isBlocking is true when pageFairRecovery is enabled and SP detects blocking', function () {
		spyOn(mocks.pageFair, 'isBlocking');

		mocks.context.opts.pageFairRecovery = true;
		mocks.pageFair.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeTruthy();
	});

	it('isBlocking is false when pageFairRecovery is enabled, SP does not detect blocking', function () {
		spyOn(mocks.pageFair, 'isBlocking');

		mocks.context.opts.pageFairRecovery = true;
		mocks.pageFair.isBlocking.and.returnValue(false);

		expect(getModule().isBlocking()).toBeFalsy();
	});

	it('isBlocking is false when pageFairRecovery is disabled, SP detects blocking', function () {
		spyOn(mocks.pageFair, 'isBlocking');

		mocks.context.opts.pageFairRecovery = false;
		mocks.pageFair.isBlocking.and.returnValue(true);

		expect(getModule().isBlocking()).toBeFalsy();
	});
});
