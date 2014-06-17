define('wikia.intMap.createMap.pinTypes',
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
			// mustache templates
			pinTypesTemplate,
			pinTypeTemplate,
			// template data
			pinTypesTemplateData = {
				pinTypes: [],
				addPinType: $.msg('wikia-interactive-maps-create-map-add-pin-type'),
				mapId: null
			},
			pinTypeTemplateData = {
				delete: $.msg('wikia-interactive-maps-create-map-delete-pin-type'),
				placeholder: $.msg('wikia-interactive-maps-create-map-pin-type-name-placeholder')
			},

			events = {
				mapCreated: [
					showPinTypes
				],
				addPinType: [
					addPinType
				],
				deletePinType: [
					deletePinType
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
				savePinTypes: [
					savePinTypes
				],
				pinTypesCreated: [
					pinTypesCreated
				]
			},
			buttons = {
				'#intMapNext': 'savePinTypes'
			},
			mapUrl,
			// marker image upload entry point
			uploadEntryPoint = '/wikia.php?controller=WikiaInteractiveMaps&method=upload&uploadType=marker&format=json',
			$form;

		/**
		 * @desc initializes pin types step
		 * @param {object} _modal
		 * @param {string} _pinTypesTemplate
		 * @param {string} _pinTypeTemplate
		 */
		function init(_modal, _pinTypesTemplate, _pinTypeTemplate) {
			modal = _modal;
			pinTypesTemplate = _pinTypesTemplate;
			pinTypeTemplate = _pinTypeTemplate;

			utils.bindEvents(modal, events);

			// TODO: figure out where is better place to place it and move it there
			modal.$element.on('change', '.pin-type-marker-image-upload', function (event) {
				modal.trigger('uploadMarkerImage', event.target);
			});
		}

		/**
		 * @desc shows pin types form
		 * @param {object} data
		 */
		function showPinTypes(data) {
			setUpTemplateData(data);
			mapUrl = data.mapUrl;

			modal.$innerContent.html(utils.render(pinTypesTemplate, pinTypesTemplateData, {pinType: pinTypeTemplate}));

			// cache selectors
			$form = modal.$innerContent.find('#intMapPinTypes');

			utils.setButtons(modal, buttons);
		}

		/**
		 * @desc extends pin type
		 * @param {object} pinType - data for pin type
		 * @returns {object} - pin type data with default template variables
		 */
		function extendPinTypeData(pinType) {
			return $.extend(pinTypeTemplateData, pinType);
		}

		/**
		 * @desc extends array of pin types
		 * @param {Array} pinTypes - array of pin type objects
		 * @returns {Array} - array of extended pin types objects
		 */
		function extendPinTypesData(pinTypes) {
			var extendedPinTypes = [];

			pinTypes.forEach(function(pinType) {
				extendedPinTypes.push(extendPinTypeData(pinType));
			});

			return extendedPinTypes;
		}

		/**
		 * @desc sets up template data
		 * @param {object} templateData - template data
		 */
		function setUpTemplateData(templateData) {
			// if no pin types display blank pin type input
			var pinTypes = templateData.pinTypes ? templateData.pinTypes : [{}];

			pinTypesTemplateData.mapId = templateData.id;
			pinTypesTemplateData.pinTypes = extendPinTypesData(pinTypes);
		}

		/**
		 * @desc adds blank pin type input field
		 */
		function addPinType() {
			$form.append(utils.render(pinTypeTemplate, extendPinTypeData({})));
		}

		/**
		 * @desc deletes pin type
		 * @param {Event} event
		 */
		function deletePinType(event) {
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
				$inputElementWrapper = $inputElement.closest('.pin-type-marker');

			formData.append('wpUploadFile', file);

			utils.upload(modal, formData, uploadEntryPoint, function (data) {
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
				.find('.pin-type-marker-image-url')
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
				.find('.pin-type-marker-image')
				.attr('src', data['fileThumbUrl'])
				.removeClass('hidden');
		}

		/**
		 * @desc validates pin types
		 * @param {object} serializedForm - object with serialized form
		 * @returns {object} - promise, resolves with validated form
		 */
		function validate(serializedForm) {
			var valid = false;

			if (serializedForm['pinTypeNames[]']) {
				valid = true;
				serializedForm['pinTypeNames[]'].forEach(function (fieldValue) {
					if (utils.isEmpty(fieldValue)) {
						valid = false;
					}
				});
			}

			if (valid) {
				modal.trigger('cleanUpError');
				return serializedForm;
			} else {
				modal.trigger('error', $.msg('wikia-interactive-maps-create-map-pin-type-form-error'));
				return false;
			}
		}

		/**
		 * @desc sends pin types data to PHP controller
		 * @param {object} data - object with serialized and validated form
		 */
		function sendPinTypes(data) {
			if (!data) {
				return;
			}

			$.nirvana.sendRequest({
				controller: 'WikiaInteractiveMaps',
				method: 'createPinTypes',
				format: 'json',
				data: data,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('cleanUpError');
						modal.trigger('pinTypesCreated', data.content);
					} else {
						modal.trigger('error', data.content.message);
					}
				},
				onErrorCallback: function(response) {
					modal.trigger('error', response.results.content.message);
				}
			});
		}

		/**
		 * @desc handler method triggered by savePinTypes event
		 */
		function savePinTypes() {
			sendPinTypes(validate(utils.serializeForm($form)));
		}

		/**
		 * TODO figure out where we should put this function
		 * @desc redirects to the map page
		 */
		function pinTypesCreated() {
			qs(mapUrl).goTo();
		}

		return {
			init: init
		}
	}
);
