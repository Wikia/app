/*global describe, it, runs, waitsFor, expect, require, document*/
describe('viewportObserver', function () {
	'use strict';

	var docMock = {
		documentElement: {
			clientHeight: 0
		}
	},
	testCases = [
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			domCalculatorMock: {
				getTopOffset: function() {
					return 0; // px from the top
				}
			},
			elementMock: {
				offsetHeight: 200, // element height
				ownerDocument: {
					defaultView: {}
				}
			},
			expected: true,
			desc: 'Window not scrolled, element on top'
		},
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			domCalculatorMock: {
				getTopOffset: function() {
					return 0; // px from the top
				}
			},
			elementMock: {
				offsetHeight: 100, // element height
				ownerDocument: {
					defaultView: {}
				}
			},
			expected: false,
			desc: 'Window not scrolled, element on top, but it is so small that is > 50% covered by top nav'
		},
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			domCalculatorMock: {
				getTopOffset: function() {
					return 950; // px from the top
				}
			},
			elementMock: {
				offsetHeight: 100, // element height
				ownerDocument: {
					defaultView: {}
				}
			},
			expected: true,
			desc: 'Window not scrolled, element on top has big offset but fits in 50%'
		},
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			domCalculatorMock: {
				getTopOffset: function() {
					return 1006; // px from the top
				}
			},
			elementMock: {
				offsetHeight: 100, // element height
				ownerDocument: {
					defaultView: {}
				}
			},
			expected: false,
			desc: 'Window not scrolled, element on top has big offset so is out of screen'
		},
		{
			windowMock: {
				scrollY: 100,
				innerHeight: 1000
			},
			domCalculatorMock: {
				getTopOffset: function() {
					return 1106; // px from the top
				}
			},
			elementMock: {
				offsetHeight: 100, // element height
				ownerDocument: {
					defaultView: {}
				}
			},
			expected: false,
			desc: 'Window scrolled, element on top has big offset so is out of screen'
		}
	];

	testCases.forEach(function (testCase) {
			it('correctly states is element is in viewport: ' + testCase.desc, function() {
			var viewportObserver = modules['wikia.viewportObserver'](docMock, testCase.domCalculatorMock, null, testCase.windowMock);

			expect(viewportObserver._isInViewport(testCase.elementMock)).toBe(testCase.expected);
		})
	});
});
