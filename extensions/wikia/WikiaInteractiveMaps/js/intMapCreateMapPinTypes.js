define('wikia.intMap.createMap.pinTypes',
	[
		'jquery',
		'wikia.window',
		'wikia.intMap.createMap.utils'
	],
	function($, w, utils) {
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
				addPinType: [
					addPinType
				],
				deletePinType: [
					deletePinType
				],
				mapCreated: [
					showPinTypes
				],
				savePinTypes: [
					serializeForm,
					validate,
					savePinTypes
				]
			},
			buttons = {
				'#intMapNext': 'savePinTypes'
			},
			mapUrl,
			$form;

		function init(_modal, _pinTypesTemplate, _pinTypeTemplate) {
			modal = _modal;
			pinTypesTemplate = _pinTypesTemplate;
			pinTypeTemplate = _pinTypeTemplate;

			utils.bindEvents(modal, events);
		}

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

		function setUpTemplateData(templateData) {
			// if no pin types display blank pin type input
			var pinTypes = templateData.pinTypes ? templateData.pinTypes : [{}];

			pinTypesTemplateData.mapId = templateData.mapId;
			pinTypesTemplateData.pinTypes = extendPinTypesData(pinTypes);
		}

		function serializeForm() {
			var serializedForm = {},
				formArray = $form.serializeArray(),
				dfd = new $.Deferred();

			$.each(formArray, function (i, element) {
				var name = element.name,
					value = element.value;

				serializedForm[name] = !/\[\]$/.test(name) ?
					value :
					$.isArray(serializedForm[name]) ?
						serializedForm[name].concat(value) :
						[value];
			});

			dfd.resolve(serializedForm);
			return dfd.promise();
		}

		function validate() {
			var serializedForm = arguments[1],
				valid = true,
				dfd = new $.Deferred();

			if (serializedForm['pinTypeNames[]']) {
				serializedForm['pinTypeNames[]'].forEach(function (fieldValue) {
					if (!(fieldValue.length > 0)) {
						valid = false;
					}
				});
			}

			if (valid) {
				dfd.resolve(serializedForm);
			} else {
				//TODO
				modal.trigger('error', 'Form is not valid');
				dfd.reject();
			}

			return dfd.promise();
		}

		function savePinTypes() {
			var serializedForm = arguments[2];

			$.nirvana.sendRequest({
				controller: 'WikiaInteractiveMaps',
				method: 'createPinTypes',
				format: 'json',
				data: serializedForm,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('pinTypesCreated', data);
					} else {
						modal.trigger('error', data.exception.details);
					}
				},
				onErrorCallback: function(response) {
					modal.trigger('error', JSON.parse(response.responseText).exception.details);
				}
			});
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

		return {
			init: init
		}
	}
);
