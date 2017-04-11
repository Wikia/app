describe('ext.wikia.adEngine.slot.service.megaAdUnitBuilder', function () {
	'use strict';

	var DEFAULT_PAGE_PARAMS = {
			's0v': 'gaming',
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
			adUnit: '/5441/mobile_remnant.MR/TOP_RIGHT_BOXAD/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'MOBILE_PREFOOTER',
			adUnit: '/5441/mobile_remnant.PF/MOBILE_PREFOOTER/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'TOP_LEADERBOARD',
			adUnit: '/5441/mobile_remnant.LB/TOP_LEADERBOARD/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'LEFT_SKYSCRAPER_2',
			adUnit: '/5441/mobile_remnant.SKY/LEFT_SKYSCRAPER_2/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INVISIBLE_HIGH_IMPACT_2',
			adUnit: '/5441/mobile_remnant.PX/INVISIBLE_HIGH_IMPACT_2/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INVISIBLE_SKIN',
			adUnit: '/5441/mobile_remnant.PX/INVISIBLE_SKIN/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INVISIBLE_SKIN',
			adUnit: '/5441/mobile_remnant.PX/INVISIBLE_SKIN/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'NOT_SUPPORTED',
			adUnit: '/5441/mobile_remnant.OTHER/NOT_SUPPORTED/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'BOTTOM_LEADERBOARD',
			adUnit: '/5441/mobile_remnant.OTHER/BOTTOM_LEADERBOARD/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'INCONTENT_LEADERBOARD',
			adUnit: '/5441/mobile_remnant.OTHER/INCONTENT_LEADERBOARD/tablet/oasis-home/_godofwar-gaming'
		},
		{
			slotName: 'EXIT_STITIAL_BOXAD_1',
			adUnit: '/5441/mobile_remnant.OTHER/EXIT_STITIAL_BOXAD_1/tablet/oasis-home/_godofwar-gaming'
		}
	];

	it('Should build new ad unit', function () {
		mockPageParams({
			's0v': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'mercury'
		});

		expect(getModule().build('mobile_remnant', 'MOBILE_PREFOOTER', 'Evolve'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/smartphone/mercury-home/_godofwar-gaming/Evolve');
	});

	it('Should build new ad unit with correct tablet recognition', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('mobile_remnant', 'MOBILE_PREFOOTER', 'test_passback'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/tablet/oasis-home/_godofwar-gaming/test_passback');
	});

	it('Should build new ad unit without passback', function () {
		mockPageParams(DEFAULT_PAGE_PARAMS);

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('mobile_remnant', 'MOBILE_PREFOOTER'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/tablet/oasis-home/_godofwar-gaming');
	});

	it('Should build new ad unit without device if its special page', function () {
		mockPageParams({
			's0v': 'gaming',
			's1': '_godofwar',
			's2': 'special',
			'skin': 'oasis'
		});

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().build('mobile_remnant', 'MOBILE_PREFOOTER'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/unknown-specialpage/oasis-special/_godofwar-gaming');
	});

	testCases.forEach(function (testCase) {
		it('Should build new ad unit without correct pos group', function () {
			mockPageParams(DEFAULT_PAGE_PARAMS);

			spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

			expect(getModule().build('mobile_remnant', testCase.slotName))
				.toEqual(testCase.adUnit);
		});
	});
});
