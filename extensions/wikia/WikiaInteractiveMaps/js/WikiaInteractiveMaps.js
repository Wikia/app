require(
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'ponto',
		'wikia.intMap.utils'
	],
	function ($, qs, w, ponto, utils) {
		'use strict';

		var body = $('body'),
			targetIframe =  w.document.getElementsByName('wikia-interactive-map')[0],
			//registry for the modal actions assets
			actions = {
				createMap: {
					module: 'wikia.intMaps.createMap.modal',
					source: {
						messages: ['WikiaInteractiveMapsCreateMap'],
						scripts: ['int_map_create_map_js'],
						styles: [
							'extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss',
							'extensions/wikia/WikiaInteractiveMaps/css/intMapIcons.scss'
						],
						mustache: [
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapModal.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapChooseTileSet.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapTileSetThumb.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPreview.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPoiCategories.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPoiCategory.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapParentPoiCategory.mustache'
						]
					},
					origin: 'wikia-int-map-create-map',
					cacheKey: 'wikia_interactive_maps_create_map'
				},
				deleteMap: {
					module: 'wikia.intMaps.deleteMap',
					source: {
						messages: ['WikiaInteractiveMapsDeleteMap'],
						scripts: ['int_map_delete_map_js'],
						mustache: [
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapModal.mustache'
						]
					},
					origin: 'wikia-int-map-delete-map',
					cacheKey: 'wikia_interactive_maps_delete_map'
				}
			};

		// attach handlers
		body
			.on('change', '#orderMapList', function(event) {
				sortMapList(event.target.value);
			})
			.on('click', 'button#createMap', function() {
				triggerAction('createMap');
			})
			.on('click', 'a#deleteMap', function(event) {
				event.preventDefault();
				triggerAction('deleteMap');
			});

		setPontoIframeTarget(targetIframe);

		/**
		 * @desc sets iFrame target for ponto if iFrame exists
		 * @param {object} targetIframe - iFrame element
		 */
		function setPontoIframeTarget(targetIframe) {
			if (targetIframe) {
				ponto.setTarget(Ponto.TARGET_IFRAME, '*', targetIframe.contentWindow);
			}
		}

		/**
		 * @desc reload the page after choosing ordering option
		 * @param {string} sortType - sorting method
		 */
		function sortMapList(sortType) {
			qs().setVal('sort', sortType, false).goTo();
		}

		/**
		 * @desc opens modal associated with chosen action preceded by forced login modal for anons
		 * @param {string} action - name of action
		 */
		function triggerAction(action) {
			var actionConfig = actions[action];

			if (utils.isUserLoggedIn()) {
				utils.loadModal(actionConfig);
			} else {
				utils.showForceLoginModal(actionConfig.origin, function() {
					utils.loadModal(actionConfig);
				});
			}
		}
	}
);

