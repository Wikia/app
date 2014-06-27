define(
	'wikia.intMap.createMap.tileSet',
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
			uiTemplate,
			tileSetThumbTemplate,
			// template data
			templateData = {
				mapType: [
					{
						type: 'Geo',
						name: $.msg('wikia-interactive-maps-create-map-choose-type-geo')
					},
					{
						type: 'Custom',
						name: $.msg('wikia-interactive-maps-create-map-choose-type-custom')
					}
				],
				browse: $.msg('wikia-interactive-maps-create-map-browse-tile-set'),
				uploadFileBtn: $.msg('wikia-interactive-maps-create-map-upload-file')
			},
			//modal events
			events = {
				intMapGeo: [
					function() {
						modal.trigger('previewTileSet', {
							type: 'geo'
						});
						trackChosenMap('geo');
					}
				],
				intMapCustom: [
					function() {
						showStep('uploadImage');
						trackChosenMap('custom');
					}
				],
				intMapBrowse: [
					function() {
						showStep('browseTileSets');
						getTileSetThumbs();
					}
				],
				previousStep: [
					previousStep
				],
				chooseTileSet: [
					chooseTileSet
				],
				receivedTileSets: [
					showTileSetThumbs
				],
				selectTileSet: [
					function(event) {
						modal.trigger('previewTileSet', {
							type: 'custom',
							tileSetId: $(event.currentTarget).data('id')
						});
					}
				]
			},
			// steps for choose tile set
			steps = {
				selectType: {
					id: '#intMapChooseType',
					buttons: {}
				},
				uploadImage: {
					id: '#intMapImageUpload',
					buttons: {
						'#intMapBack': 'previousStep'
					}
				},
				browseTileSets: {
					id: '#intMapBrowse',
					buttons: {
						'#intMapBack': 'previousStep'
					},
					helper: getTileSetThumbs
				}
			},
			// stack for holding choose tile set steps
			stepsStack = [],
			// cached selectors
			$sections,
			$browse,
			mapTypeHasBeenChosenAlready;

		/**
		 * @desc initializes and configures UI
		 * @param {object} modalRef - modal component
		 * @param {string} _uiTemplate - mustache template for this step UI
		 * @param {string} _tileSetThumbTemplate - mustache template for tile set thumb
		 */

		function init(modalRef, _uiTemplate, _tileSetThumbTemplate) {
			modal = modalRef;
			uiTemplate = _uiTemplate;
			tileSetThumbTemplate = _tileSetThumbTemplate;
			mapTypeHasBeenChosenAlready = false;

			utils.bindEvents(modal, events);

			// set base step
			addToStack('selectType');

			// TODO: figure out where is better place to place it and move it there
			modal.$element.on('change', '#intMapUpload', function(event) {
				uploadMapImage(event.target.parentNode);
			});
		}

		/**
		 * @desc entry point for choose tile set steps
		 */

		function chooseTileSet() {
			modal.$innerContent.html(utils.render(uiTemplate, templateData));

			// cache selectors
			$sections = modal.$innerContent.children();
			$browse = $sections.filter('#intMapBrowse');

			showStep(stepsStack.pop());
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
		 * @desc loads tile sets thumbs
		 * @param {string=} searchTerm - search term, if specified loads tile set which name match this term
		 */

		function getTileSetThumbs(searchTerm) {
			$.nirvana.sendRequest({
				controller: 'WikiaInteractiveMapsMap',
				method: 'getTileSets',
				format: 'json',
				data: searchTerm ? {searchTerm: searchTerm} : null,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('receivedTileSets', data.content);
					} else {
						modal.trigger('error', data.content.message);
					}
				},
				onErrorCallback: function(response) {
					utils.handleNirvanaException(modal, response);
				}
			});
		}

		/**
		 * @desc shows tile set thumbnails
		 * @param tileSets
		 */

		function showTileSetThumbs(tileSets) {
			var html = '';

			tileSets.forEach(function(tileSet) {
				html += utils.render(tileSetThumbTemplate, tileSet);
			});

			$browse.html(html);
		}

		/**
		 * @desc uploads tile set image to backend
		 * @param {object} form - html form node element
		 */

		function uploadMapImage(form) {
			var formData = new FormData(form);

			utils.upload(modal, formData, 'map', function (data) {
				data.type = 'custom';
				modal.trigger('previewTileSet', data);
			});
		}

		/**
		 * @desc Sends to GA what map type was chosen only if the back button wasn't clicked
		 *
		 * @param {string} type
		 */
		function trackChosenMap(type) {
			var label = '';

			switch(type) {
				case 'geo':
					label = 'real-map-chosen';
					break;
				case 'custom':
					label = 'custom-map-chosen';
					break;
			}

			if( !mapTypeHasBeenChosenAlready ) {
				mapTypeHasBeenChosenAlready = true;
				utils.track(utils.trackerActions.CLICK_LINK_IMAGE, label);
			}
		}

		return {
			init: init
		};
	}
);
