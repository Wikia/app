describe('WikiaMaps.poiCategoriesModel', function () {
	'use strict';

	var poiCategoriesModelModule = modules['wikia.intMap.poiCategoriesModel'](jQuery);

	it('registers AMD module', function() {
		expect(typeof poiCategoriesModelModule).toBe('object');
	});

	it('checks if POI category has changed', function() {
		expect(typeof poiCategoriesModelModule.isPoiCategoryChanged).toBe('function');

		var testData = [
			{
				originalPoiCategory: {
					name: 'name',
					parent_poi_category_id: 1
				},
				newPoiCategory: {
					name: 'changed name',
					parent_poi_category_id: 1
				},
				isChanged: true
			},
			{
				originalPoiCategory: {
					name: 'name',
					parent_poi_category_id: 1
				},
				newPoiCategory: {
					name: 'name',
					parent_poi_category_id: 1
				},
				isChanged: false
			},
			{
				originalPoiCategory: {
					name: 'name',
					parent_poi_category_id: 1
				},
				newPoiCategory: {
					name: 'name',
					parent_poi_category_id: 2
				},
				isChanged: true
			},
			{
				originalPoiCategory: {
					name: 'name',
					parent_poi_category_id: 1
				},
				newPoiCategory: {
					name: 'name',
					parent_poi_category_id: 1,
					marker: 'new marker URL'
				},
				isChanged: true
			}
		];

		testData.forEach(function (testCase) {
			var isChanged = poiCategoriesModelModule.isPoiCategoryChanged(testCase.originalPoiCategory, testCase.newPoiCategory);
			expect(isChanged).toBe(testCase.isChanged);
		});
	});
});
