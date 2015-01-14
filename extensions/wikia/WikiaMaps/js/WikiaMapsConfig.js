define('wikia.maps.config', [], function () {
	'use strict';

	//registry for the modal actions assets
	var actions = {
		createMap: {
			module: 'wikia.maps.createMap.modal',
			source: {
				messages: ['WikiaMapsCreateMap'],
				styles: [
					'extensions/wikia/WikiaMaps/css/WikiaMapsModal.scss',
					'extensions/wikia/WikiaMaps/css/WikiaMapsIcons.scss'
				],
				scripts: [
					'wikia_maps_create_map_js',
					'wikia_maps_poi_categories_js'
				],
				mustache: [
					'extensions/wikia/WikiaMaps/templates/WikiaMapsModal.mustache',
					'extensions/wikia/WikiaMaps/templates/WikiaMapsCreateMapChooseTileSet.mustache',
					'extensions/wikia/WikiaMaps/templates/WikiaMapsCreateMapTileSetThumb.mustache',
					'extensions/wikia/WikiaMaps/templates/WikiaMapsCreateMapPreview.mustache'
				]
			},
			origin: 'wikia-maps-create-map',
			cacheKey: 'wikia_maps_create_map'
		},
		deleteMap: {
			module: 'wikia.maps.deleteMap',
			source: {
				messages: ['WikiaMapsDeleteMap'],
				scripts: ['wikia_maps_delete_map_js'],
				mustache: [
					'extensions/wikia/WikiaMaps/templates/WikiaMapsModal.mustache'
				]
			},
			origin: 'wikia-maps-map-delete-map',
			cacheKey: 'wikia_maps_delete_map'
		},
		undeleteMap: {
			module: 'wikia.maps.undeleteMap',
			source: {
				scripts: ['wikia_maps_undelete_map_js']
			},
			origin: 'wikia-maps-undelete-map',
			cacheKey: 'wikia_maps_undelete_map'
		}
	},
	// const variables used across Wikia Maps UI
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
