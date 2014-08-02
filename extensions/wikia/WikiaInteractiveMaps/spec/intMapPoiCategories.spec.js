describe('poiCategories', function () {
	'use strict';

	var jQueryMock = jasmine.createSpyObj('$', ['msg']);

	var poiCategoriesModule = modules['wikia.intMap.poiCategories'](jQueryMock),
		poiCategories;

	dump(jasmine.getEnv());
	expect(typeof poiCategoriesModule).toBe('object');
	expect(typeof poiCategoriesModule.isPoiCategoryChanged).toBe('function');

	poiCategories = [
		{
			originalPoiCategory:
			{
				name: 'name',
				parent_poi_category_id: ''
			},
			newPoiCategory:
			{
				name: 'name',
				parent_poi_category_id: '',
				marker: ''
			},
			isChanged: false
		}
	];

	poiCategories.forEach(function (testCase) {
		var isChanged = poiCategoriesModule.isPoiCategoryChanged(testCase.originalPoiCategory, testCase.newPoiCategory);
		expect(isChanged).toBe(testCase.isChanged);
	});
});
