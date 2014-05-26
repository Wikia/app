define('wikia.intMap.createMap.preview', ['jquery', 'wikia.window', 'wikia.intMap.createMap.utils'], function($, w, utils) {
	'use strict';

	// reference to modal component
	var modal,
		// mustache template
		template,
		// template data
		templateData = {
			titlePlaceholder: $.msg('wikia-interactive-maps-create-map-title-placeholder'),
			tileSetData:  null,
			userName: w.wgUserName
		},
		//modal events
		events = {
			previewTileSet: [
				function(data) {
					preview(data);
				}
			],
			createMap: [
				validateTitle,
				createMap
			],
			mapCreated: [
				function(data) {
					console.log('Map created: ', data);
				}
			]
		},
		// modal buttons and events for them in this setp
		buttons = {
			'#intMapBack': 'chooseTileSet',
			'#intMapNext': 'createMap'
		},
		// tile set data for map creation
		tileSetData,
		// reference to the type of tile set
		type,
		// selector for title input
		$title;

	/**
	 * @desc initializes and configures UI
	 * @param {object} modalRef - modal component
	 * @param {string} mustacheTemplate - mustache template
	 */

	function init(modalRef, mustacheTemplate) {
		modal = modalRef;
		template = mustacheTemplate;


		utils.bindEvents(modal, events);
	}

	/**
	 * @desc shows preview step before creating a map
	 * @param {object} tileSet - chosen tile set data
	 */

	function preview(tileSet) {
		// set tileSetData
		type = tileSet.type;
		tileSetData = tileSet.data;
		templateData.tileSetData = tileSetData;

		utils.render(template, templateData, modal.$innerContent);
		utils.setButtons(modal, buttons);

		// cache title selector
		$title = $('#intMapTitle');
	}


	/**
	 * @desc validates title
	 */

	function validateTitle() {
		var title = $title.val().trim();

		if (title.length !== 0) {
			// add valid title to tile set data
			tileSetData.title = title;
		} else {
			modal.trigger('error', 'Title must be set');
		}
	}

	/**
	 * @desc sends create map request to backend
	 */

	function createMap() {
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMaps',
			method: 'createMap',
			format: 'json',
			data: tileSetData,
			callback: function(response) {
				var data = response.results;

				if (data && data.success) {
					modal.trigger('mapCreated', data);
				} else {
					modal.trigger('error', response);
				}
			},
			onErrorCallback: function(response) {
				modal.trigger('error', response);
			}
		});
	}

	return {
		init: init
	}
});
