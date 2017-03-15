describe('ext.wikia.adEngine.video.player.porvata.floaterConfiguration', function () {
	'use strict';

	var WIDTH = 100,
		HEIGHT = 100,
		mocks = {
			win: {}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.video.player.porvata.floaterConfiguration'](mocks.win);
	}

	it('floater should be disabled when "enableLeaderboardFloating" configuration is not set', function () {
		var module = getModule(),
			params = {},
			actual = module.canFloat(params);

		expect(actual).toBeFalsy();
	});

	it('floater should be disabled when "enableLeaderboardFloating" configuration is set to false', function () {
		var module = getModule(),
			params = {
				enableLeaderboardFloating: false
			},
			actual = module.canFloat(params);

		expect(actual).toBeFalsy();
	});

	it('floater should be disabled when "enableLeaderboardFloating" configuration is set to true, but TOP_RIGHT_BOXAX is asking', function () {
		var module = getModule(),
			params = {
				enableLeaderboardFloating: true,
				slotName: 'TOP_RIGHT_BOXAD'
			},
			actual = module.canFloat(params);

		expect(actual).toBeFalsy();
	});

	it('floater should be enabled when "enableLeaderboardFloating" configuration is set to true and TOP_LEADERBOARD is asking', function () {
		var module = getModule(),
			params = {
				enableLeaderboardFloating: true,
				slotName: 'TOP_LEADERBOARD'
			},
			actual = module.canFloat(params);

		expect(actual).toBeTruthy();
	});
});
