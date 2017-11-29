/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.slot.service.megaAdUnitBuilder', function () {
	'use strict';

	var DEFAULT_PAGE_PARAMS = {
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'oasis'
		},
		noop = function () {},
		mocks = {
			page: {
				getPageLevelParams: noop
			},
			browserDetect: {
				isMobile: noop
			},
			adContext: {
				addCallback: noop,
				getContext: noop
			},
			slotsContext: {
				isApplicable: noop
			}
		},
		testCases = [
			{
				slotName: 'TOP_RIGHT_BOXAD',
				adUnit: '/5441/wka2a.MR/top_right_boxad/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'MOBILE_PREFOOTER',
				adUnit: '/5441/wka2a.PF/mobile_prefooter/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'TOP_LEADERBOARD',
				adUnit: '/5441/wka2a.LB/top_leaderboard/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'INVISIBLE_HIGH_IMPACT_2',
				adUnit: '/5441/wka2a.PX/invisible_high_impact_2/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'INVISIBLE_HIGH_IMPACT',
				adUnit: '/5441/wka2a.PX/invisible_high_impact/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'INVISIBLE_SKIN',
				adUnit: '/5441/wka2a.PX/invisible_skin/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'INVISIBLE_SKIN',
				adUnit: '/5441/wka2a.PX/invisible_skin/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'NOT_SUPPORTED',
				adUnit: '/5441/wka2a.OTHER/not_supported/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'BOTTOM_LEADERBOARD',
				adUnit: '/5441/wka2a.PF/bottom_leaderboard/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'INCONTENT_PLAYER',
				adUnit: '/5441/wka2a.OTHER/incontent_player/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'BOTTOM_LEADERBOARD',
				adUnit: '/5441/wka2a.PF/bottom_leaderboard/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'FEATURED',
				adUnit: '/5441/wka2a.VIDEO/featured/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'OOYALA',
				adUnit: '/5441/wka2a.VIDEO/ooyala/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'UAP_BFAA',
				adUnit: '/5441/wka2a.VIDEO/uap_bfaa/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'ABCD',
				adUnit: '/5441/wka2a.VIDEO/abcd/tablet/oasis-home/_godofwar-gaming'
			}
		],
		testCasesForValidation = [
			{
				adUnit: '/5441/wka2a.PX/invisible_skin/tablet/oasis-home/_godofwar-gaming',
				valid: true
			},
			{
				adUnit: '/5441/wka1a.MR/top_right_boxad/tablet/oasis-home/_godofwar-gaming',
				valid: true
			},
			{
				adUnit: 'TOP_RIGHT_BOXAD',
				valid: false
			},
			{
				adUnit: '/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD',
				valid: false
			}
		];

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.megaAdUnitBuilder'](
			mocks.adContext,
			mocks.page,
			mocks.slotsContext,
			mocks.browserDetect
		);
	}

	function mockPageParams(params) {
		spyOn(mocks.page, 'getPageLevelParams');
		mocks.page.getPageLevelParams.and.returnValue(params);
	}

	function mockTargeting(isTop1000) {
		spyOn(mocks.adContext, 'getContext');
		mocks.adContext.getContext.and.returnValue({targeting: {
			wikiIsTop1000: isTop1000
		}});
	}

	it('Should build new ad unit', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'mercury'
		});
		mockTargeting(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2a.PF/mobile_prefooter/smartphone/mercury-home/_godofwar-gaming');
	});

	it('Should build new ad unit with correct tablet recognition', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockTargeting(true);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2a.PF/mobile_prefooter/tablet/oasis-home/_godofwar-gaming');
	});

	it('Should build new ad unit with featured video', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'fv-article',
			'skin': 'mercury'
		});
		mockTargeting(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2a.PF/mobile_prefooter/smartphone/mercury-fv-article/_godofwar-gaming');
	});

	it('Should build new ad unit with featured video', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'fv-article',
			'skin': 'oasis'
		});
		mockTargeting(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2a.PF/mobile_prefooter/desktop/oasis-fv-article/_godofwar-gaming');
	});

	it('Should build new ad unit with IC info', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'article',
			'skin': 'oasis'
		});
		mockTargeting(true);
		spyOn(mocks.slotsContext, 'isApplicable').and.returnValue(true);

		expect(getModule().build('TOP_LEADERBOARD', 'gpt')).toContain('/oasis-article-ic/');
	});

	it('Should build new ad unit with FV and IC info', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'fv-article',
			'skin': 'oasis'
		});
		mockTargeting(true);
		spyOn(mocks.slotsContext, 'isApplicable').and.returnValue(true);

		expect(getModule().build('TOP_LEADERBOARD', 'gpt')).toContain('/oasis-fv-article-ic/');
	});

	it('Should build new ad unit for wiki not in top 1000', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockTargeting(false);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2a.PF/mobile_prefooter/tablet/oasis-home/_not_a_top1k_wiki-gaming');
	});

	it('Should build new ad unit non-remnant provider with wka1a', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockTargeting(true);

		expect(getModule().build('TOP_LEADERBOARD', 'gpt'))
			.toEqual('/5441/wka1a.LB/top_leaderboard/desktop/oasis-home/_godofwar-gaming');
	});

	it('Should build new ad unit without device if its special page', function () {
		mockPageParams({
			's0': 'life',
			's1': '_lego',
			's2': 'special',
			'skin': 'oasis'
		});
		mockTargeting(true);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2a.PF/mobile_prefooter/unknown-specialpage/oasis-special/_lego-life');
	});

	it('Should extract slot name from ad unit', function () {
		expect(getModule().getShortSlotName('/5441/wka2a.OTHER/bottom_leaderboard/tablet/oasis-home/_godofwar-gaming'))
			.toBe('BOTTOM_LEADERBOARD');
	});

	it('Should keep slotName untouched if passed ad unit is not valid', function () {
		expect(getModule().getShortSlotName('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD'))
			.toBe('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD');
	});

	it('Should keep slotName untouched if passed slotName is not an ad unit', function () {
		expect(getModule().getShortSlotName('TOP_LEADERBOARD')).toBe('TOP_LEADERBOARD');
	});

	testCases.forEach(function (testCase) {
		it('Should build new ad unit without correct pos group', function () {
			mockPageParams(DEFAULT_PAGE_PARAMS);
			mockTargeting(true);

			spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

			expect(getModule().build(testCase.slotName, 'mobile_remnant'))
				.toEqual(testCase.adUnit);
		});
	});

	testCasesForValidation.forEach(function (testCase) {
		it('Should validate given ad unit', function () {
			expect(getModule().isValid(testCase.adUnit)).toBe(testCase.valid);
		});
	});
});
