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
				],
				mapCreated: [
					showPoiCategoriesModal
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
			$title,

			//TODO we should move all of them to single file
			actions = {
				poiCategories: {
					module: 'wikia.intMap.poiCategories',
					source: {
						messages: ['WikiaInteractiveMapsPoiCategories'],
						scripts: ['int_map_poi_categories_js'],
						styles: ['extensions/wikia/WikiaInteractiveMaps/css/intMapModal.scss'],
						mustache: [
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapPoiCategories.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapPoiCategory.mustache',
							'extensions/wikia/WikiaInteractiveMaps/templates/intMapParentPoiCategory.mustache'
						]
					},
					origin: 'wikia-int-map-poi-categories',
					cacheKey: 'wikia_interactive_maps_poi_categories'
				}
			};

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
				},
				onErrorCallback: function(response) {
					utils.handleNirvanaException(modal, response);
				}
			});
		}

		function showPoiCategoriesModal() {
			modal.trigger('close');
			triggerAction('poiCategories');
			//TODO utils.loadModal() with idMap in params
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

		return {
			init: init
		}
});
