/*global describe, it, expect, modules*/
describe('ext.wikia.adEngine.slot.slotTargeting', function () {
	'use strict';

	function getModule(pageType, skin) {
		var adContext = {
			getContext: function() {
				return {
					targeting: {
						pageType: pageType,
						skin: skin
					}
				};
			}
		};

		return modules['ext.wikia.adEngine.slot.slotTargeting'](adContext);
	}

	it('Generate correct wikia slot id', function () {
		var testCases = [
			{
				env: {
					pageType: 'article',
					skin: 'oasis',
					src: 'remnant',
					slotName: 'TOP_RIGHT_BOXAD'
				},
				wsi: 'oma2'
			},
			{
				env: {},
				wsi: 'xxxx'
			},
			{
				env: {
					pageType: 'home'
				},
				wsi: 'xxhx'
			},
			{
				env: {
					pageType: 'article'
				},
				wsi: 'xxax'
			},
			{
				env: {
					pageType: 'undefined'
				},
				wsi: 'xxxx'
			},
			{
				env: {
					skin: 'oasis'
				},
				wsi: 'oxxx'
			},
			{
				env: {
					skin: 'mercury'
				},
				wsi: 'mxxx'
			},
			{
				env: {
					skin: 'undefined'
				},
				wsi: 'xxxx'
			},
			{
				env: {
					src: 'remnant'
				},
				wsi: 'xxx2'
			},
			{
				env: {
					src: 'gpt'
				},
				wsi: 'xxx1'
			},
			{
				env: {
					src: 'undefined'
				},
				wsi: 'xxxx'
			},
			{
				env: {
					slotName: 'HOME_TOP_LEADERBOARD'
				},
				wsi: 'xlxx'
			},
			{
				env: {
					slotName: 'CORP_TOP_RIGHT_BOXAD'
				},
				wsi: 'xmxx'
			},
			{
				env: {
					slotName: 'MOBILE_BOTTOM_LEADERBOARD'
				},
				wsi: 'xbxx'
			},
			{
				env: {
					slotName: 'undefined'
				},
				wsi: 'xxxx'
			}
		];

		testCases.forEach(function (testCase) {
			var slotTargeting = getModule(testCase.env.pageType, testCase.env.skin),
				wsi = slotTargeting.getWikiaSlotId(testCase.env.slotName, testCase.env.src);

			expect(wsi).toBe(testCase.wsi);
		});
	});

});
