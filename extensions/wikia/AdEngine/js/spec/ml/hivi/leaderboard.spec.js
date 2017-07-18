/*global describe, expect, it, modules, spyOn*/
describe('ext.wikia.adEngine.ml.hivi.leaderboard', function () {
	'use strict';

	var mocks = {
			geo: {
				isProperGeo: function () {
					return true;
				}
			},
			instantGlobals: {
				wgAdDriverHiViLeaderboardCountries: [ 'PL' ]
			}
		},
		testCases = [
			{
				data: [
					0.03333333333333333,
					0.13043478260869565,
					1,
					0,
					0,
					0,
					0,
					0,
					0,
					1,
					0,
					0,
					0,
					0,
					0,
					0,
					1,
					0,
					0.3,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0
				],
				output: [ '5515_0' ]
			},
			{
				data: [
					0.3333333333333333,
					0.13043478260869565,
					0,
					0,
					1,
					0,
					0,
					0,
					0,
					0,
					1,
					0,
					0,
					0,
					0,
					1,
					0,
					0,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0
				],
				output: [ '5515_1' ]
			},
			{
				data: [0.03333333333333333,
					0.13043478260869565,
					1,
					0,
					0,
					0,
					0,
					0,
					0,
					0,
					1,
					0,
					0,
					0,
					0,
					1,
					0,
					0,
					0.2,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0,
					0.0
				],
				output: [ '5515_1' ]
			}
		];

	function getInputParserMock(input) {
		return {
			getData: function () {
				return input;
			}
		};
	}

	function getModule(inputMock) {
		return modules['ext.wikia.adEngine.ml.hivi.leaderboard'](
			getInputParserMock(inputMock),
			modules['ext.wikia.adEngine.ml.model.logisticRegression'](),
			mocks.geo,
			mocks.instantGlobals
		);
	}

	it('Returns empty array when feature is disabled', function () {
		var hiviLeaderboard = getModule([]);

		spyOn(mocks.geo, 'isProperGeo').and.returnValue(false);

		expect(hiviLeaderboard.getValue()).toEqual([]);
	});

	it('Predict value based on coefficients and intercept', function () {
		testCases.forEach(function (testCase) {
			var hiviLeaderboard = getModule(testCase.data);

			expect(hiviLeaderboard.getValue()).toEqual(testCase.output);
		});
	});
});
