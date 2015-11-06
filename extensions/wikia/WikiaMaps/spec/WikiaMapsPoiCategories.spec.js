describe('wikia.maps.poiCategories', function () {
	'use strict';

	var poiCategoriesModule = require('wikia.maps.poiCategories')(jQuery);

	it('registers AMD module', function() {
		expect(typeof poiCategoriesModule).toBe('object');

		expect(typeof poiCategoriesModule.markParentPoiCategoryAsSelected).toBe('function');
		expect(typeof poiCategoriesModule.extendPoiCategoryData).toBe('function');
		expect(typeof poiCategoriesModule.poiCategoryTemplateData).toBe('object');
	});

	it('marks parent POI category as selected', function() {
		var testData = [
			{
				input: {
					parentPoiCategories: [
						{
							id: 1,
							name: 'first'
						},
						{
							id: 2,
							name: 'second'
						}
					],
					id: 1
				},
				expectedOutput: [
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
			},
			{
				input: {
					parentPoiCategories: [
						{
							id: 1,
							name: 'first'
						},
						{
							id: 2,
							name: 'second'
						}
					],
					id: 3
				},
				expectedOutput: [
					{
						id: 1,
						name: 'first',
						selected: null
					},
					{
						id: 2,
						name: 'second',
						selected: null
					}
				]
			}
		];

		testData.forEach(function (testCase) {
			var output = poiCategoriesModule.markParentPoiCategoryAsSelected(
					testCase.input.parentPoiCategories, testCase.input.id
				),
				expectedOutput = testCase.expectedOutput;

			expect(output).toEqual(expectedOutput);
		});
	});

	it('extends POI category data', function() {
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
