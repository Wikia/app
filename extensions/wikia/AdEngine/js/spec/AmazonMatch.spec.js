describe('Method ext.wikia.adEngine.lookupServices', function () {
	'use strict';

	it('filters out correct amazon slots', function () {
		var amazonMatch = modules['ext.wikia.adEngine.amazonMatch'](
				{}, // ext.wikia.adEngine.adTracker mock
				{}, // wikia.document mock
				function () { return; }, // wikia.log mock
				{} // wikia.window mock
			),
			testCases = [
				{input: [], expected: []},
				{input: ['a1x6p14'], expected: ['a1x6p14']},
				{input: ['a1x6p14', 'a1x6p3', 'a1x6p12'], expected: ['a1x6p3']},
				{
					input: ['a1x6p14', 'a1x6p3', 'a7x9p12', 'a7x9p4', 'a7x9p14', 'a3x2p5', 'a3x2p8', 'a3x2p6'],
					expected: ['a1x6p3', 'a7x9p4', 'a3x2p5']
				},
				{input: ['invalid-input'], expected: []},
			];

		Object.keys(testCases).forEach(function (k) {
			var testCase = testCases[k];
			expect(amazonMatch.filterSlots(testCase.input)).toEqual(testCase.expected);
		});
	});
});
