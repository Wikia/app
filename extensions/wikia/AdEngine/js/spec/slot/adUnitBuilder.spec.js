describe('ext.wikia.adEngine.slot.adUnitBuilder', function () {
	'use strict';

	var noop = function () {},
		mocks = {
			page: {
				getPageLevelParams: noop
			},
			browserDetect: {
				isMobile: noop
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.adUnitBuilder'](
			mocks.page,
			mocks.browserDetect);
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

	it('Should build new ad unit', function () {
		mockPageParams({
			's0v': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'mercury'
		});

		expect(getModule().buildNew('mobile_remnant', 'MOBILE_PREFOOTER', 'Evolve'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/smartphone/mercury-home/_godofwar-gaming/Evolve');
	});

	it('Should build new ad unit with correct tablet recognition', function () {
		mockPageParams({
			's0v': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'oasis'
		});

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().buildNew('mobile_remnant', 'MOBILE_PREFOOTER', 'test_passback'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/tablet/oasis-home/_godofwar-gaming/test_passback');
	});

	it('Should build new ad unit without passback', function () {
		mockPageParams({
			's0v': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'oasis'
		});

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().buildNew('mobile_remnant', 'MOBILE_PREFOOTER'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/tablet/oasis-home/_godofwar-gaming');
	});

	it('Should build new ad unit without correct pos group', function () {
		mockPageParams({
			's0v': 'gaming',
			's1': '_godofwar',
			's2': 'home',
			'skin': 'oasis'
		});

		spyOn(mocks.browserDetect, 'isMobile').and.returnValue(true);

		expect(getModule().buildNew('mobile_remnant', 'TOP_RIGHT_BOXAD'))
			.toEqual('/5441/mobile_remnant.MR/TOP_RIGHT_BOXAD/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'MOBILE_PREFOOTER'))
			.toEqual('/5441/mobile_remnant.PF/MOBILE_PREFOOTER/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'TOP_LEADERBOARD'))
			.toEqual('/5441/mobile_remnant.LB/TOP_LEADERBOARD/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'LEFT_SKYSCRAPER_2'))
			.toEqual('/5441/mobile_remnant.SKY/LEFT_SKYSCRAPER_2/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'INVISIBLE_HIGH_IMPACT_2'))
			.toEqual('/5441/mobile_remnant.PX/INVISIBLE_HIGH_IMPACT_2/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'INVISIBLE_SKIN'))
			.toEqual('/5441/mobile_remnant.PX/INVISIBLE_SKIN/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'INVISIBLE_SKIN'))
			.toEqual('/5441/mobile_remnant.PX/INVISIBLE_SKIN/tablet/oasis-home/_godofwar-gaming');

		expect(getModule().buildNew('mobile_remnant', 'NOT_SUPPORTED'))
			.toEqual('/5441/mobile_remnant.OTHER/NOT_SUPPORTED/tablet/oasis-home/_godofwar-gaming');
	});
});
