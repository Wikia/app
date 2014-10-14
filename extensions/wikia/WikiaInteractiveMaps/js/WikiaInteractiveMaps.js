require(
	[
		'jquery',
		'wikia.querystring',
		'wikia.window',
		'wikia.intMap.utils',
		'wikia.intMap.pontoBridge'
	],
	function ($, qs, w, utils, pontoBridge) {
		'use strict';

		var body = $('body'),
			targetIframe =  w.document.getElementsByName('wikia-interactive-map')[0],
			//registry for the modal actions assets
			actions = {
				createMap: {
					module: 'wikia.intMaps.createMap.modal',
					source: {
						messages: ['WikiaInteractiveMapsCreateMap'],
						styles: [
							'extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss',
							'extensions/wikia/WikiaInteractiveMaps/css/intMapIcons.scss'
						],
						scripts: [
							'int_map_create_map_js',
							'int_map_poi_categories_js'
						],
						mustache: [
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapModal.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapChooseTileSet.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapTileSetThumb.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapCreateMapPreview.mustache'
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
				},
				unDeleteMap: {
					module: 'wikia.intMaps.unDeleteMap',
					source: {
						scripts: ['int_map_undelete_map_js']
					},
					origin: 'wikia-int-map-undelete-map',
					cacheKey: 'wikia_interactive_maps_undelete_map'
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
			})
			.on('click', '#unDeleteMap', function(event) {
				event.preventDefault();
				triggerAction('unDeleteMap');
			});

		if (targetIframe) {
			pontoBridge.init(targetIframe);
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
				utils.track(utils.trackerActions.CLICK_LINK_BUTTON, 'create-map-clicked');
			} else {
				utils.showForceLoginModal(actionConfig.origin, function() {
					utils.loadModal(actionConfig);
				});
			}
		}

		// VE Insert Map dialog passes this hash to initiate map creating process right away
		if (w.location.hash === '#createMap') {
			triggerAction('createMap');
		}
	}
);

