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
			templateData = {
				pinTypes: [],
				addPinType: $.msg('wikia-interactive-maps-create-map-choose-type-geo')
			},
			events = {
				mapCreated: [
					function(mapData) {
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
			};

		function init(_modal, _pinTypesTemplate, _pinTypeTemplate) {
			modal = _modal;
			pinTypesTemplate = _pinTypesTemplate;
			pinTypeTemplate = _pinTypeTemplate;

			utils.bindEvents(modal, events);
		}

		function showPinTypes(mapData) {

			modal.$innerContent.html(utils.render(pinTypesTemplate, templateData, {pinType: pinTypeTemplate}));

			utils.setButtons(modal, buttons);
		}

		function validate(data) {

		}

		function savePinTypes(data) {

		}



	}
);
