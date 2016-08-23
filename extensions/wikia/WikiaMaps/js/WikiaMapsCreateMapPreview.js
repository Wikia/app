define(
	'wikia.maps.createMap.preview',
	[
		'jquery',
		'wikia.window',
		'wikia.maps.utils'
	],
	function($, w, utils) {
		'use strict';

		// reference to modal component
		var modal,
			// mustache template
			template,
			// template data
			templateData = {
				titleLabel: $.msg('wikia-interactive-maps-create-map-title-label'),
				titlePlaceholder: $.msg('wikia-interactive-maps-create-map-title-placeholder'),
				tileSetTitleLabel: $.msg('wikia-interactive-maps-create-map-tile-set-title-label'),
				tileSetTitlePlaceholder: $.msg('wikia-interactive-maps-create-map-tile-set-title-placeholder'),
				previewImgAlt: $.msg('wikia-interactive-maps-create-map-tile-set-image-preview-alt'),
				tileSetData:  null
			},
			//modal events
			events = {
				previewTileSet: [
					preview
				],
				createMap: [
					createMap
				],
				mapCreated: [
					triggerStorageEvent,
					showPoiCategoriesModal
				],
				beforeClose: [
					function() {
						utils.onBeforeCloseModal(!wasMapAdded);
					}
				]
			},
			// modal buttons and events for them in this step
			buttons = {
				'#intMapBack': 'chooseTileSet',
				'#intMapNext': 'createMap'
			},
			// tile set data for map creation
			tileSetData,
			// preview Thumb width
			thumbWidth = 660,
			// selector for title inputs
			$textFields,

			//TODO we should move all of them to single file
			actions = {
				poiCategories: {
					module: 'wikia.maps.poiCategories',
					source: {
						messages: ['WikiaMapsPoiCategories'],
						scripts: ['wikia_maps_poi_categories_js'],
						styles: ['extensions/wikia/WikiaMaps/css/WikiaMapsModal.scss'],
						mustache: [
							'extensions/wikia/WikiaMaps/templates/WikiaMapsPoiCategories.mustache',
							'extensions/wikia/WikiaMaps/templates/WikiaMapsPoiCategory.mustache',
							'extensions/wikia/WikiaMaps/templates/WikiaMapsParentPoiCategory.mustache'
						]
					},
					origin: 'wikia-maps-poi-categories',
					cacheKey: 'wikia_maps_poi_categories'
				}
			},
			wasMapAdded = false;

		/**
		 * @desc initializes and configures UI
		 *
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
		 *
		 * @param {object} tileSet - chosen tile set data
		 */
		function preview(tileSet) {
			var originalImageURL = tileSet.originalImageURL;
			modal.trigger('cleanUpError');

			tileSetData = tileSet;

			if(originalImageURL) {
				tileSetData.originalImageURL = utils.createThumbURL(originalImageURL, thumbWidth);
			}

			templateData.tileSetData = tileSetData;
			modal.$innerContent.html(utils.render(template, templateData));
			utils.setButtons(modal, buttons);

			// cache input title selector
			$textFields = modal.$innerContent.find('input[type="text"]');
		}

		/**
		 * @desc handler for create map event
		 */
		function createMap() {
			if (validateData()) {
				wasMapAdded = true;
				createMapRequest();
			}
		}

		/**
		 * @desc validates map creation form data and extends tile set data if valid
		 * @returns {boolean}
		 */
		function validateData() {
			var isValid = true;

			$textFields.each(function() {
				var value = validateInput($(this));

				if (value) {
					tileSetData[$(this).attr('name')] = value;
					return true;
				} else {
					isValid = false;
					return false;
				}
			});

			return isValid;
		}

		/**
		 * @desc validates input field
		 * @param {object} $element - jQuery selector object
		 * @returns {string|boolean} - input value or false if not valid
		 */
		function validateInput($element) {
			var errorMsg = 'wikia-interactive-maps-create-map-validation-error-',
				value = $element.val();

			if (utils.isEmpty(value)) {
				value = false;
				modal.trigger('error', $.msg(errorMsg + $element.attr('name')));
			}

			return value;
		}

		/**
		 * @desc sends create map request to backend
		 */
		function createMapRequest() {
			modal.deactivate();

			$.nirvana.sendRequest({
				controller: 'WikiaMapsMap',
				method: 'createMap',
				format: 'json',
				type: 'POST',
				data: tileSetData,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('cleanUpError');
						modal.trigger('mapCreated', data.content);
						trackMapCreation(tileSetData);
					} else {
						modal.trigger('error', data.content.message);
					}

					modal.activate();
				},
				onErrorCallback: function(response) {
					utils.handleNirvanaException(modal, response);
					modal.activate();
				}
			});
		}

		function showPoiCategoriesModal(data) {
			modal.trigger('close');
			triggerAction('poiCategories', {
				mapId: data.id,
				mapUrl: data.mapUrl
			});
			utils.track(utils.trackerActions.IMPRESSION, 'poi-category-modal-shown');
		}

		/**
		 * @desc trigger "storage" event (by calling localStorage.setItem) after the map is created
		 */
		function triggerStorageEvent(data) {
			if ( localStorage ) {
				localStorage.setItem('mapCreated', data.id);
				setTimeout(function() {
					localStorage.removeItem('mapCreated');
				}, 0);
			}
		}

		/**
		 * @desc opens modal associated with chosen action preceded by forced login modal for anons
		 *
		 * @param {string} action - name of action
		 * @param {object} params
		 */
		function triggerAction(action, params) {
			var actionConfig = actions[action];

			if (utils.isUserLoggedIn()) {
				utils.loadModal(actionConfig, params);
			} else {
				utils.showForceLoginModal(actionConfig.origin, function() {
					utils.loadModal(actionConfig, params);
				});
			}
		}

		/**
		 * @desc Sends tracking data to GA depending on tileSetData
		 *
		 * @param {object} tileSetData
		 */
		function trackMapCreation(tileSetData) {
			var tileSetId = tileSetData.tileSetId,
				mapTypeChosen = tileSetData.type,
				label = mapTypeChosen + '-map-created' + (!tileSetId ? '-with-new-tileset' : '');

			utils.track(utils.trackerActions.IMPRESSION, label, tileSetId);
		}

		return {
			init: init
		};
});
