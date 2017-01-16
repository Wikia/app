/*global beforeEach, describe, it, expect, modules*/
describe('wikia.domCalculator', function () {
	'use strict';

	var domCalculator;

	function getModule() {
		return modules['wikia.domCalculator']();
	}

	function getMockElement(offsetParent, offsetTop, frameElement) {
		var element = {
			offsetParent: offsetParent || null,
			offsetTop: offsetTop || 50,
			ownerDocument: {
				defaultView: {}
			}
		};

		if (frameElement) {
			element.ownerDocument.defaultView.frameElement = frameElement || null;
		}

		return element;
	}

	beforeEach(function () {
		domCalculator = getModule();
	});

	it('getTopOffset of single element', function () {
		var element = getMockElement();

		expect(domCalculator.getTopOffset(element)).toBe(50);
	});

	it('getTopOffset of nested element', function () {
		var parent = getMockElement(null, 100),
			element = getMockElement(parent);

		expect(domCalculator.getTopOffset(element)).toBe(150);
	});

	it('getTopOffset of nested iframe element', function () {
		var iframeParent = getMockElement(null, 30),
			iframe = getMockElement(iframeParent, 200),
			parent = getMockElement(null, 100),
			element = getMockElement(parent, 50, iframe);

		expect(domCalculator.getTopOffset(element)).toBe(380);
	});
});
