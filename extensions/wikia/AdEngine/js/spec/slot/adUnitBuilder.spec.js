describe('ext.wikia.adEngine.slot.adUnitBuilder', function () {
	'use strict';

	var mocks = {
		page: {
			getPageLevelParams: function() {
				return {};
			}
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.adUnitBuilder'](mocks.page);
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
			'skin': 'mercury',
		});

		expect(getModule().buildNew('mobile_remnant', 'MOBILE_PREFOOTER', 'Evolve'))
			.toEqual('/5441/mobile_remnant.MOBILE_PREFOOTER/smartphone/mercury-home/_godofwar-gaming/Evolve');
	});
});
