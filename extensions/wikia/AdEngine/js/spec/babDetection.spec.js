/*global describe, it, expect, modules, spyOn*/
describe('Module ext.wikia.adEngine.babDetection', function () {
	'use strict';

	function getModule(mocks) {
		return modules['ext.wikia.adEngine.babDetection'](
			mocks.document,
			mocks.log,
			mocks.window
		);
	}

	function noop() { return noop; }

	function getMocks() {
		return {
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
			log: noop,
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
