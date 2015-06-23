/*global describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.provider.gpt.adSizeConverter', function () {
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
			getDocumentWidth: function () {
				return 1024;
			},
			log: noop
		};

	function getModule() {
		return modules['ext.wikia.adEngine.provider.gpt.adSizeConverter'](mocks.getDocument(), mocks.log);
	}

	it('Converts two sizes to array with to elements', function () {
		var sizes = getModule().convert('TOP_RIGHT_BOX_AD', '300x250,300x600');

		expect(sizes).toEqual([[300, 250], [300, 600]]);
	});

	it('Converts sizes and filter out sizes bigger than screen size for TOP_LEADERBOARD slots', function () {
		var sizes = getModule().convert('TOP_LEADERBOARD', '728x90,1030x130');

		expect(sizes).toEqual([[728, 90]]);
	});

	it('Returns fallback size if there is no sizes narrower than screen size', function () {
		var sizes = getModule().convert('TOP_LEADERBOARD', '1030x250,1030x130,1030x65');

		expect(sizes).toEqual([[1, 1]]);
	});

	it('Returns fallback size for INVISIBLE_SKIN if screen size is narrower than 1064', function () {
		var sizes = getModule().convert('INVISIBLE_SKIN', '1x1,123x456');

		expect(sizes).toEqual([[1, 1]]);
	});

	it('Returns all sizes for INVISIBLE_SKIN if screen size is wider than 1064', function () {
		spyOn(mocks, 'getDocumentWidth').and.returnValue(1100);

		var sizes = getModule().convert('INVISIBLE_SKIN', '1x1,123x456');

		expect(sizes).toEqual([[1, 1], [123, 456]]);
	});
});
