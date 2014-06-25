define(
	'wikia.intMap.createMap.preview',
	[
		'jquery',
		'wikia.window',
		'wikia.intMap.utils'
	],
	function($, w, utils) {
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
				]
			},
			// modal buttons and events for them in this step
			buttons = {
				'#intMapBack': 'chooseTileSet',
				'#intMapNext': 'createMap'
			},
			// tile set data for map creation
			tileSetData,
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
			modal.trigger('cleanUpError');

			tileSetData = tileSet;
			templateData.tileSetData = tileSetData;
			modal.$innerContent.html(utils.render(template, templateData));
			utils.setButtons(modal, buttons);

			// cache input title selector
			$title = $('#intMapTitle');
		}

		/**
		 * @desc validates title
		 */

		function validateTitle() {
			var dfd = new $.Deferred(),
				title = $title.val();

			if (!utils.isEmpty(title)) {
				// add valid title to tile set data
				tileSetData.title = title;
				dfd.resolve();
			} else {
				modal.trigger('error', 'Title must be set');
				dfd.reject();
			}

			return dfd.promise();
		}

		/**
		 * @desc sends create map request to backend
		 */

		function createMap() {
			modal.deactivate();

			$.nirvana.sendRequest({
				controller: 'WikiaInteractiveMapsMap',
				method: 'createMap',
				format: 'json',
				data: tileSetData,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('cleanUpError');
						modal.trigger('mapCreated', data.content);
					} else {
						modal.trigger('error', data.content.message);
					}

					modal.activate();
				},
				onErrorCallback: function(response) {
					modal.trigger('error', response.results.content.message);
					modal.activate();
				}
			});
		}

		return {
			init: init
		}
});
