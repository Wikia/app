/*global describe, expect, it, modules*/
describe('ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements', function () {
	'use strict';

	var mocks = {
		adContext: {
			getContext: function () {
				return mocks.context;
			}
		},
		context: {
			targeting: {
				mappedVerticalName: ''
			}
		},
		log: function() {}
	}, testCases = [
		{
			vertical: 'life',
			skin: 'mercury',
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'atf',
			expected: 'string'
		}, {
			vertical: 'ent',
			skin: 'mercury',
			expected: 'string'
		}, {
			vertical: 'other',
			skin: 'mercury',
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'atf',
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'btf',
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'btf',
			isRecovering: false,
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'atf',
			isRecovering: true,
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'hivi',
			isRecovering: true,
			expected: 'string'
		}, {
			skin: 'oasis',
			pos: 'atf',
			expected: 'string'
		}
	];

	function getModule(vertical) {
		mocks.context.targeting.mappedVerticalName = vertical;

		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements'](
			mocks.adContext,
			mocks.log
		);
	}

	testCases.forEach(function (testCase) {
		var testCaseName = [
				testCase.skin,
				testCase.vertical ? testCase.vertical : 'no-vertical'
		];

		it('returns expected placementId for ' + testCaseName.join(':'), function () {
			var appNexusPlacements = getModule(testCase.vertical),
				resultType = typeof appNexusPlacements.getPlacement(testCase.skin, testCase.pos, testCase.isRecovering);

			expect(resultType).toEqual(testCase.expected);
		});
	});
})
;
