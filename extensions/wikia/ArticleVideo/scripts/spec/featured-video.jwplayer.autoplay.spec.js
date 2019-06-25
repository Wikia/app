/* global describe, it, modules, expect, beforeEach */
'use strict';

describe('wikia.articleVideo.featuredVideo.autoplay', function () {
	var context;
	var isInAbTestGroup;
	var autoplayCookie;
	var prediction;

	var mocks = {
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
		adsApi: {
			isAutoPlayDisabled: function () {
				return !!prediction;
			}
		}
	};

	beforeEach(function () {
		context = {
			'targeting.skin': 'oasis'
		};
		isInAbTestGroup = false;
		autoplayCookie = '1';
		prediction = undefined;
	});

	function getAutoplay() {
		return modules['wikia.articleVideo.featuredVideo.autoplay'](
			mocks.abTest,
			mocks.featuredVideoCookieService,
			mocks.adsApi,
		);
	}

	describe('isAutoplayDisabledByQueenOfHearts', function () {
		it('should return false if queen_of_hearts prediction is 1', function () {
			prediction = 1;

			expect(getAutoplay().isAutoplayEnabled()).toEqual(false);
		});

		it('should return true if queen_of_hearts prediction is 0', function () {
			prediction = 0;

			expect(getAutoplay().isAutoplayEnabled()).toEqual(true);
		});
	});

	describe('isAutoplayEnabled', function () {
		// in AB test | autoplay cookie | disabled by queen_of_hearts | result
		var testParams = [
			[false, '1', 1, false],
			[false, '1', 0, true],
			[false, '0', 1, false],
			[false, '0', 0, false],
			[true, '1', 1, false],
			[true, '1', 0, false],
			[true, '0', 1, false],
			[true, '0', 0, false]
		];
		for (var i = 0; i < testParams.length; i++) {
			(function (i) {
				var param = testParams[i];
				var caseName = 'should return ' + param[3].toString() +
					' if FV A/B test is ' + param[0].toString() +
					' and autoplay cookie is ' + param[1].toString() +
					' and isAutoplayDisabledByBillTheLizard() returns ' + param[2].toString();
				it(caseName, function () {
					isInAbTestGroup = param[0];
					autoplayCookie = param[1];
					prediction = param[2];
					var autoplay = getAutoplay();

					expect(autoplay.isAutoplayEnabled()).toEqual(param[3]);
				});
			})(i);
		}
	});

	describe('isAutoplayToggleShown', function () {
		beforeEach(function () {
			isInAbTestGroup = undefined;
		});

		it('should return false if queen_of_hearts is true', function () {
			prediction = 1;

			expect(getAutoplay().isAutoplayToggleShown()).toEqual(false);
		});

		it('should return true if queen_of_hearts is false', function () {
			prediction = 0;

			expect(getAutoplay().isAutoplayToggleShown()).toEqual(true);
		});

		it('should return false if in inFeaturedVideoClickToPlayABTest is true', function () {
			isInAbTestGroup = true;

			expect(getAutoplay().isAutoplayToggleShown()).toEqual(false);
		});

		it('should return true if all of models or AB test are undefined', function () {
			expect(getAutoplay().isAutoplayToggleShown()).toEqual(true);
		});

		it('should return true if all of models or AB test are false', function () {
			prediction = 0;
			isInAbTestGroup = false;

			expect(getAutoplay().isAutoplayToggleShown()).toEqual(true);
		});
	});
});
