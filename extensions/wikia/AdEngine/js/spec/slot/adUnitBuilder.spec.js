describe('ext.wikia.adEngine.slot.adUnitBuilder', function () {
	'use strict';

	var mocks = {
			page: {
				getPageLevelParams: function() {
					return {
						s0: 'life',
						s1: '_project43',
						s2: 'article'
					};
				}
			}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.slot.adUnitBuilder'](mocks.page);
	}

	it('Build ad unit', function () {
		var vastUrl = getModule().build('TOP_LEADERBOARD', 'playwire');

		expect(vastUrl).toEqual('/5441/wka.life/_project43//article/playwire/TOP_LEADERBOARD');
	});
});
