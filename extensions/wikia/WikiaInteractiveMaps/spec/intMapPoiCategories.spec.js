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

		var getParentPoiCategories = function (parentPoiCategories, categorySelected) {
				var parentPoiCategoriesCopy = parentPoiCategories.slice(0);
				parentPoiCategoriesCopy.forEach(function (category) {
					category.selected = (category.id === categorySelected) ? ' selected' : null;
				});
				return parentPoiCategoriesCopy;
			},
			parentPoiCategories = [
				{
					id: 1,
					name: 'first'
				},
				{
					id: 2,
					name: 'second'
				}
			],
			testData = [
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
						parentPoiCategories: getParentPoiCategories(parentPoiCategories, 1)
					}
				}
			];

		poiCategoriesModule.poiCategoryTemplateData.parentPoiCategories = parentPoiCategories;

		testData.forEach(function (testCase) {
			var output = poiCategoriesModule.extendPoiCategoryData(testCase.input, poiCategoriesModule.poiCategoryTemplateData),
				expectedOutput = $.extend(poiCategoriesModule.poiCategoryTemplateData, testCase.expectedOutput);

			expect(output).toEqual(expectedOutput);
		});
	});
});
