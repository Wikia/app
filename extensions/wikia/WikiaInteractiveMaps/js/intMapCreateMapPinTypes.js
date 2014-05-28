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
				mapCreated: [
					showPinTypes
				],
				savePinTypes: [
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

		function validate(data) {

		}

		/**
		 * @desc adds blank pin type input field
		 */
		function addPinType() {
			$form.append(utils.render(pinTypeTemplate, extendPinTypeData({})));

		}

		function savePinTypes(data) {

		}

		return {
			init: init
		}
	}
);
