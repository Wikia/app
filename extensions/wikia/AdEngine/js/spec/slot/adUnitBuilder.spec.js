/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.slot.adUnitBuilder', function () {
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
			deviceDetect: {
				getDevice: noop
			},
			adContext: {
				addCallback: noop,
				getContext: noop,
				get: function (path) {
					path = path.split('.');
					return this.getContext()[path[0]][path[1]];
				}
			},
			slotsContext: {
				isApplicable: noop
			},
			adEngineBridge: {
				geo: {
					isProperCountry: noop
				}
			}
		},
		testCases = [
			{
				slotName: 'TOP_BOXAD',
				adUnit: '/5441/wka2b.MR/top_boxad/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'MOBILE_PREFOOTER',
				adUnit: '/5441/wka2b.PF/mobile_prefooter/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'TOP_LEADERBOARD',
				adUnit: '/5441/wka2b.LB/top_leaderboard/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'INVISIBLE_HIGH_IMPACT_2',
				adUnit: '/5441/wka2b.PX/invisible_high_impact_2/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'INVISIBLE_HIGH_IMPACT',
				adUnit: '/5441/wka2b.PX/invisible_high_impact/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'INVISIBLE_SKIN',
				adUnit: '/5441/wka2b.PX/invisible_skin/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'INVISIBLE_SKIN',
				adUnit: '/5441/wka2b.PX/invisible_skin/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'NOT_SUPPORTED',
				adUnit: '/5441/wka2b.OTHER/not_supported/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'BOTTOM_LEADERBOARD',
				adUnit: '/5441/wka2b.PF/bottom_leaderboard/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'INCONTENT_PLAYER',
				adUnit: '/5441/wka2b.HiVi/incontent_player/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'BOTTOM_LEADERBOARD',
				adUnit: '/5441/wka2b.PF/bottom_leaderboard/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'FEATURED',
				adUnit: '/5441/wka2b.VIDEO/featured/tablet/oasis-home/_godofwar-gaming'
			},
			{
				slotName: 'UAP_BFAA',
				adUnit: '/5441/wka2b.VIDEO/uap_bfaa/tablet/oasis-home/_top1k_wiki-gaming'
			},
			{
				slotName: 'ABCD',
				adUnit: '/5441/wka2b.VIDEO/abcd/tablet/oasis-home/_top1k_wiki-gaming'
			}
		],
		testCasesForValidation = [
			{
				adUnit: '/5441/wka2b.PX/invisible_skin/tablet/oasis-home/_top1k_wiki',
				valid: true
			},
			{
				adUnit: '/5441/wka1b.MR/top_boxad/tablet/oasis-home/_top1k_wiki',
				valid: true
			},
			{
				adUnit: 'TOP_BOXAD',
				valid: false
			},
			{
				adUnit: '/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD',
				valid: false
			}
		];

	function getModule() {
		return modules['ext.wikia.adEngine.slot.adUnitBuilder'](
			mocks.adContext,
			mocks.page,
			mocks.slotsContext,
			mocks.deviceDetect,
			mocks.adEngineBridge
		);
	}

	function mockPageParams(params) {
		spyOn(mocks.page, 'getPageLevelParams');
		mocks.page.getPageLevelParams.and.returnValue(params);
	}

	function mockContext(targeting, opts) {
		spyOn(mocks.adContext, 'getContext');
		mocks.adContext.getContext.and.returnValue({targeting: targeting, opts: opts});
	}

	it('Should build new ad unit', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'mercury'
		});
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('smartphone');

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2b.PF/mobile_prefooter/smartphone/mercury-home/_top1k_wiki-gaming');
	});

	it('Should build new ad unit with correct tablet recognition', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('tablet');

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2b.PF/mobile_prefooter/tablet/oasis-home/_top1k_wiki-gaming');
	});

	it('Should build new ad unit with featured video', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'fv-article',
			'skin': 'mercury'
		});
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('smartphone');

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2b.PF/mobile_prefooter/smartphone/mercury-fv-article/_top1k_wiki-gaming');
	});

	it('Should build new ad unit with featured video', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'fv-article',
			'skin': 'oasis'
		});
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('desktop');

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2b.PF/mobile_prefooter/desktop/oasis-fv-article/_top1k_wiki-gaming');
	});

	it('Should build new ad unit with IC info', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'article',
			'skin': 'oasis'
		});
		mockContext({ wikiIsTop1000: true }, {});
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
		mockContext({ wikiIsTop1000: true }, {});
		spyOn(mocks.slotsContext, 'isApplicable').and.returnValue(true);

		expect(getModule().build('TOP_LEADERBOARD', 'gpt')).toContain('/oasis-fv-article-ic/');
	});

	it('Should build new ad unit for wiki not in top 1000', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockContext({ wikiIsTop1000: false }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('tablet');

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2b.PF/mobile_prefooter/tablet/oasis-home/_not_a_top1k_wiki-gaming');
	});

	it('Should build new ad unit non-remnant provider with wka1b', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('desktop');

		expect(getModule().build('TOP_LEADERBOARD', 'gpt'))
			.toEqual('/5441/wka1b.LB/top_leaderboard/desktop/oasis-home/_top1k_wiki-gaming');
	});

	it('Should build new ad unit non-remnant provider with vm1b for AU and NZ', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('desktop');
		spyOn(mocks.adEngineBridge.geo, 'isProperCountry').and.callFake(function (geos) {
			return geos.length === 2 && geos[0] === 'AU' && geos[1] === 'NZ';
		});

		expect(getModule().build('TOP_LEADERBOARD', 'gpt'))
			.toEqual('/5441/vm1b.LB/top_leaderboard/desktop/oasis-home/_top1k_wiki-gaming');
	});

	it('Should build new ad unit without device if its special page', function () {
		mockPageParams({
			's0': 'life',
			's1': '_lego',
			's2': 'special',
			'skin': 'oasis'
		});
		mockContext({ wikiIsTop1000: true }, {});

		spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('tablet');

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2b.PF/mobile_prefooter/unknown-specialpage/oasis-special/_top1k_wiki-life');
	});

	it('Should extract slot name from ad unit', function () {
		mockContext({ wikiIsTop1000: true }, {});

		expect(getModule().getShortSlotName('/5441/wka2b.OTHER/bottom_leaderboard/tablet/oasis-home/_top1k_wiki-gaming'))
			.toBe('BOTTOM_LEADERBOARD');
	});

	it('Should keep slotName untouched if passed ad unit is not valid', function () {
		mockContext({}, {});

		expect(getModule().getShortSlotName('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD'))
			.toBe('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD');
	});

	it('Should keep slotName untouched if passed slotName is not an ad unit', function () {
		mockContext({}, {});

		expect(getModule().getShortSlotName('TOP_LEADERBOARD')).toBe('TOP_LEADERBOARD');
	});

	testCases.forEach(function (testCase) {
		it('Should build new ad unit without correct pos group', function () {
			mockPageParams(DEFAULT_PAGE_PARAMS);
			mockContext({ wikiIsTop1000: true }, {});

			spyOn(mocks.deviceDetect, 'getDevice').and.returnValue('tablet');

			expect(getModule().build(testCase.slotName, 'mobile_remnant'))
				.toEqual(testCase.adUnit);
		});
	});

	testCasesForValidation.forEach(function (testCase) {
		it('Should validate given ad unit', function () {
			mockContext({}, {});

			expect(getModule().isValid(testCase.adUnit)).toBe(testCase.valid);
		});
	});
});
