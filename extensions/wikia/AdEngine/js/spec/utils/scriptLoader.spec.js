/*global describe, it, expect, modules, spyOn*/
describe('Module ext.wikia.adEngine.utils.scriptLoader', function () {
	'use strict';

	function getModule(mocks) {
		return modules['ext.wikia.adEngine.utils.scriptLoader'](
			mocks.adContext,
			mocks.adTracker,
			mocks.document,
			mocks.log,
			mocks.window
		);
	}

	function noop() { return noop }

	function getMocks() {
		return {
			adContext: {},
			adTracker: {},
			document: {
				createElement: function () {
					return {};
				}
			},
			log: noop()
		};
	}

	it('should add parameters to created node', function () {
		var scriptLoader = getModule(getMocks());

		var node = {
			parentNode: {
				insertBefore: noop
			}
		};

		var result = scriptLoader.loadScript('TEST_SRC', node, 'TEST_TYPE', true);

		expect(result.src).toBe('TEST_SRC');
		expect(result.type).toBe('TEST_TYPE');
	})

});
