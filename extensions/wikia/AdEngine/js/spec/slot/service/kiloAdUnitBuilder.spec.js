/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.slot.service.kiloAdUnitBuilder', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			adContext: {
				getContext: function () {
					return {
						targeting: {
							wikiIsTop1000: true
						}
					};
				}
			},
			page: {
				getPageLevelParams: noop
			},
			browserDetect: {
				isMobile: noop
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.kiloAdUnitBuilder'](
			mocks.adContext,
			mocks.page
		);
	}

	function mockContext(param) {
		spyOn(mocks.adContext, 'getContext').and.returnValue(param);
	}

	function mockPageParams(params) {
		spyOn(mocks.page, 'getPageLevelParams');
		mocks.page.getPageLevelParams.and.returnValue(params);
	}

	it('Build ad unit', function () {
		mockPageParams({
			s0: 'life',
			s1: '_project43',
			s2: 'article',
			skin: 'desktop'
		});

		expect(getModule().build('TOP_LEADERBOARD', 'playwire'))
			.toEqual('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD');
	});

	it('Build non-1k wiki ad unit', function () {
		mockContext({
			targeting: {
				wikiIsTop1000: false
			}
		});

		mockPageParams({
			s0: 'games',
			s1: '_rimworld',
			s2: 'article',
			skin: 'desktop'
		});

		expect(getModule().build('TOP_LEADERBOARD', 'playwire'))
			.toEqual('/5441/wka.games/_not_a_top1k_wiki//article/playwire/TOP_LEADERBOARD');
	});

	it('getShortSlotName - should return last part of slotPath', function () {
		expect(getModule().getShortSlotName('long/slot/name/slotName')).toBe('slotName', 'Last part of slot name');
	});

	it('getShortSlotName - should keep slotName untouched if passed slotName is not a path', function () {
		expect(getModule().getShortSlotName('TOP_LEADERBOARD')).toBe('TOP_LEADERBOARD');
	});
});
