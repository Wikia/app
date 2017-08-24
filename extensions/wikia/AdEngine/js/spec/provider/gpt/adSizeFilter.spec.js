/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.gpt.adSizeFilter', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
		adContext: {
			getContext: function () {
				return {
					opts: {
						overridePrefootersSizes: mocks.overridePrefootersSizes
					}
				};
			}
		},
		adSizeConverter: {
			toArray: noop
		},
		abTest: {
			getGroup: noop
		},
		breakpointsLayout: {
			getLargeContentWidth: function () {
				return 1238;
			}
		},
		getDocument: function () {
			return {
				documentElement: {
					offsetWidth: mocks.getDocumentWidth()
				},
				getElementById: function () {
					return {
						offsetWidth: mocks.getContentWidth()
					};
				}
			};
		},
		getDocumentWidth: noop,
		getContentWidth: noop,
		overridePrefootersSizes: false,
		log: noop,
		win: {
			ads: {
				context: {}
			}
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.adSizeFilter'](
			mocks.adContext,
			mocks.adSizeConverter,
			mocks.abTest,
			mocks.getDocument(),
			mocks.log,
			mocks.win,
			mocks.breakpointsLayout
		);
	}

	it('Returns sizes unmodified for non-specific slots', function () {
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[123, 456], [789, 1011], [12, 13]]);

		var sizesIn = '123x456,789x1011,12x13',
			sizesOut = [[123, 456], [789, 1011], [12, 13]];

		expect(getModule().filter('foo', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for TOP_LEADERBOARD (and variants) for large screens', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(2000);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[728, 90], [1030, 130], [970, 365], [980, 150]]);

		var sizesIn = '728x90,1030x130,970x365,980x150',
			sizesOut = [[728, 90], [1030, 130], [970, 365], [980, 150]];

		expect(getModule().filter('TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes that fit in screen width for TOP_LEADERBOARD (and variants) for smaller screens', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(975);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[728, 90], [1030, 130], [970, 365], [980, 150]]);

		var sizesIn = '728x90,1030x130,970x365,980x150',
			sizesOut = [[728, 90], [970, 365]];

		expect(getModule().filter('TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns only 728x90 for TOP_LEADERBOARD for very small screens', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(100);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[600, 90], [1030, 130], [970, 365], [980, 150]]);

		var sizesIn = '600x90,1030x130,970x365,980x150',
			sizesOut = [[728, 90]];

		expect(getModule().filter('TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for INVISIBLE_SKIN for screens >= 1240', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(1245);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[1000, 1000], [1, 1]]);

		var sizesIn = '1000x1000,1x1',
			sizesOut = [[1000, 1000], [1, 1]];

		expect(getModule().filter('INVISIBLE_SKIN', sizesIn)).toEqual(sizesOut);
	});

	it('Returns only the 1x1 size of INVISIBLE_SKIN for screens < 1240', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(1235);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[1000, 1000], [1, 1]]);

		var sizesIn = '1000x1000,1x1',
			sizesOut = [[1, 1]];

		expect(getModule().filter('INVISIBLE_SKIN', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for PREFOOTER_LEFT_BOXAD for large screens' +
		' when override prefooters feature disabled', function () {
		spyOn(mocks, 'getContentWidth').and.returnValue(2000);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[728, 90], [468, 60], [300, 250]]);
		mocks.overridePrefootersSizes = false;

		var sizesIn = '728x90,468x60,300x250',
			sizesOut = [[728, 90], [468, 60], [300, 250]];

		expect(getModule().filter('PREFOOTER_LEFT_BOXAD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for PREFOOTER_LEFT_BOXAD for large screens' +
		' when override prefooters feature enabled', function () {
		spyOn(mocks, 'getContentWidth').and.returnValue(2000);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[728, 90], [468, 60], [300, 250]]);
		mocks.overridePrefootersSizes = true;

		var sizesIn = '728x90,468x60,300x250',
			sizesOut = [[728, 90], [468, 60], [300, 250]];

		expect(getModule().filter('PREFOOTER_LEFT_BOXAD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for PREFOOTER_LEFT_BOXAD for small screens' +
		' when override prefooters feature disabled', function () {
		spyOn(mocks, 'getContentWidth').and.returnValue(1000);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[728, 90], [468, 60], [300, 250]]);
		mocks.overridePrefootersSizes = false;

		var sizesIn = '728x90,468x60,300x250',
			sizesOut = [[728, 90], [468, 60], [300, 250]];

		expect(getModule().filter('PREFOOTER_LEFT_BOXAD', sizesIn)).toEqual(sizesOut);
	});

	it('Filter 728x90 size for PREFOOTER_LEFT_BOXAD for small screens' +
		' when override prefooters feature enabled', function () {
		spyOn(mocks, 'getContentWidth').and.returnValue(1000);
		spyOn(mocks.adSizeConverter, 'toArray').and.returnValue([[728, 90], [468, 60], [300, 250]]);
		mocks.overridePrefootersSizes = true;

		var sizesIn = '728x90,468x60,300x250',
			sizesOut = [[468, 60], [300, 250]];

		expect(getModule().filter('PREFOOTER_LEFT_BOXAD', sizesIn)).toEqual(sizesOut);
	});
});
