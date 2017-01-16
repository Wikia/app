/*global describe, it, runs, waitsFor, expect, require, document*/
describe('viewportObserver', function () {
	'use strict';

	var testCases = [
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			elementMock: {
				offsetTop: 0, // px from the top
				offsetHeight: 200, // element height
				offsetParent: null
			},
			expected: true,
			desc: 'Window not scrolled, element on top'
		},
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			elementMock: {
				offsetTop: 0, // px from the top
				offsetHeight: 100, // element height
				offsetParent: null
			},
			expected: false,
			desc: 'Window not scrolled, element on top, but it is so small that is > 50% covered by top nav'
		},
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			elementMock: {
				offsetTop: 1005, // px from the top (1000 - 55) = 1005 + 100 / 2
				offsetHeight: 100, // element height
				offsetParent: null
			},
			expected: true,
			desc: 'Window not scrolled, element on top has big offset but fits in 50%'
		},
		{
			windowMock: {
				scrollY: 0,
				innerHeight: 1000
			},
			elementMock: {
				offsetTop: 1006, // px from the top
				offsetHeight: 100, // element height
				offsetParent: null
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
				offsetHeight: 100, // element height
				offsetParent: null
			},
			expected: false,
			desc: 'Window scrolled, element on top has big offset so is out of screen'
		}
	];

	testCases.forEach(function (testCase) {
			it('correctly states is element is in viewport: ' + testCase.desc, function() {
			var viewportObserver = modules['wikia.viewportObserver'](testCase.windowMock);

			expect(viewportObserver.isInViewport(testCase.elementMock)).toBe(testCase.expected);
		})
	});
});
