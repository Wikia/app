define('wikia.intMap.poiCategories',
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'wikia.intMap.utils',
		'wikia.intMap.poiCategories.model'
	],
	function($, qs, w, utils, poiCategoriesModel) {
		'use strict';

		// reference to modal component
		var modal,

		// modal configuration
			modalConfig = {
				vars: {
					id: 'intMapPoiCategories',
					classes: ['int-map-modal'],
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
				addPoiCategory: $.msg('wikia-interactive-maps-poi-categories-add'),
				mapId: null
			},
			poiCategoryTemplateData = {
				delete: $.msg('wikia-interactive-maps-poi-categories-delete'),
				placeholder: $.msg('wikia-interactive-maps-poi-categories-name-placeholder'),
				emptyOption: $.msg('wikia-interactive-maps-poi-categories-select-category'),
				uploadImgLink: $.msg('wikia-interactive-maps-poi-categories-upload-image-link'),
				iconSize: 34,
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
				poiCategoriesSaved: [
					poiCategoriesSaved
				],
				triggerMarkerUpload: [
					triggerMarkerUpload
				],
				beforeClose: [
					onBeforeClose
				]
			},
			pontoTrigger,
			params,
			mapId,
			mapUrl,
			mode,
			modalModes = {
				CREATE: 'create',
				EDIT: 'edit'
			},
			changesSaved;

		/**
		 * @desc Entry point for modal
		 * @param {Array} templates - mustache templates
		 * @param {object} _params - params from iframe (ponto) or map creation modal
		 * @param {function} _trigger - callback function to send result back to iframe (ponto)
		 */
		function init(templates, _params, _trigger) {
			// set reference to params and trigger callback
			pontoTrigger = _trigger;
			params = _params;
			mapId = params.mapId;

			poiCategoriesTemplate = templates[0];
			poiCategoryTemplate = templates[1];
			parentPoiCategoryTemplate = templates[2];

			setModalMode();

			setUpParentPoiCategories()
				.then(function () {
					setUpModal(params);
				});
		}

		/**
		 * @desc Triggers refresh if needed after forced login
		 */
		function onBeforeClose(){
			if (!changesSaved) {
				utils.refreshIfAfterForceLogin();
			}
		}
		/**
		 * @desc Sets up modal config and creates it
		 * @param {object} data - params passed to modal
		 */
		function setUpModal(data) {
			setUpTemplateData(data);
			mapUrl = data.mapUrl;
			poiCategoriesModel.setPoiCategoriesOriginalData(data.poiCategories);

			modalConfig.vars.title = (mode === modalModes.EDIT) ? editPoiCategoriesTitle : createPoiCategoriesTitle;

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
				modal.$poiCategoriesToDeleteElement = $('#poiCategoriesToDelete');

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
		 */
		function setModalMode() {
			mode = params.mode || modalModes.CREATE;
		}

		/**
		 * @desc marks chosen parent POI category as selected
		 * @param {Array} parentPoiCategories
		 * @param {Number} id
		 * @returns {Array} - updated parent POI categories
		 */
		function markParentPoiCategoryAsSelected(parentPoiCategories, id) {
			parentPoiCategories.forEach(function (parentPoiCategory, i) {
				if (parentPoiCategory.id === id) {
					parentPoiCategories[i].selected = ' selected';
				} else {
					parentPoiCategories[i].selected = null;
				}
			});

			return parentPoiCategories;
		}

		/**
		 * @desc extends POI category
		 * @param {object} poiCategory - data for POI category
		 * @param {object} poiCategoryTemplateData
		 * @returns {object} - POI category data with default template variables
		 */
		function extendPoiCategoryData(poiCategory, poiCategoryTemplateData) {
			// clone this object so we don't overwrite default template data
			var extendedPoiCategoryTemplateData = $.extend(true, {}, poiCategoryTemplateData);

			extendedPoiCategoryTemplateData.id = poiCategory.id;
			extendedPoiCategoryTemplateData.name = poiCategory.name;

			if (!poiCategory.no_marker) {
				extendedPoiCategoryTemplateData.marker = poiCategory.marker;
			}

			extendedPoiCategoryTemplateData.parentPoiCategories = markParentPoiCategoryAsSelected(
				extendedPoiCategoryTemplateData.parentPoiCategories, poiCategory.parent_poi_category_id
			);

			return extendedPoiCategoryTemplateData;
		}

		/**
		 * @desc extends array of POI categories
		 * @param {Array} poiCategories - array of POI category objects
		 * @returns {Array} - array of extended POI categories objects
		 */
		function extendPoiCategoriesData(poiCategories) {
			var extendedPoiCategories = [];

			poiCategories.forEach(function (poiCategory) {
				extendedPoiCategories.push(extendPoiCategoryData(poiCategory, poiCategoryTemplateData));
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

			poiCategoriesModel.getParentPoiCategories()
				.then(function (response) {
					var data = response.results;

					if (data && data.success) {
						parentPoiCategories = data.content;
					} else {
						utils.showError(modal, data.content.message);
						parentPoiCategories = data.content;
					}

					poiCategoryTemplateData.parentPoiCategories = parentPoiCategories;
					dfd.resolve();
				}, function (response) {
					utils.handleNirvanaException(modal, response);
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

			poiCategoriesTemplateData.mapId = existingData.id || mapId;
			poiCategoriesTemplateData.poiCategories = extendPoiCategoriesData(poiCategories);
		}

		/**
		 * @desc adds blank POI category input field
		 */
		function addPoiCategory() {
			var poiCategoryDataExtended = extendPoiCategoryData({}, poiCategoryTemplateData);
			modal.$form.append(utils.render(poiCategoryTemplate, poiCategoryDataExtended, {
				parentPoiCategory: parentPoiCategoryTemplate
			}));
		}

		/**
		 * @desc deletes POI category
		 * @param {Event} event
		 */
		function deletePoiCategory(event) {
			var poiCategoryContainer = $(event.target).closest('.poi-category'),
				poiCategoryId = poiCategoryContainer.data('id');

			if (poiCategoryId) {
				markPoiCategoryAsDeleted(poiCategoryId);
			}

			poiCategoryContainer.remove();
		}

		/**
		 * @desc adds POI category id to hidden field
		 * @param poiCategoryId
		 */
		function markPoiCategoryAsDeleted(poiCategoryId) {
			// add POI category id to hidden field
			modal.$poiCategoriesToDeleteElement.val(modal.$poiCategoriesToDeleteElement.val() + ' ' + poiCategoryId);
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
			$inputElement.val('');
			$inputElementWrapper
				.find('.poi-category-marker-image')
				.attr('src', data['fileThumbUrl'])
				.removeClass('hidden')
				.siblings('span')
				.addClass('hidden');
		}

		/**
		 * @desc validates POI categories
		 * @param {object} formSerialized - object with serialized form
		 * @returns {boolean} - is valid
		 */
		function validateFormData(formSerialized) {
			var poiCategoriesLength,
				i;

			if (!formSerialized.poiCategories) {
				utils.showError(modal, $.msg('wikia-interactive-maps-poi-categories-form-no-category-error'));
				return false;
			}

			poiCategoriesLength = formSerialized.poiCategories.length;
			for (i = 0; i < poiCategoriesLength; i++) {
				if (poiCategoriesModel.isPoiCategoryInvalid(formSerialized.poiCategories[i])) {
					utils.showError(modal, $.msg('wikia-interactive-maps-poi-categories-form-error'));
					return false;
				}
			}

			return true;
		}

		/**
		 * @desc sends POI categories data to PHP controller
		 * @param {object} data - object with serialized and validated form
		 */
		function sendPoiCategories(data) {
			if (!data) {
				return;
			}

			modal.deactivate();
			poiCategoriesModel.sendPoiCategories(data)
				.then(function (response) {
					var results = response.results;

					if (results && results.success) {
						utils.cleanUpError(modal);
						modal.trigger('poiCategoriesSaved', data, results.content);
						utils.track(utils.trackerActions.IMPRESSION, 'poi-category-' + mode, data.mapId);
					} else {
						utils.showError(modal, results.content.message);
						modal.activate();
					}
				}, function (response) {
					utils.handleNirvanaException(modal, response);
					modal.activate();
				});
		}

		/**
		 * @desc handler method triggered by savePoiCategories event
		 */
		function savePoiCategories() {
			var formSerialized = modal.$form.serializeObject();

			if (validateFormData(formSerialized)) {
				sendPoiCategories(poiCategoriesModel.organizePoiCategories(formSerialized));
			}
		}

		/**
		 * @desc Handler for poiCategoriesSaved event. Sends data to Ponto and closes the modal or redirects to map page
		 * @param {object} dataSent - POI categories sent to backend
		 * @param {object} dataReceived - response from backend, array of actions done and categories affected
		 */
		function poiCategoriesSaved(dataSent, dataReceived) {
			changesSaved = true;
			if (mode === modalModes.EDIT) {
				if (typeof pontoTrigger === 'function') {
					pontoTrigger(poiCategoriesModel.preparePoiCategoriesForPonto(dataSent, dataReceived));
				}
				modal.trigger('close');
			} else {
				qs(mapUrl).goTo();
			}
		}

		/**
		 * @desc handler for triggering upload form for marker image
		 * @param {Event} event
		 */
		function triggerMarkerUpload(event) {
			$(event.currentTarget).siblings('.poi-category-marker-image-upload').click();
		}

		return {
			init: init,
			markParentPoiCategoryAsSelected: markParentPoiCategoryAsSelected,
			extendPoiCategoryData: extendPoiCategoryData,
			poiCategoryTemplateData: poiCategoryTemplateData // for unit tests
		};
	}
);
