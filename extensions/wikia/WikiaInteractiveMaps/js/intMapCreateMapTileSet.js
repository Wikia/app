define(
	'wikia.intMap.createMap.tileSet',
	[
		'jquery',
		'wikia.window',
		'wikia.intMap.createMap.utils'
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
				browse: 'Browse existing tile sets',
				uploadFileBtn: $.msg('wikia-interactive-maps-create-map-upload-file')
			},
			//modal events
			events = {
				intMapGeo: [
					function() {
						modal.trigger('previewTileSet', {});
					}
				],
				intMapCustom: [
					function() {
						showStep('uploadImage');
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
							data: {
								tileSetId: $(event.currentTarget).data('id')
							}
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
			// image upload entry point
			uploadEntryPoint = '/wikia.php?controller=WikiaInteractiveMaps&method=uploadMap&format=json',
			// stack for holding choose tile set steps
			stepsStack = [],
			// cached selectors
			$sections,
			$browse;

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
				controller: 'WikiaInteractiveMaps',
				method: 'getTileSets',
				format: 'json',
				data: searchTerm ? {searchTerm: searchTerm} : null,
				callback: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('receivedTileSets', data.tileSets);
					} else {
						modal.trigger('error', data.error);
					}
				},
				onErrorCallback: function(response) {
					modal.trigger('error', response.results.error);
				}
			});
		}

		function showTileSetThumbs(tileSets) {
			var html = '';

			tileSets.forEach(function(tileSet) {
				html += utils.render(tileSetThumbTemplate, tileSet);
			});

			$browse.html(html);
		}

		/**
		 * @desc uploads image to backend
		 * @param {object} form - html form node element
		 */

		function uploadMapImage(form) {
			$.ajax({
				contentType: false,
				data: new FormData(form),
				processData: false,
				type: 'POST',
				url: w.wgScriptPath + uploadEntryPoint,
				success: function(response) {
					var data = response.results;

					if (data && data.success) {
						modal.trigger('previewTileSet', {
							type: 'uploaded',
							data: data
						});
					} else {
						modal.trigger('error', data.errors.pop());
					}
				},
				error: function(response) {
					modal.trigger('error', response.results.error);
				}
			});
		}

		return {
			init: init
		};
	}
);
