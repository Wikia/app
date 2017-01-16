/*global beforeEach, describe, it, expect, modules*/
describe('wikia.domCalculator', function () {
	'use strict';

	var domCalculator;

	function getModule(windowParams) {
		var docMock = {
				documentElement: {
					clientHeight: 0
				}
			};

		return modules['wikia.domCalculator'](docMock, getMockWindow(windowParams));
	}

	function getMockElement(params, frameElement) {
		var offsetParent = null,
			offsetTop = 50,
			offsetHeight = 100;

		if (params) {
			offsetParent = params.offsetParent === undefined ? offsetParent : params.offsetParent;
			offsetTop = params.offsetTop === undefined ? offsetTop : params.offsetTop;
			offsetHeight = params.offsetHeight === undefined ? offsetHeight : params.offsetHeight;
		}

		return {
			offsetParent: offsetParent,
			offsetTop: offsetTop,
			offsetHeight: offsetHeight,
			ownerDocument:  {
				defaultView: {
					frameElement: frameElement || null
				}
			}
		};
	}

	function getMockWindow(params) {
		var scrollY = 0,
			innerHeight = 1000;

		if (params) {
			scrollY = params.scrollY === undefined ? scrollY : params.scrollY;
			innerHeight = params.innerHeight === undefined ? innerHeight : params.innerHeight;
		}

		return {
			scrollY: scrollY,
			innerHeight: innerHeight
		}
	}

	beforeEach(function () {
		domCalculator = getModule();
	});

	it('getTopOffset of single element', function () {
		var element = getMockElement();

		expect(domCalculator.getTopOffset(element)).toBe(50);
	});

	it('getTopOffset of nested element', function () {
		var parent = getMockElement({offsetTop: 100}),
			element = getMockElement({offsetParent: parent});

		expect(domCalculator.getTopOffset(element)).toBe(150);
	});

	it('getTopOffset of nested iframe element', function () {
		var iframeParent = getMockElement({offsetTop: 30}),
			iframe = getMockElement({offsetParent: iframeParent, offsetTop: 200}),
			parent = getMockElement({offsetTop: 100}),
			element = getMockElement({offsetParent: parent, offsetTop: 50}, iframe);

		expect(domCalculator.getTopOffset(element)).toBe(380);
	});

	var testCases = [
			{
				windowMock: {},
				elementMock: {
					offsetTop: 0, // px from the top
					offsetHeight: 200 // element height
				},
				expected: true,
				desc: 'Window not scrolled, element on top'
			},
			{
				windowMock: {},
				elementMock: {
					offsetTop: 0, // px from the top
					offsetHeight: 100 // element height
				},
				expected: false,
				desc: 'Window not scrolled, element on top, but it is so small that is > 50% covered by top nav'
			},
			{
				windowMock: {},
				elementMock: {
					offsetTop: 950, // px from the top
					offsetHeight: 100 // element height
				},
				expected: true,
				desc: 'Window not scrolled, element on top has big offset but fits in 50%'
			},
			{
				windowMock: {},
				elementMock: {
					offsetTop: 1006, // px from the top
					offsetHeight: 100 // element height
				},
				expected: false,
				desc: 'Window not scrolled, element on top has big offset so is out of screen'
			},
			{
				windowMock: {
					scrollY: 100,
					innerHeight: 1000
				},
				elementMock: {
					offsetTop: 1106, // px from the top
					offsetHeight: 100 // element height
				},
				expected: false,
				desc: 'Window scrolled, element on top has big offset so is out of screen'
			}
		];

	testCases.forEach(function (testCase) {
		it('correctly states is element is in viewport: ' + testCase.desc, function() {
			var domCalculator = getModule(testCase.windowMock);

			expect(domCalculator.isInViewport(getMockElement(testCase.elementMock))).toBe(testCase.expected);
		})
	});
});
