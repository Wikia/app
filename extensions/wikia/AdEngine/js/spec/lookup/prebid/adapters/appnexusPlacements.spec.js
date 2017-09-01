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
			},
			opts: {
				premiumAdLayoutEnabled: false
			}
		},
		log: function() {}
	}, testCases = [
		{
			vertical: 'life',
			skin: 'mercury',
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'life',
			skin: 'oasis',
			pos: 'atf',
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'ent',
			skin: 'mercury',
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'other',
			skin: 'mercury',
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			pos: 'atf',
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			pos: 'btf',
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'ent',
			skin: 'oasis',
			pos: 'btf',
			isRecovering: false,
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'ent',
			skin: 'oasis',
			pos: 'atf',
			isRecovering: true,
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'life',
			skin: 'oasis',
			pos: 'hivi',
			isRecovering: true,
			expected: 'string',
			palEnabled: false
		}, {
			vertical: 'NOT EXISTING',
			skin: 'oasis',
			pos: 'btf',
			expected: 'undefined',
			palEnabled: false
		}, {
			skin: 'oasis',
			pos: 'atf',
			expected: 'string',
			palEnabled: true
		}
	];

	function getModule(vertical, palEnabled) {
		mocks.context.targeting.mappedVerticalName = vertical;
		mocks.context.opts.premiumAdLayoutEnabled = palEnabled;

		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements'](
			mocks.adContext,
			mocks.log
		);
	}

	testCases.forEach(function (testCase) {
		var testCaseName = [
				testCase.skin,
				testCase.palEnabled ? 'PAL' : 'non-PAL',
				testCase.palEnabled ? 'no-vertical' : testCase.vertical
			];

		it('returns expected placementId for ' + testCaseName.join(':'), function () {
			var appNexusPlacements = getModule(testCase.vertical, testCase.palEnabled),
				resultType = typeof appNexusPlacements.getPlacement(testCase.skin, testCase.pos, testCase.isRecovering);

			expect(resultType).toEqual(testCase.expected);
		});
	});
})
;
