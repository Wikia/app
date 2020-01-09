/* global describe, it, modules, expect, beforeEach */
'use strict';

describe('wikia.articleVideo.featuredVideo.autoplay', function () {
	var context;
	var autoplayCookie;

	var mocks = {
		featuredVideoCookieService: {
			getAutoplay: function () {
				return autoplayCookie;
			}
		},
	};

	beforeEach(function () {
		context = {
			'targeting.skin': 'oasis'
		};
		autoplayCookie = '1';
	});

	function getAutoplay() {
		return modules['wikia.articleVideo.featuredVideo.autoplay'](
			mocks.featuredVideoCookieService,
		);
	}

	describe('isAutoplayDisabledByQueenOfHearts', function () {
		it('should return false if queen_of_hearts prediction is 1', function () {
			expect(getAutoplay().isAutoplayEnabled(1)).toEqual(false);
		});

		it('should return true if queen_of_hearts prediction is 0', function () {
			expect(getAutoplay().isAutoplayEnabled(0)).toEqual(true);
		});
	});

	describe('isAutoplayEnabled', function () {
		// in AB test | autoplay cookie | disabled by queen_of_hearts | result
		var testParams = [
			['1', 1, false],
			['1', 0, true],
			['0', 1, false],
			['0', 0, false]
		];
		for (var i = 0; i < testParams.length; i++) {
			(function (i) {
				var param = testParams[i];
				var caseName = 'should return ' + param[2].toString() +
					' and autoplay cookie is ' + param[0].toString() +
					' and isAutoplayDisabledByBillTheLizard() returns ' + param[1].toString();
				it(caseName, function () {
					autoplayCookie = param[0];
					var prediction = param[1];
					var autoplay = getAutoplay();

					expect(autoplay.isAutoplayEnabled(prediction)).toEqual(param[2]);
				});
			})(i);
		}
	});

	describe('isAutoplayToggleShown', function () {
		it('should return false if queen_of_hearts is true', function () {
			expect(getAutoplay().isAutoplayToggleShown(1)).toEqual(false);
		});

		it('should return true if queen_of_hearts is false', function () {
			expect(getAutoplay().isAutoplayToggleShown(0)).toEqual(true);
		});
	});
});
