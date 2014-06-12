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
			// create map modal assets
			createMapConfig = {
				module: 'wikia.intMaps.createMap.modal',
				source: {
					messages: ['WikiaInteractiveMapsCreateMap'],
					scripts: ['int_map_create_map_js'],
					styles: ['extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss'],
					mustache: [
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapModal.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapChooseTileSet.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapTileSetThumb.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPreview.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPinTypes.mustache',
						'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPinType.mustache'
					]
				},
				cacheKey: 'wikia_interactive_maps_create_map',
				origin: 'wikia-int-map-create-map'
			};

		// attach handlers
		body
			.on('change', '#orderMapList', function(event) {
				sortMapList(event.target.value);
			})
			.on('click', '#createMap', function() {
				createMap();
			});

		setPontoIframeTarget(targetIframe);

		/**
		 * @desc reload the page after choosing ordering option
		 * @param {string} sortType - sorting method
		 */
		function sortMapList(sortType) {
			qs().setVal('sort', sortType, false).goTo();
		}

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
		 * @desc opens create map modal preceded by forced login modal for anons
		 */
		function createMap() {
			if (utils.isUserLoggedIn()) {
				utils.loadModal(createMapConfig);
			} else {
				utils.showForceLoginModal(createMapConfig.origin, function() {
					utils.loadModal(createMapConfig);
				});
			}
		}
	}
);
