define(
	'wikia.maps.createMap.tileSet',
	[
		'jquery',
		'wikia.window',
		'wikia.maps.config',
		'wikia.maps.utils'
	],
	function ($, w, config, utils) {
		'use strict';

		// reference to modal component
		var modal,
			// mustache template
			uiTemplate,
			tileSetThumbTemplate,
			// template data
			templateData = {
				chooseTypeTip: $.msg('wikia-interactive-maps-create-map-choose-type-tip'),
				chooseTypeTipLink: $.msg('wikia-interactive-maps-create-map-choose-type-tip-link'),
				mapType: [
					{
						type: 'custom',
						name: $.msg('wikia-interactive-maps-create-map-choose-type-custom'),
						event: 'browseTileSets',
						image: ''
					}
				],
				chooseTileSetTip: $.msg('wikia-interactive-maps-create-map-choose-tile-set-tip'),
				browse: $.msg('wikia-interactive-maps-create-map-browse-tile-set'),
				uploadLink: $.msg('wikia-interactive-maps-create-map-upload-file'),
				searchPlaceholder: $.msg('wikia-interactive-maps-create-map-search-tile-set-placeholder'),
				clearSearch: $.msg('wikia-interactive-maps-create-map-clear-tile-set-search')
			},
			//modal events
			events = {
				chooseTileSet: [
					chooseTileSet
				],
				browseTileSets: [
					function () {
						showStep('browseTileSet');
					}
				],
				clearSearch: [
					loadDefaultTileSets
				],
				selectTileSet: [
					selectTileSet
				],
				uploadTileSetImage: [
					function () {
						$uploadInput.click();
					}
				],
				previousStep: [
					previousStep
				]
			},
			// steps for choose tile set
			steps = {
				selectType: {
					id: '#intMapChooseType',
					buttons: {}
				},
				browseTileSet: {
					id: '#intMapBrowse',
					buttons: {
						'#intMapBack': 'previousStep'
					},
					helper: loadDefaultTileSets
				}
			},
			noTileSetMsg = $.msg('wikia-interactive-maps-create-map-no-tile-set-found'),
			// stack for holding choose tile set steps
			stepsStack = [],
			cachedTileSets = {},
			thumbSize = 116,
			// cached selectors
			$sections,
			$tileSetsContainer,
			$uploadInput,
			$clearSearchBtn,
			$searchInput;

		/**
		 * @desc initializes and configures UI
		 * @param {object} _modal - modal component
		 * @param {string} _uiTemplate - mustache template for this step UI
		 * @param {string} _tileSetThumbTemplate - mustache template for tile set thumb
		 */
		function init(_modal, _uiTemplate, _tileSetThumbTemplate) {
			modal = _modal;
			uiTemplate = _uiTemplate;
			tileSetThumbTemplate = _tileSetThumbTemplate;

			utils.bindEvents(modal, events);

			// set base step
			addToStack('selectType');

			// TODO: figure out where is better place to place it and move it there
			modal.$element
				.on('change', '#intMapUpload', function (event) {
					uploadNewTileSetImage(event.target);
				})
				.on('keyup', '#intMapTileSetSearch', $.debounce(config.constants.debounceDelay, searchForTileSets));

		}

		/**
		 * @desc Render Choose tile set modal
		 */
		function renderChooseTileSet() {
			modal.$innerContent.html(utils.render(uiTemplate, templateData));

			// cache selectors
			$sections = modal.$innerContent.children();
			$tileSetsContainer = $('#intMapTileSetsList');
			$uploadInput =  $('#intMapUpload');
			$clearSearchBtn = $('#intMapClearSearch');
			$searchInput = $('#intMapTileSetSearch');

			showStep(stepsStack.pop());
		}

		/**
		 * @desc entry point for choose tile set steps
		 */
		function chooseTileSet() {
			$.nirvana.getJson(
				'WikiaMapsSpecial',
				'getRealMapImageUrl',
				function (data) {
					templateData.mapType[0].image = data.url;
					renderChooseTileSet();
				},
				renderChooseTileSet
			);
		}

		/**
		 * @desc adds step to steps stack
		 * @param {string} step - key of the step
		 */
		function addToStack(step) {
			stepsStack.push(step);
		}

		/**
		 * @desc shows step content
		 * @param {string} id - step is
		 */
		function showStepContent(id) {
			$sections.addClass('hidden');
			$sections.filter(id).removeClass('hidden');
		}

		/**
		 * @desc shows the given step in choose tile set flow
		 * @param {string} stepName - name of the step
		 */
		function showStep(stepName) {
			var step = steps[stepName];

			addToStack(stepName);
			showStepContent(step.id);
			utils.setButtons(modal, step.buttons);

			if (typeof step.helper === 'function') {
				step.helper();
			}

			modal.trigger('cleanUpError');

		}

		/**
		 * @desc switches to the previous step in create map flow
		 */
		function previousStep() {
			// removes current step from stack
			stepsStack.pop();
			showStep(stepsStack.pop());
		}

		/**
		 * @desc handler function for selecting tile set
		 * @param {Event} event
		 */
		function selectTileSet(event) {
			var $target = $(event.currentTarget),
				mapTypeChosen = $target.data('type');

			utils.track(utils.trackerActions.CLICK_LINK_IMAGE, mapTypeChosen + '-map-chosen');

			modal.trigger('previewTileSet', {
				type: mapTypeChosen,
				tileSetId: $target.data('id'),
				originalImageURL: $target.data('image')
			});
		}

		/**
		 * @desc handler function for search tile set input field
		 * @param {Event} event - search term
		 */
		function searchForTileSets(event) {
			utils.onWriteInInput(event.target, config.constants.minCharLength, function (inputValue) {
				loadTileSets(inputValue);
				$clearSearchBtn.removeClass('hidden');
			});
		}

		/**
		 * @desc loads defaults tile set list
		 */
		function loadDefaultTileSets() {
			clearSearchFilter();
			loadTileSets();
		}

		/**
		 * @desc handler for clearing search filter
		 */
		function clearSearchFilter() {
			$clearSearchBtn.addClass('hidden');
			$searchInput.val('');
		}

		/**
		 * @desc loads tile sets thumbs
		 * @param {string=} keyWord - search term
		 */
		function loadTileSets(keyWord) {
			getTileSets(keyWord || null, function (tileSetData) {
				updateTileSetList(renderTileSetsListMarkup(tileSetThumbTemplate, createThumbsUrls(tileSetData)));
			});
		}

		/**
		 * @desc get tile sets from cache of send requests to backend and ache the response
		 * @param {string} keyWord - cache key
		 * @param {function} cb - callback function
		 */
		function getTileSets(keyWord, cb) {
			var key = keyWord || 'default',
				tileSets = cachedTileSets[key];

			if (typeof tileSets !== 'undefined') {
				cb(tileSets);
			} else {
				requestTileSets(keyWord, function (tileSets) {
					cacheTileSets(key, tileSets);
					cb(tileSets);
				});
			}
		}

		/**
		 * @desc add tile sets to cache object
		 * @param {string} key - key in cache object
		 * @param {array} tileSets - tile sets array
		 */
		function cacheTileSets(key, tileSets) {
			cachedTileSets[key] = tileSets;
		}

		/**
		 * @desc sends request to backend for tile sets
		 * @param {string} searchTerm - search keyword
		 * @param {function} cb - callback function
		 */
		function requestTileSets(searchTerm, cb) {
			$.nirvana.sendRequest({
				controller: 'WikiaMapsMap',
				method: 'getTileSets',
				format: 'json',
				type: 'GET',
				data: searchTerm ? {searchTerm: searchTerm} : null,
				callback: function (response) {
					var data = response.results;

					if (data && data.success) {
						cb(data.content);
					} else {
						modal.trigger('error', data.content.message);
					}

					modal.activate();
				},
				onErrorCallback: function (response) {
					modal.activate();
					utils.handleNirvanaException(modal, response);
				}
			});
		}

		/**
		 * @desc change image urls for each tile set to thumb url
		 * @param {array} tileSets
		 * @returns {array} - tileSets
		 */
		function createThumbsUrls(tileSets) {
			tileSets.forEach(function (element) {
				element.tileSetThumb = utils.createThumbURL(element.image, thumbSize, thumbSize);
			});

			return tileSets;
		}

		/**
		 * @desc renders tile set thumbs markup
		 * @param {string} template - mustache template
		 * @param {array} tileSets - array of tile set objects
		 * @returns {string} - HTML markup
		 */
		function renderTileSetsListMarkup(template, tileSets) {
			var html = '';

			tileSets.forEach(function (tileSet) {
				html += utils.render(template, tileSet);
			});

			return html;
		}

		/**
		 * @desc removes old tile sets from list and adds new one
		 * @param {string} markup - HTML markup
		 */
		function updateTileSetList(markup) {
			$tileSetsContainer.children('.tile-set-thumb').remove();
			modal.trigger('cleanUpError');

			if (markup) {
				$tileSetsContainer.append(markup);
			} else {
				modal.trigger('error', noTileSetMsg);
			}
		}

		/**
		 * @desc uploads tile set image to backend
		 */
		function uploadNewTileSetImage(inputElement) {
			var formData = utils.getFormDataForFileUpload(inputElement);

			utils.upload(modal, formData, 'map', function (data) {
				data.type = 'custom';
				modal.trigger('previewTileSet', data);
			});
		}

		return {
			init: init
		};
	}
);
