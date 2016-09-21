describe('ext.wikia.adEngine.slot.adUnitBuilder', function () {
	'use strict';

	var mocks = {
			s0: undefined,
			s1: undefined,
			s2: undefined,
			page: {
				getPageLevelParams: function() {
					return {
						s0: mocks.s0,
						s1: mocks.s1,
						s2: mocks.s2
					};
				}
			}
	};

	beforeEach(function () {
		mocks.s0 = undefined;
		mocks.s1 = undefined;
		mocks.s2 = undefined;
	});

	function getModule() {
		return modules['ext.wikia.adEngine.slot.adUnitBuilder'](mocks.page);
	}

	it('Build ad unit', function () {
		mocks.s0 = 'life';
		mocks.s1 = '_project43';
		mocks.s2 = 'article';

		var vastUrl = getModule().build('TOP_LEADERBOARD', 'playwire');

		expect(vastUrl).toEqual('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD');
	});
});
