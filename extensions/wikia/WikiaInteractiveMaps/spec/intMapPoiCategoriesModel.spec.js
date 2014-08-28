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
			var isChanged = poiCategoriesModelModule.isPoiCategoryChanged(
				testCase.originalPoiCategory, testCase.newPoiCategory
			);
			expect(isChanged).toBe(testCase.isChanged);
		});
	});

	it('checks if POI category was deleted', function () {
		expect(typeof poiCategoriesModelModule.isPoiCategoryDeleted).toBe('function');

		var testData = [
			{
				input: {
					poiCategory: {
						id: 1
					},
					poiCategoriesDeleted: [1, 2, 3]
				},
				expectedOutput: true
			},
			{
				input: {
					poiCategory: {
						id: 1
					},
					poiCategoriesDeleted: []
				},
				expectedOutput: false
			},
			{
				input: {
					poiCategory: {
						id: 2
					},
					poiCategoriesDeleted: [1]
				},
				expectedOutput: false
			}
		];

		testData.forEach(function (testCase) {
			var poiCategoryDeleted = poiCategoriesModelModule.isPoiCategoryDeleted(
				testCase.input.poiCategory, testCase.input.poiCategoriesDeleted
			);
			expect(poiCategoryDeleted).toBe(testCase.expectedOutput);
		});
	});

	it('finds POI category by id', function () {
		expect(typeof poiCategoriesModelModule.findPoiCategoryById).toBe('function');

		var testData = [
			{
				input: {
					id: 1,
					poiCategories: [
						{
							id: 1,
							name: 'first one'
						},
						{
							id: 2,
							name: 'second one'
						}
					]
				},
				expectedOutput: {
					id: 1,
					name: 'first one'
				}
			},
			{
				input: {
					id: 3,
					poiCategories: [
						{
							id: 1,
							name: 'first one'
						},
						{
							id: 2,
							name: 'second one'
						}
					]
				},
				expectedOutput: null
			},
			{
				input: {
					id: 1,
					poiCategories: []
				},
				expectedOutput: null
			}
		];

		testData.forEach(function (testCase) {
			var poiCategory = poiCategoriesModelModule.findPoiCategoryById(
				testCase.input.id, testCase.input.poiCategories
			);
			expect(poiCategory).toEqual(testCase.expectedOutput);
		});
	});

	it('organizes POI categories', function () {
		expect(typeof poiCategoriesModelModule.organizePoiCategories).toBe('function');

		var testData = [
			{
				input: {
					formSerialized: {
						mapId: 1,
						poiCategories: [
							{
								id: 1,
								map_id: 1,
								marker: '',
								name: 'first category, modified',
								parent_poi_category_id: 3,
								status: 1
							},
							{
								id: 3,
								map_id: 1,
								marker: '',
								name: 'second category',
								parent_poi_category_id: 1,
								status: 1
							},
							{
								marker: 'http://marker.url',
								name: 'new category',
								parent_poi_category_id: ''
							}
						],
						poiCategoriesToDelete: '2'
					},
					poiCategoriesOriginalData: [
						{
							id: 1,
							map_id: 1,
							marker: 'http://marker.url',
							name: 'first category',
							parent_poi_category_id: 3,
							status: 1
						},
						{
							id: 2,
							map_id: 1,
							marker: 'http://marker.url',
							name: 'second category',
							parent_poi_category_id: 1,
							status: 1
						}
					]
				},
				expectedOutput: {
					mapId: 1,
					poiCategoriesToCreate: [
						{
							marker: 'http://marker.url',
							name: 'new category',
							parent_poi_category_id: ''
						}
					],
					poiCategoriesToUpdate: [
						{
							id: 1,
							map_id: 1,
							marker: '',
							name: 'first category, modified',
							parent_poi_category_id: 3,
							status: 1
						}
					],
					poiCategoriesToDelete: [2]
				}
			},
			{
				input: {
					formSerialized: {
						mapId: 1,
						poiCategories: [],
						poiCategoriesToDelete: '1,2'
					},
					poiCategoriesOriginalData: [
						{
							id: 1,
							map_id: 1,
							marker: 'http://marker.url',
							name: 'first category',
							parent_poi_category_id: 3,
							status: 1
						},
						{
							id: 2,
							map_id: 1,
							marker: 'http://marker.url',
							name: 'second category',
							parent_poi_category_id: 1,
							status: 1
						}
					]
				},
				expectedOutput: {
					mapId: 1,
					poiCategoriesToCreate: [],
					poiCategoriesToUpdate: [],
					poiCategoriesToDelete: [1, 2]
				}
			}
		];

		testData.forEach(function (testCase) {
			var poiCategoriesOrganized;

			poiCategoriesModelModule.setPoiCategoriesOriginalData(testCase.input.poiCategoriesOriginalData);
			poiCategoriesOrganized = poiCategoriesModelModule.organizePoiCategories(testCase.input.formSerialized);

			expect(poiCategoriesOrganized).toEqual(testCase.expectedOutput);
		});
	});

	it('sets POI category updated data', function () {
		expect(typeof poiCategoriesModelModule.setPoiCategoryUpdatedData).toBe('function');

		var testData = [
			{
				input: {
					poiCategoryUpdated: {
						map_id: 1,
						status: 1,
						marker: 'http://marker.url'
					},
					poiCategoryOriginal: {
						map_id: 1,
						status: 1,
						marker: 'http://old.marker.url'
					}
				},
				expectedOutput: {
					map_id: 1,
					status: 1,
					marker: 'http://marker.url'
				}
			},
			{
				input: {
					poiCategoryUpdated: {
						map_id: 1,
						status: 1,
						marker: 'http://marker.url'
					},
					poiCategoryOriginal: {
						map_id: 1,
						status: 1,
						no_marker: true
					}
				},
				expectedOutput: {
					map_id: 1,
					status: 1,
					marker: 'http://marker.url'
				}
			},
			{
				input: {
					poiCategoryUpdated: {
						map_id: 1,
						status: 1
					},
					poiCategoryOriginal: {
						map_id: 1,
						status: 1,
						marker: 'http://old.marker.url'
					}
				},
				expectedOutput: {
					map_id: 1,
					status: 1,
					marker: 'http://old.marker.url'
				}
			},
			{
				input: {
					poiCategoryUpdated: {
						map_id: 1,
						status: 1,
						marker: ''
					},
					poiCategoryOriginal: {
						map_id: 1,
						status: 1,
						no_marker: true
					}
				},
				expectedOutput: {
					map_id: 1,
					status: 1,
					marker: '',
					no_marker: true
				}
			}
		];

		testData.forEach(function (testCase) {
			var poiCategory = poiCategoriesModelModule.setPoiCategoryUpdatedData(
				testCase.input.poiCategoryUpdated, testCase.input.poiCategoryOriginal
			);
			expect(poiCategory).toEqual(testCase.expectedOutput);
		});
	});

	it('gets POI category that was updated', function () {
		expect(typeof poiCategoriesModelModule.getPoiCategoryUpdated).toBe('function');

		var testData = [
			{
				input: {
					poiCategoryOriginal: {
						id: 1,
						map_id: 1,
						marker: 'http://marker.url',
						name: 'category',
						parent_poi_category_id: 1,
						status: 1
					},
					poiCategoriesToUpdate: [
						{
							id: 1,
							map_id: 1,
							marker: '',
							name: 'modified category',
							parent_poi_category_id: 1,
							status: 1
						}
					],
					poiCategoriesUpdated: [1]
				},
				expectedOutput: {
					id: 1,
					map_id: 1,
					marker: 'http://marker.url',
					name: 'modified category',
					parent_poi_category_id: 1,
					status: 1
				}
			},
			{
				input: {
					poiCategoryOriginal: {
						id: 1,
						map_id: 1,
						marker: 'http://marker.url',
						name: 'category',
						parent_poi_category_id: 1,
						status: 1
					},
					poiCategoriesToUpdate: [
						{
							id: 2,
							map_id: 1,
							marker: '',
							name: 'some other category',
							parent_poi_category_id: 1,
							status: 1
						}
					],
					poiCategoriesUpdated: [2]
				},
				expectedOutput: null
			},
			{
				input: {
					poiCategoryOriginal: {
						id: 1,
						map_id: 1,
						marker: 'http://marker.url',
						name: 'category',
						parent_poi_category_id: 1,
						status: 1
					},
					poiCategoriesToUpdate: [
						{
							id: 1,
							map_id: 1,
							marker: '',
							name: 'modified category',
							parent_poi_category_id: 1,
							status: 1
						}
					],
					poiCategoriesUpdated: []
				},
				expectedOutput: null
			}
		];

		testData.forEach(function (testCase) {
			var poiCategory = poiCategoriesModelModule.getPoiCategoryUpdated(
				testCase.input.poiCategoryOriginal,
				testCase.input.poiCategoriesToUpdate,
				testCase.input.poiCategoriesUpdated
			);
			expect(poiCategory).toEqual(testCase.expectedOutput);
		});
	});

	it('updates POI categories data', function () {
		expect(typeof poiCategoriesModelModule.updatePoiCategoriesData).toBe('function');

		var testData = [
			{
				input: {
					dataSent: {
						mapId: 2,
						poiCategoriesToCreate: [
							{
								marker: 'http://new.marker.url',
								parent_poi_category_id: '',
								name: 'new category'
							}
						],
						poiCategoriesToUpdate: [
							{
								marker: '',
								parent_poi_category_id: 5,
								name: 'modified category',
								id: 74,
								map_id: 2,
								status: 0,
								no_marker: true
							}
						],
						poiCategoriesToDelete: [75]
					},
					dataReceived: {
						poiCategoriesCreated: [
							{
								marker: 'http://new.marker.url',
								parent_poi_category_id: 1,
								name: 'new category',
								map_id: 2,
								id: 76
							}
						],
						poiCategoriesUpdated: [74],
						poiCategoriesDeleted: [75]
					},
					poiCategoriesOriginalData: [
						{
							id: 68,
							parent_poi_category_id: 1,
							map_id: 2,
							name: 'category not to be touched',
							marker: 'http://marker.url',
							status: 1
						},
						{
							id: 74,
							parent_poi_category_id: 4,
							map_id: 2,
							name: 'to be modified',
							marker: '/assets/__cb126/vendor/leaflet/images/marker-icon.png',
							status: 0,
							no_marker: true
						},
						{
							id: 75,
							parent_poi_category_id: 1,
							map_id: 2,
							name: 'category to be deleted',
							marker: 'http://marker.url',
							status: 1
						}
					]
				},
				expectedOutput: [
					{
						id: 68,
						parent_poi_category_id: 1,
						map_id: 2,
						name: 'category not to be touched',
						marker: 'http://marker.url',
						status: 1
					},
					{
						marker: '',
						parent_poi_category_id: 5,
						name: 'modified category',
						id: 74,
						map_id: 2,
						status: 0,
						no_marker: true
					},
					{
						marker: 'http://new.marker.url',
						parent_poi_category_id: 1,
						name: 'new category',
						map_id: 2,
						id: 76
					}
				]
			}
		];

		testData.forEach(function (testCase) {
			var currentPoiCategories;

			poiCategoriesModelModule.setPoiCategoriesOriginalData(testCase.input.poiCategoriesOriginalData);
			currentPoiCategories = poiCategoriesModelModule.updatePoiCategoriesData(
				testCase.input.dataSent, testCase.input.dataReceived
			)

			expect(currentPoiCategories).toEqual(testCase.expectedOutput);
		});
	});
});
