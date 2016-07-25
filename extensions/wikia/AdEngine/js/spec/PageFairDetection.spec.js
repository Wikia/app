/*global describe, it, expect, modules, spyOn*/
describe('Module ext.wikia.adEngine.pageFairDetection', function () {
	'use strict';

	function getModule(mocks) {
		return modules['ext.wikia.adEngine.pageFairDetection'](
				mocks.adContext,
				mocks.scriptLoader,
				mocks.document,
				mocks.log,
				mocks.window
		);
	}

	function noop() { return noop }

	function getContext() {
		return {
			opts: {
				pageFairDetection: true
			},
			targeting: {
				skin: 'oasis'
			}
		}
	}

	function getMocks() {
		return {
			adContext: {
				getContext: getContext
			},
			scriptLoader: {
				loadAsync: noop
			},
			document: {
				dispatchEvents: noop,
				dispatchEvent: noop,
				getElementsByTagName: noop
			},
			log: noop,
			window: {
				ads: {
					runtime: {}
				}
			},
		};
	}

	it('shoud dispatch event after run pf_notify from external script', function () {
		var mocks = getMocks();
		var pageFairDetector = getModule(mocks);
		pageFairDetector.initDetection();

		spyOn(mocks.document, 'dispatchEvent');
		mocks.window.pf_notify(true);

		expect(mocks.document.dispatchEvent).toHaveBeenCalled();
	});

	it('should change runtime parameter', function () {
		var mocks = getMocks();
		var pageFairDetector = getModule(mocks);
		pageFairDetector.initDetection();

		spyOn(mocks.document, 'dispatchEvent');
		mocks.window.pf_notify(true);
		expect(mocks.window.ads.runtime.pf.blocking).toBe(true);

		mocks.window.pf_notify(false);
		expect(mocks.window.ads.runtime.pf.blocking).toBe(false);
	});

	it('should not run detection when pagefair is not enabled', function () {
		var mocks = getMocks();
		mocks.adContext.getContext = function () {
			var context = getContext();
			context.opts.pageFairDetection = false;
			return context;
		};
		var pageFairDetector = getModule(mocks);
		pageFairDetector.initDetection();

		spyOn(mocks.document, 'dispatchEvent');
		mocks.window.pf_notify(true);

		expect(mocks.document.dispatchEvent).not.toHaveBeenCalled();
	});

});
