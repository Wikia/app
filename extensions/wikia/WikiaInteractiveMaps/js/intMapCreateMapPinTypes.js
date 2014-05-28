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
				placeholder: 'dadasdasd'
			},

			events = {
				mapCreated: [
					function(mapData) {
						console.log(mapData);
						showPinTypes(mapData);
					}
				],
				savePinTypes: [
					function(data) {
						validate(data);
					},
					function(data) {
						savePinTypes(data);
					}
				]
			},
			buttons = {
				'#intMapNext': 'savePinTypes'
			},
			mapUrl;

		function init(_modal, _pinTypesTemplate, _pinTypeTemplate) {
			modal = _modal;
			pinTypesTemplate = _pinTypesTemplate;
			pinTypeTemplate = _pinTypeTemplate;

			utils.bindEvents(modal, events);
		}

		function showPinTypes(data) {
			var pinTypes = data.pinTypes ? data.pinTypes : [{}];

			pinTypesTemplateData.mapId = data.mapId;
			pinTypesTemplateData.pinTypes = extendPinTypesData(pinTypes);
			mapUrl = data.mapUrl;

			modal.$innerContent.html(utils.render(pinTypesTemplate, templateData, {pinType: pinTypeTemplate}));

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

		function validate(data) {

		}

		function savePinTypes(data) {

		}

		return {
			init: init
		}
	}
);
