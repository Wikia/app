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
				module: 'wikia.intMap.editPOI',
				origin: 'wikia-interactive-maps-edit-poi'
			},
			poiCategories: {
				source: {
					messages: ['WikiaInteractiveMapsPoiCategories'],
					scripts: ['int_map_poi_categories_js'],
					styles: [
						'extensions/wikia/WikiaInteractiveMaps/css/intMapIcons.scss',
						'extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss'
					],
					mustache: [
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapPoiCategories.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapPoiCategory.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapParentPoiCategory.mustache'
					]
				},
				origin: 'wikia-int-map-poi-categories',
				module: 'wikia.intMap.poiCategories',
				cacheKey: 'wikia_interactive_maps_poi_categories'
			},
			embedMapCode: {
				noLoginRequired: true,
				source: {
					messages: ['WikiaInteractiveMapsEmbedMapCode'],
					scripts: ['int_map_embed_map_code'],
					styles: ['extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss'],
					mustache: ['extensions/wikia/WikiaInteractiveMaps/templates/intMapEmbedMapCode.mustache']
				},
				cacheKey: 'wikia_interactive_embed_map_code',
				module: 'wikia-interactive-embed-map-code'
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
			var actionConfig = actions[params.action],
				data = params.data;

			if (actionConfig.hasOwnProperty('noLoginRequired') || utils.isUserLoggedIn()) {
				utils.loadModal(actionConfig, data, function(response) {
					Ponto.respond(response, callbackId);
				});
			} else {
				utils.showForceLoginModal(actionConfig.origin, function() {
					utils.loadModal(actionConfig, data, function(response) {
						Ponto.respond(response, callbackId);
					});
				});
			}
		};

		/**
		 * @desc returns Wikia settings to the map in iframe
		 */
		this.getWikiaSettings = function() {
			return {
				enableEdit: true,
				skin: w.skin
			};
		};
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(PontoBridge);
	PontoBridge.getInstance = function() {
		return new PontoBridge();
	};

	return PontoBridge;
});
