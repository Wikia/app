define('wikia.intMap.poiCategories',
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'wikia.intMap.utils'
	],
	function($, qs, w, utils) {
		'use strict';

		// reference to modal component
		var modal,

		// modal configuration
			modalConfig = {
				vars: {
					id: 'intMapPoiCategories',
					classes: ['intMapPoiCategories', 'intMapModal'],
					size: 'medium',
					content: '',
					title: '',
					buttons: [
						{
							vars: {
								value: $.msg('wikia-interactive-maps-poi-categories-save'),
								classes: ['normal', 'primary'],
								data: {
									key: 'event',
									value: 'save'
								}
							}
						}, {
							vars: {
								value: $.msg('wikia-interactive-maps-poi-categories-cancel'),
								data: {
									key: 'event',
									value: 'close'
								}
							}
						}
					]
				}
			},

		// mustache templates
			poiCategoriesTemplate,
			poiCategoryTemplate,
			parentPoiCategoryTemplate,

		// template data
			poiCategoriesTemplateData = {
				poiCategories: [],
				addPoiCategory: $.msg('wikia-interactive-maps-create-map-add-poi-category'),
				mapId: null
			},
			poiCategoryTemplateData = {
				delete: $.msg('wikia-interactive-maps-create-map-delete-poi-category'),
				placeholder: $.msg('wikia-interactive-maps-create-map-poi-category-name-placeholder'),
				emptyOption: $.msg('wikia-interactive-maps-create-map-poi-category-select-category'),
				parentPoiCategories: []
			},

			createPoiCategoriesTitle = $.msg('wikia-interactive-maps-poi-categories-header-create'),
			editPoiCategoriesTitle = $.msg('wikia-interactive-maps-poi-categories-header-edit'),

			events = {
				addPoiCategory: [
					addPoiCategory
				],
				deletePoiCategory: [
					deletePoiCategory
				],
				uploadMarkerImage: [
					uploadMarkerImage
				],
				saveMarkerImage: [
					saveMarkerImage
				],
				previewMarkerImage: [
					previewMarkerImage
				],
				save: [
					savePoiCategories
				],
				poiCategoriesCreated: [
					poiCategoriesCreated
				]
			},
			trigger,
			params,
			mapId,
			mapUrl;

		function init(templates, _params, _trigger) {
			// set reference to params and trigger callback
			trigger = _trigger;
			params = _params || {};
			mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

			poiCategoriesTemplate = templates[0];
			poiCategoryTemplate = templates[1];
			parentPoiCategoryTemplate = templates[2];

			setModalMode(typeof params !== 'undefined' && params.hasOwnProperty('id'));

			setUpParentPoiCategories()
				.then(function () {
					setUpModal(params);
				});
		}

		function setUpModal(data) {
			setUpTemplateData(data);
			mapUrl = data.mapUrl;

			modalConfig.vars.content = utils.render(poiCategoriesTemplate, poiCategoriesTemplateData, {
				poiCategory: poiCategoryTemplate,
				parentPoiCategory: parentPoiCategoryTemplate
			});

			utils.createModal(modalConfig, function (_modal) {
				// set reference to modal component
				modal = _modal;

				// cache selectors
				modal.$errorContainer = modal.$content.children('.error');
				modal.$form = $('#intMapPoiCategoriesForm');

				utils.bindEvents(modal, events);

				// TODO: figure out where is better place to place it and move it there
				modal.$element.on('change', '.poi-category-marker-image-upload', function (event) {
					modal.trigger('uploadMarkerImage', event.target);
				});

				modal.show();
			});
		}

		/**
		 * @desc sets modal mode (create POI categories / edit existing POI categories)
		 * @param {bool} isEditMode
		 */
		function setModalMode(isEditMode) {
			var title = createPoiCategoriesTitle;

			if (isEditMode) {
				title = editPoiCategoriesTitle;
			}

			modalConfig.vars.title = title;
		}

		/**
		 * @desc extends POI category
		 * @param {object} poiCategory - data for POI category
		 * @returns {object} - POI category data with default template variables
		 */
		function extendPoiCategoryData(poiCategory) {
			return $.extend(poiCategoryTemplateData, poiCategory);
		}

		/**
		 * @desc extends array of POI categories
		 * @param {Array} poiCategories - array of POI category objects
		 * @returns {Array} - array of extended POI categories objects
		 */
		function extendPoiCategoriesData(poiCategories) {
			var extendedPoiCategories = [];

			poiCategories.forEach(function (poiCategory) {
				extendedPoiCategories.push(extendPoiCategoryData(poiCategory));
			});

			return extendedPoiCategories;
		}

		/**
		 * @desc gets parent POI categories list from backend and puts it in template data
		 * @returns {object} - promise
		 */
		function setUpParentPoiCategories() {
			var dfd = new $.Deferred(),
				parentPoiCategories;

			getParentPoiCategories()
				.then(function (response) {
					var data = response.results;

					if (data && data.success) {
						parentPoiCategories = data.content;
					} else {
						modal.trigger('error', data.content.message);
						parentPoiCategories = data.content;
					}

					poiCategoryTemplateData.parentPoiCategories = parentPoiCategories;
					dfd.resolve();
				});

			return dfd.promise();
		}

		/**
		 * @desc sets up template data
		 * @param {object} existingData - existing data from DB
		 */
		function setUpTemplateData(existingData) {
			// if no POI categories display blank POI category input
			var poiCategories = existingData.poiCategories ? existingData.poiCategories : [{}];

			poiCategoriesTemplateData.mapId = existingData.id;
			poiCategoriesTemplateData.poiCategories = extendPoiCategoriesData(poiCategories);
		}

		/**
		 * @desc adds blank POI category input field
		 */
		function addPoiCategory() {
			modal.$form.append(utils.render(poiCategoryTemplate, extendPoiCategoryData({}), {
				parentPoiCategory: parentPoiCategoryTemplate
			}));
		}

		/**
		 * @desc deletes POI category
		 * @param {Event} event
		 */
		function deletePoiCategory(event) {
			$(event.target)
				.parent()
				.remove();
		}

		/**
		 * @desc uploads marker image to backend
		 * @param {Element} inputElement - file input element
		 */
		function uploadMarkerImage(inputElement) {
			var file = inputElement.files[0],
				formData = new FormData(),
				$inputElement = $(inputElement),
				$inputElementWrapper = $inputElement.closest('.poi-category-marker');

			formData.append('wpUploadFile', file);

			utils.upload(modal, formData, 'marker', function (data) {
				modal.trigger('saveMarkerImage', data, $inputElementWrapper);
				modal.trigger('previewMarkerImage', data, $inputElement, $inputElementWrapper);
			});
		}

		/**
		 * @desc hides file input and shows marker image instead
		 * @param {object} data - data returned from backend
		 * @param {$} $inputElementWrapper - file input element wrapper
		 */
		function saveMarkerImage(data, $inputElementWrapper) {
			$inputElementWrapper
				.find('.poi-category-marker-image-url')
				.val(data['fileThumbUrl']);
		}

		/**
		 * @desc hides file input and shows marker image instead
		 * @param {object} data - data returned from backend
		 * @param {$} $inputElement - file input element
		 * @param {$} $inputElementWrapper - file input element wrapper
		 */
		function previewMarkerImage(data, $inputElement, $inputElementWrapper) {
			$inputElement.addClass('hidden');
			$inputElementWrapper
				.find('.poi-category-marker-image')
				.attr('src', data['fileThumbUrl'])
				.removeClass('hidden');
		}

		/**
		 * @desc validates POI categories
		 * @param {object} serializedForm - object with serialized form
		 * @returns {object} - promise, resolves with validated form
		 */
		function validate(serializedForm) {
			var valid = false;

			if (serializedForm['poiCategoryNames[]']) {
				valid = true;
				serializedForm['poiCategoryNames[]'].forEach(function (fieldValue) {
					if (utils.isEmpty(fieldValue)) {
						valid = false;
					}
				});
			}

			if (valid) {
				modal.trigger('cleanUpError');
				return serializedForm;
			} else {
				modal.trigger('error', $.msg('wikia-interactive-maps-create-map-poi-category-form-error'));
				return false;
			}
		}

		/**
		 * @desc gets parent POI categories list from backend
		 * @returns {object} - promise
		 */
		function getParentPoiCategories() {
			return $.nirvana.sendRequest({
				controller: 'WikiaInteractiveMapsPoi',
				method: 'getParentPoiCategories',
				format: 'json',
				onErrorCallback: function (response) {
					utils.handleNirvanaException(modal, response);
				}
			});
		}

		/**
		 * @desc sends POI categories data to PHP controller
		 * @param {object} data - object with serialized and validated form
		 */
		function sendPoiCategories(data) {
			if (!data) {
				return;
			}

			$.nirvana.sendRequest({
				controller: 'WikiaInteractiveMapsPoi',
				method: 'createPoiCategories',
				format: 'json',
				data: data,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('cleanUpError');
						modal.trigger('poiCategoriesCreated', data.content);
					} else {
						modal.trigger('error', data.content.message);
					}
				},
				onErrorCallback: function(response) {
					utils.handleNirvanaException(modal, response);
				}
			});
		}

		/**
		 * @desc handler method triggered by savePoiCategories event
		 */
		function savePoiCategories() {
			sendPoiCategories(validate(utils.serializeForm(modal.$form)));
		}

		/**
		 * TODO figure out where we should put this function
		 * @desc redirects to the map page
		 */
		function poiCategoriesCreated() {
			qs(mapUrl).goTo();
		}

		return {
			init: init
		}
	}
);
