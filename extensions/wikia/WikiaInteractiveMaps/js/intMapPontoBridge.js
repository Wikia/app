define('wikia.intMap.pontoBridge', ['wikia.window', 'ponto', 'wikia.intMap.utils'], function(w, ponto, utils) {
	'use strict';

	// configuration for interactive map modals triggered by Ponto
	// TODO: maybe we could move all actions config to external file?
	var actions = {
			editPOI: {
				source: {
					messages: ['WikiaInteractiveMapsEditPOI'],
					scripts: ['int_map_edit_poi_js'],
					styles: ['extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss'],
					mustache: ['extensions/wikia/WikiaInteractiveMaps/templates/intMapEditPOI.mustache']
				},
				cacheKey: 'wikia_interactive_maps_edit_poi',
				module: 'wikia.intMap.editPOI'
			}
		};

	/**
	 * @desc Ponto scope object required for communication between iframe and window
	 * @constructor
	 */
	function PontoBridge() {
		/**
		 * @desc triggers different modals in interactive maps client
		 * @param {{action: {string}, data: {}}} params - action to be triggered by client, data to be sent to this action
		 * @param {number} callbackId - required by iframe to figure out the origin of response from the client
		 */
		this.processData = function(params, callbackId) {
			utils.loadModal(actions[params.action], params.data, function(response) {
				Ponto.respond(response, callbackId);
			});
		}
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(PontoBridge);
	PontoBridge.getInstance = function() {
		return new PontoBridge();
	};

	return PontoBridge;
});
