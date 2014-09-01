define('wikia.intMap.config', [], function () {
	'use strict';

	//registry for the modal actions assets
	var actions = {
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
	},
	// const variables used across int map UI
	constants = {
		debounceDelay: 250,
		minCharLength: 2,
		mapNotDeleted: 0,
		mapDeleted: 1
	};

	return {
		actions: actions,
		constants: constants
	};
});
