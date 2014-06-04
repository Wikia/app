define('wikia.intMap.createMap.pinTypes',
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'wikia.intMap.createMap.utils'
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
				savePinTypes: [
					serializeForm,
					function(event, serializedForm) {
						return validate(serializedForm);
					},
					function(event, serializedForm, validatedForm) {
						return savePinTypes(validatedForm);
					}
				],
				pinTypesCreated: [
					pinTypesCreated
				]
			},
			buttons = {
				'#intMapNext': 'savePinTypes'
			},
			mapUrl,
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

			pinTypesTemplateData.mapId = templateData.mapId;
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
		 * TODO it's universal and should be extracted
		 * @desc serializes form
		 * @returns {object} - promise, resolves with serialized form
		 */
		function serializeForm() {
			var serializedForm = {},
				formArray = $form.serializeArray(),
				fieldNameIsArrayRegex = /\[\]$/,
				dfd = new $.Deferred();

			$.each(formArray, function (i, element) {
				var name = element.name,
					value = element.value;

				if (fieldNameIsArrayRegex.test(name)) {
					if ($.isArray(serializedForm[name])) {
						serializedForm[name].push(value);
					} else {
						serializedForm[name] = [value];
					}
				} else {
					serializedForm[name] = value;
				}
			});

			dfd.resolve(serializedForm);
			return dfd.promise();
		}

		/**
		 * @desc validates pin types
		 * @param {object} serializedForm - object with serialized form
		 * @returns {object} - promise, resolves with validated form
		 */
		function validate(serializedForm) {
			var valid = false,
				dfd = new $.Deferred();

			if (serializedForm['pinTypeNames[]']) {
				valid = true;
				serializedForm['pinTypeNames[]'].forEach(function (fieldValue) {
					if (!(fieldValue.length > 0)) {
						valid = false;
					}
				});
			}

			if (valid) {
				modal.trigger('cleanUpError');
				dfd.resolve(serializedForm);
			} else {
				modal.trigger('error', $.msg('wikia-interactive-maps-create-map-pin-type-form-error'));
				dfd.reject();
			}

			return dfd.promise();
		}

		/**
		 * @desc sends pin types data to PHP controller
		 * @param {object} validatedForm - object with serialized and validated form
		 */
		function savePinTypes(validatedForm) {
			$.nirvana.sendRequest({
				controller: 'WikiaInteractiveMaps',
				method: 'createPinTypes',
				format: 'json',
				data: validatedForm,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('cleanUpError');
						modal.trigger('pinTypesCreated', data);
					} else {
						modal.trigger('error', data.error);
					}
				},
				onErrorCallback: function(response) {
					modal.trigger('error', JSON.parse(response.responseText).exception.details);
				}
			});
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
