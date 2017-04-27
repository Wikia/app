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
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.service.megaAdUnitBuilder'](
			mocks.page,
			mocks.browserDetect);
	}

	function mockPageParams(params) {
		spyOn(mocks.page, 'getPageLevelParams');
		mocks.page.getPageLevelParams.and.returnValue(params);
	}

	var testCases = [
		{
			slotName: 'TOP_RIGHT_BOXAD',
			adUnit: '/5441/wka2.MR/top_right_boxad/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'MOBILE_PREFOOTER',
			adUnit: '/5441/wka2.PF/mobile_prefooter/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'TOP_LEADERBOARD',
			adUnit: '/5441/wka2.LB/top_leaderboard/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'LEFT_SKYSCRAPER_2',
			adUnit: '/5441/wka2.SKY/left_skyscraper_2/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INVISIBLE_HIGH_IMPACT_2',
			adUnit: '/5441/wka2.PX/invisible_high_impact_2/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INVISIBLE_SKIN',
			adUnit: '/5441/wka2.PX/invisible_skin/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INVISIBLE_SKIN',
			adUnit: '/5441/wka2.PX/invisible_skin/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'NOT_SUPPORTED',
			adUnit: '/5441/wka2.OTHER/not_supported/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'BOTTOM_LEADERBOARD',
			adUnit: '/5441/wka2.OTHER/bottom_leaderboard/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INCONTENT_LEADERBOARD',
			adUnit: '/5441/wka2.OTHER/incontent_leaderboard/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'BOTTOM_LEADERBOARD',
			adUnit: '/5441/wka2.OTHER/bottom_leaderboard/tablet/oasis-home/_godofwar-gaming'
		}
	];

	it('Should build new ad unit', function () {
		mockPageParams({
			's0': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'mercury'
		});

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant', 'Evolve'))
			.toEqual('/5441/wka2.PF/mobile_prefooter/smartphone/mercury-home/_godofwar-gaming/Evolve');
	});

	it('Should build new ad unit with correct tablet recognition', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant', 'test_passback'))
			.toEqual('/5441/wka2.PF/mobile_prefooter/tablet/oasis-home/_godofwar-gaming/test_passback');
	});

	it('Should build new ad unit without passback', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2.PF/mobile_prefooter/tablet/oasis-home/_godofwar-gaming');
	});

	it('Should build new ad unit non-remnant provider with wka1', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);

		expect(getModule().build('TOP_LEADERBOARD', 'gpt'))
			.toEqual('/5441/wka1.LB/top_leaderboard/desktop/oasis-home/_godofwar-gaming');
	});

	it('Should build new ad unit without device if its special page', function () {
		mockPageParams({
			's0': 'life',
			's1': '_lego',
			's2': 'special',
			'skin': 'oasis'
		});

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('MOBILE_PREFOOTER', 'mobile_remnant'))
			.toEqual('/5441/wka2.PF/mobile_prefooter/unknown-specialpage/oasis-special/_lego-life');
	});

	testCases.forEach(function (testCase) {
		it('Should build new ad unit without correct pos group', function () {
			mockPageParams(DEFAULT_PAGE_PARAMS);

			spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

			expect(getModule().build(testCase.slotName, 'mobile_remnant'))
				.toEqual(testCase.adUnit);
		});
	});
});
