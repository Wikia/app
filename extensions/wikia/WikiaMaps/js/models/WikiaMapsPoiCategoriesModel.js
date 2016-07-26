define('wikia.maps.poiCategories.model',
	[
		'jquery',
		'wikia.maps.utils'
	],
	function ($, utils) {
		'use strict';

		var poiCategoriesOriginalData,
			controllerName = 'WikiaMapsPoiCategory';

		/**
		 * @desc sets POI categories original data
		 * @param {Array} data
		 */
		function setPoiCategoriesOriginalData(data) {
			poiCategoriesOriginalData = data;
		}

		/**
		 * @desc gets parent POI categories list from backend
		 * @returns {object} - promise
		 */
		function getParentPoiCategories() {
			return $.nirvana.sendRequest({
				controller: controllerName,
				method: 'getParentPoiCategories',
				format: 'json'
			});
		}

		/**
		 * @desc sends POI categories data to PHP controller
		 * @param {object} data - object with serialized and validated form
		 */
		function sendPoiCategories(data) {
			return $.nirvana.sendRequest({
				controller: controllerName,
				method: 'editPoiCategories',
				format: 'json',
				data: data
			});
		}

		/**
		 * @desc returns true if POI category is invalid
		 * @param {object} poiCategory
		 * @returns {boolean} - is valid
		 */
		function isPoiCategoryInvalid(poiCategory) {
			return utils.isEmpty(poiCategory.name);
		}

		/**
		 * @desc checks if POI category data was changed by user
		 * @param {object} poiCategoryOriginal
		 * @param {object} poiCategory
		 * @returns {boolean} - is POI category changed
		 */
		function isPoiCategoryChanged(poiCategoryOriginal, poiCategory) {
			if (poiCategory.name !== poiCategoryOriginal.name) {
				return true;
			}

			if (poiCategory.parent_poi_category_id !== poiCategoryOriginal.parent_poi_category_id) {
				return true;
			}

			// if marker property is not empty it means there was a new image uploaded
			return !!poiCategory.marker;
		}

		/**
		 * @desc checks if POI category was deleted
		 * @param {object} poiCategory
		 * @param {Array} poiCategoriesDeleted
		 * @returns {boolean}
		 */
		function isPoiCategoryDeleted(poiCategory, poiCategoriesDeleted) {
			return poiCategoriesDeleted &&
			poiCategoriesDeleted.indexOf(poiCategory.id) > -1;
		}

		/**
		 * @desc finds POI category in array by looking at ids
		 * @param {Number} id - POI category id
		 * @param {Array} poiCategories - array of POI categories
		 * @returns {object|null} - POI category with given id or null if not found
		 */
		function findPoiCategoryById(id, poiCategories) {
			return $.grep(poiCategories, function (item) {
				return item.id === id;
			})[0] || null;
		}

		/**
		 * @desc cleans up POI category properties
		 * @param {object} poiCategory
		 * @returns {object} - cleand up POI category
		 */
		function cleanUpPoiCategory(poiCategory) {
			if (poiCategory.id) {
				poiCategory.id = parseInt(poiCategory.id, 10);
			} else {
				delete poiCategory.id;
			}

			if (poiCategory.parent_poi_category_id) {
				poiCategory.parent_poi_category_id = parseInt(poiCategory.parent_poi_category_id, 10);
			}

			return poiCategory;
		}

		/**
		 * @desc organizes form data to object that will be sent to backend
		 * @param {object} formSerialized
		 * @returns {object} - organized POI categories data
		 */
		function organizePoiCategories(formSerialized) {
			var poiCategories = {
				mapId: parseInt(formSerialized.mapId, 10),
				poiCategoriesToCreate: [],
				poiCategoriesToUpdate: [],
				poiCategoriesToDelete: []
			};

			formSerialized.poiCategories.forEach(function (poiCategory) {
				var poiCategoryOriginal;

				poiCategory = cleanUpPoiCategory(poiCategory);

				if (poiCategory.id) {
					poiCategoryOriginal = findPoiCategoryById(poiCategory.id, poiCategoriesOriginalData);

					if (poiCategoryOriginal && isPoiCategoryChanged(poiCategoryOriginal, poiCategory)) {
						poiCategories.poiCategoriesToUpdate.push(poiCategory);
					}
				} else {
					poiCategories.poiCategoriesToCreate.push(poiCategory);
				}
			});

			if (formSerialized.poiCategoriesToDelete) {
				poiCategories.poiCategoriesToDelete = formSerialized.poiCategoriesToDelete
					.trim()
					.split(' ')
					.map(Number);
			}

			return poiCategories;
		}

		/**
		 * @desc cleans up POI category data after updating it, copies what's needed from the original data
		 * @param {object} poiCategoryUpdated
		 * @param {object} poiCategoryOriginal
		 * @returns {object} - POI category with current data
		 */
		function setPoiCategoryUpdatedData(poiCategoryUpdated, poiCategoryOriginal) {
			poiCategoryUpdated.map_id = poiCategoryOriginal.map_id;
			poiCategoryUpdated.status = poiCategoryOriginal.status;
			poiCategoryUpdated.marker = (!poiCategoryOriginal.no_marker && !poiCategoryUpdated.marker) ?
				poiCategoryOriginal.marker :
				poiCategoryUpdated.marker;

			if (poiCategoryOriginal.no_marker && !poiCategoryUpdated.marker) {
				// if the original category had no_marker flag set as true and there is no new marker - keep the flag
				poiCategoryUpdated.no_marker = true;
			}

			return poiCategoryUpdated;
		}

		/**
		 * @desc gets POI category that was updated, returns null if it wasn't
		 * @param {object} poiCategoryOriginal
		 * @param {Array} poiCategoriesToUpdate - POI categories to update, sent to backend
		 * @param {Array} poiCategoriesUpdated - response from backend, array of updated categories
		 * @returns {object|null} - updated POI category or null
		 */
		function getUpdatedPoiCategory(poiCategoryOriginal, poiCategoriesToUpdate, poiCategoriesUpdated) {
			var poiCategoryUpdated = null;

			if (utils.inArray(poiCategoriesUpdated, poiCategoryOriginal.id)) {
				poiCategoryUpdated = findPoiCategoryById(poiCategoryOriginal.id, poiCategoriesToUpdate);
				if (poiCategoryUpdated) {
					poiCategoryUpdated = setPoiCategoryUpdatedData(poiCategoryUpdated, poiCategoryOriginal);
				}
			}

			return poiCategoryUpdated;
		}

		/**
		 * @desc prepares POI categories for sending them back to Ponto
		 * @param {object} dataSent - POI categories sent to backend
		 * @param {object} dataReceived - response from backend, array of actions done and categories affected
		 * @returns {Array} - current POI categories list
		 */
		function preparePoiCategoriesForPonto(dataSent, dataReceived) {
			var currentPoiCategories = [];

			poiCategoriesOriginalData.forEach(function (poiCategoryOriginal) {
				var poiCategoryUpdated = getUpdatedPoiCategory(
					poiCategoryOriginal, dataSent.poiCategoriesToUpdate, dataReceived.poiCategoriesUpdated
				);

				if (poiCategoryUpdated) {
					// POI category updated
					currentPoiCategories.push(poiCategoryUpdated);
				} else if (!utils.inArray(dataReceived.poiCategoriesDeleted, poiCategoryOriginal.id)) {
					// POI category not changed
					currentPoiCategories.push(poiCategoryOriginal);
				}

				// POI category deleted, it shouldn't be sent to Ponto so we skip it
			});

			if (dataReceived.poiCategoriesCreated) {
				dataReceived.poiCategoriesCreated.forEach(function (poiCategory) {
					// POI category created
					currentPoiCategories.push(poiCategory);
				});
			}

			return currentPoiCategories;
		}

		return {
			setPoiCategoriesOriginalData: setPoiCategoriesOriginalData,
			getParentPoiCategories: getParentPoiCategories,
			sendPoiCategories: sendPoiCategories,
			isPoiCategoryInvalid: isPoiCategoryInvalid,
			isPoiCategoryChanged: isPoiCategoryChanged,
			isPoiCategoryDeleted: isPoiCategoryDeleted,
			findPoiCategoryById: findPoiCategoryById,
			cleanUpPoiCategory: cleanUpPoiCategory,
			organizePoiCategories: organizePoiCategories,
			setPoiCategoryUpdatedData: setPoiCategoryUpdatedData,
			getUpdatedPoiCategory: getUpdatedPoiCategory,
			preparePoiCategoriesForPonto: preparePoiCategoriesForPonto
		};
	}
);
