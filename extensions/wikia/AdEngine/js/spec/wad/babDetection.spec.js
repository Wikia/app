/*global describe, it, expect, modules, spyOn*/
describe('Module ext.wikia.adEngine.wad.babDetection', function () {
	'use strict';

	function getModule(mocks) {
		return modules['ext.wikia.adEngine.wad.babDetection'](
			mocks.adContext,
			mocks.document,
			mocks.lazyQueue,
			mocks.log,
			mocks.tracker,
			mocks.window
		);
	}

	function noop() { return noop; }

	function getMocks() {
		return {
			adContext: {
				get: function () {
					return true;
				}
			},
			document: {
				dispatchEvents: noop,
				dispatchEvent: noop,
				getElementsByTagName: noop,
				createEvent: function () {
					return {
						initEvent: noop()
					};
				}
			},
			lazyQueue: {
				makeQueue: function (callbacks) {
					callbacks.start = noop;
				}
			},
			log: noop,
			tracker: {
				track: noop()
			},
			window: {
				ads: {
					runtime: {}
				}
			}
		};
	}

	var mocks, babDetector;

	beforeEach(() => {
		mocks = getMocks();
		babDetector = getModule(mocks);
	});

	it('shoud dispatch event after run from external script', function () {
		spyOn(mocks.document, 'dispatchEvent');

		babDetector.initDetection(true);

		expect(mocks.document.dispatchEvent).toHaveBeenCalled();
	});

	it('should change runtime parameter', function () {
		spyOn(mocks.document, 'dispatchEvent');

		babDetector.initDetection(true);

		expect(mocks.window.ads.runtime.bab.blocking).toBe(true);

		babDetector.initDetection(false);

		expect(mocks.window.ads.runtime.bab.blocking).toBe(false);
	});
});
