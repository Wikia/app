describe('WikiaMaps.poiCategories', function () {
	'use strict';

	var jQueryMock = jasmine.createSpyObj('$', ['msg']),
		poiCategoriesModule = modules['wikia.intMap.poiCategories'](jQuery);

	it('registers AMD module', function() {
		expect(typeof poiCategoriesModule).toBe('object');
	});

	it('extends POI category data', function() {
		expect(typeof poiCategoriesModule.extendPoiCategoryData).toBe('function');
		expect(typeof poiCategoriesModule.poiCategoryTemplateData).toBe('object');

		var testData = [
				{
					input: {
						id: 1,
						name: 'category name',
						marker: 'http://marker.jpg',
						parent_poi_category_id: 1
					},
					expectedOutput: {
						id: 1,
						name: 'category name',
						marker: 'http://marker.jpg',
						parentPoiCategories: [
							{
								id: 1,
								name: 'first',
								selected: ' selected'
							},
							{
								id: 2,
								name: 'second',
								selected: null
							}
						]
					}
				},
				{
					input: {
						id: 2,
						name: 'category name',
						marker: '',
						no_marker: true,
						parent_poi_category_id: 2
					},
					expectedOutput: {
						id: 2,
						name: 'category name',
						parentPoiCategories: [
							{
								id: 1,
								name: 'first',
								selected: null
							},
							{
								id: 2,
								name: 'second',
								selected: ' selected'
							}
						]
					}
				}
			];

		// normally handled by getParentPoiCategories()
		poiCategoriesModule.poiCategoryTemplateData.parentPoiCategories = [
			{
				id: 1,
				name: 'first'
			},
			{
				id: 2,
				name: 'second'
			}
		];

		testData.forEach(function (testCase) {
			var output = poiCategoriesModule.extendPoiCategoryData(testCase.input, poiCategoriesModule.poiCategoryTemplateData),
				expectedOutput = $.extend({}, poiCategoriesModule.poiCategoryTemplateData, testCase.expectedOutput);

			expect(output).toEqual(expectedOutput);
		});
	});
});
