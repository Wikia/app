/* global describe, it, modules, expect */
'use strict';

describe('wikia.articleVideo.featuredVideo.autoplay', function () {
	var context = {};
	var isInAbTestGroup = false;
	var autoplayCookie = '0';
	var predictions = [];

	var mocks = {
		adContext: {
			get: function (key) {
				return context[key];
			}
		},
		abTest: {
			inGroup: function () {
				return isInAbTestGroup;
			}
		},
		featuredVideoCookieService: {
			getAutoplay: function () {
				return autoplayCookie;
			}
		},
		rabbit: {
			getPredictions: function () {
				return predictions;
			}
		}
	};

	function getAutoplay() {
		return modules['wikia.articleVideo.featuredVideo.autoplay'](
			mocks.adContext, mocks.abTest, mocks.featuredVideoCookieService, mocks.rabbit
		);
	}

	describe('isAutoplayDisabledByRabbits', function () {
		it('should return true if rabbit prediction is 1 and ctpDesktop is false', function () {
			predictions = [1];
			context['rabbits.ctpDesktop'] = false;

			expect(getAutoplay().isAutoplayDisabledByRabbits()).toEqual(true);
		});

		it('should return true if rabbit prediction is 1 and ctpDesktop is true', function () {
			predictions = [1];
			context['rabbits.ctpDesktop'] = true;

			expect(getAutoplay().isAutoplayDisabledByRabbits()).toEqual(true);
		});
		it('should return false if rabbit prediction is 0 and ctpDesktop is true', function () {
			predictions = [0];
			context['rabbits.ctpDesktop'] = true;

			expect(getAutoplay().isAutoplayDisabledByRabbits()).toEqual(false);
		});
		it('should return false if rabbit prediction is 0 and ctpDesktop is false', function () {
			predictions = [0];
			context['rabbits.ctpDesktop'] = false;

			expect(getAutoplay().isAutoplayDisabledByRabbits()).toEqual(false);
		});
		it('should return true if rabbit prediction is [] and ctpDesktop is true', function () {
			predictions = [];
			context['rabbits.ctpDesktop'] = true;

			expect(getAutoplay().isAutoplayDisabledByRabbits()).toEqual(true);
		});
		it('should return false if rabbit prediction is [] and ctpDesktop is false', function () {
			predictions = [];
			context['rabbits.ctpDesktop'] = false;

			expect(getAutoplay().isAutoplayDisabledByRabbits()).toEqual(false);
		});
	});

	describe('isAutoplayEnabled', function () {
		// in AB test | autoplay cookie | disabled by rabbits | result
		var testParams = [
			[false, '1', true, false],
			[false, '1', false, true],
			[false, '0', true, false],
			[false, '0', false, false],
			[true, '1', true, false],
			[true, '1', false, false],
			[true, '0', true, false],
			[true, '0', false, false]
		];
		for (var i = 0; i < testParams.length; i++) {
			(function (i) {
				var param = testParams[i];
				var caseName = 'should return ' + param[3].toString() +
					' if FV A/B test is ' + param[0].toString() +
					' and autoplay cookie is ' + param[1].toString() +
					' and isAutoplayDisabledByRabbits() returns ' + param[2].toString();
				it(caseName, function () {
					isInAbTestGroup = param[0];
					autoplayCookie = param[1];
					var autoplay = getAutoplay();
					autoplay.isAutoplayDisabledByRabbits = function () {
						return param[2];
					};

					expect(autoplay.isAutoplayEnabled()).toEqual(param[3]);
				});
			})(i);
		}
	});
});
