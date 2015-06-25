/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.gpt.adSizeConverter', function () {
	'use strict';

	function noop() {}

	var mocks = {
			doc: {
				documentElement: {
					offsetWidth: 1024
				}
			},
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.adSizeConverter'](mocks.doc, mocks.log);
	}

	it('Converts two sizes to array with to elements', function () {
		var sizes = getModule().convert('TOP_RIGHT_BOX_AD', '300x250,300x600');

		expect(sizes.length).toEqual(2);
		expect(sizes[0]).toEqual([300, 250]);
		expect(sizes[1]).toEqual([300, 600]);
	});

	it('Converts sizes and filter out sizes bigger than screen size for TOP_LEADERBOARD slots', function () {
		var sizes = getModule().convert('TOP_LEADERBOARD', '728x90,1030x130');

		expect(sizes.length).toEqual(1);
	});

	it('Returns fallback size if there is no sizes narrower than screen size', function () {
		var sizes = getModule().convert('TOP_LEADERBOARD', '1030x250,1030x130,1030x65');

		expect(sizes.length).toEqual(1);
		expect(sizes[0]).toEqual([1, 1]);
	});
});
