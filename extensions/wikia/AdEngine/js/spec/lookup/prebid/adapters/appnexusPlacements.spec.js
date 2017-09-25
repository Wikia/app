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
				premiumAdLayoutEnabled: true,
				premiumAdLayoutAppNexusTagsEnabled: false
			}
		},
		log: function() {}
	}, testCases = [
		{
			vertical: 'life',
			skin: 'mercury',
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'life',
			skin: 'oasis',
			pos: 'atf',
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'ent',
			skin: 'mercury',
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'other',
			skin: 'mercury',
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			pos: 'atf',
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'gaming',
			skin: 'oasis',
			pos: 'btf',
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'ent',
			skin: 'oasis',
			pos: 'btf',
			isRecovering: false,
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'ent',
			skin: 'oasis',
			pos: 'atf',
			isRecovering: true,
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'life',
			skin: 'oasis',
			pos: 'hivi',
			isRecovering: true,
			expected: 'string',
			ANpalEnabled: false
		}, {
			vertical: 'NOT EXISTING',
			skin: 'oasis',
			pos: 'btf',
			expected: 'undefined',
			ANpalEnabled: false
		}, {
			skin: 'oasis',
			pos: 'atf',
			expected: 'string',
			ANpalEnabled: true
		}
	];

	function getModule(vertical, ANpalEnabled) {
		mocks.context.targeting.mappedVerticalName = vertical;
		mocks.context.opts.premiumAdLayoutAppNexusTagsEnabled = ANpalEnabled;

		return modules['ext.wikia.adEngine.lookup.prebid.adapters.appnexusPlacements'](
			mocks.adContext,
			mocks.log
		);
	}

	testCases.forEach(function (testCase) {
		var testCaseName = [
				testCase.skin,
				testCase.ANpalEnabled ? 'PAL' : 'non-PAL',
				testCase.ANpalEnabled ? 'no-vertical' : testCase.vertical
			];

		it('returns expected placementId for ' + testCaseName.join(':'), function () {
			var appNexusPlacements = getModule(testCase.vertical, testCase.ANpalEnabled),
				resultType = typeof appNexusPlacements.getPlacement(testCase.skin, testCase.pos, testCase.isRecovering);

			expect(resultType).toEqual(testCase.expected);
		});
	});
})
;
