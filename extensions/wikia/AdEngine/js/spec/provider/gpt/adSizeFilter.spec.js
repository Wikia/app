/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.gpt.adSizeFilter', function () {
	'use strict';

	function noop() { return; }

	var mocks = {
			getDocument: function () {
				return {
					documentElement: {
						offsetWidth: mocks.getDocumentWidth()
					}
				};
			},
			getDocumentWidth: noop,
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.adSizeFilter'](mocks.getDocument(), mocks.log);
	}

	it('Returns sizes unmodified for non-specific slots', function () {
		var sizesIn = [[123, 456], [789, 1011], [12, 13]],
			sizesOut = [[123, 456], [789, 1011], [12, 13]];

		expect(getModule().filter('foo', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for TOP_LEADERBOARD (and variants) for large screens', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(2000);

		var sizesIn = [[728, 90], [1030, 130], [970, 365], [980, 150]],
			sizesOut = [[728, 90], [1030, 130], [970, 365], [980, 150]];

		expect(getModule().filter('TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('CORP_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('HUB_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('HOME_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes that fit in screen width for TOP_LEADERBOARD (and variants) for smaller screens', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(975);

		var sizesIn = [[728, 90], [1030, 130], [970, 365], [980, 150]],
			sizesOut = [[728, 90], [970, 365]];

		expect(getModule().filter('TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('CORP_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('HUB_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('HOME_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns only the first size of TOP_LEADERBOARD for very small screens', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(100);

		var sizesIn = [[728, 90], [1030, 130], [970, 365], [980, 150]],
			sizesOut = [[728, 90]];

		expect(getModule().filter('TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('CORP_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('HUB_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
		expect(getModule().filter('HOME_TOP_LEADERBOARD', sizesIn)).toEqual(sizesOut);
	});

	it('Returns sizes unmodified for INVISIBLE_SKIN for screens > 1065', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(1070);

		var sizesIn = [[1, 1], [1000, 1000]],
			sizesOut = [[1, 1], [1000, 1000]];

		expect(getModule().filter('INVISIBLE_SKIN', sizesIn)).toEqual(sizesOut);
	});

	it('Returns only the first size of INVISIBLE_SKIN for screens < 1065', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(1000);

		var sizesIn = [[1, 1], [1000, 1000]],
			sizesOut = [[1, 1]];

		expect(getModule().filter('INVISIBLE_SKIN', sizesIn)).toEqual(sizesOut);
	});
});
