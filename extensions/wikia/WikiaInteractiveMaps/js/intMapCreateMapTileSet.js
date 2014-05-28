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
			// constant with the id tileset of map of Earth
			geoTilesetId = 1,
			// mustache template
			template,
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
				uploadFileBtn: $.msg('wikia-interactive-maps-create-map-upload-file')
			},
			//modal events
			events = {
				intMapGeo: [
					function() {
						modal.trigger('previewTileSet', {
							type: 'geo',
							data: {
								tileSetId: geoTilesetId
							}
						});
					}
				],
				intMapCustom: [
					function() {
						showStep('uploadImage');
					}
				],
				previousStep: [
					previousStep
				],
				chooseTileSet: [
					chooseTileSet
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
					buttons: {}
				}
			},
			// image upload entry point
			uploadEntryPoint = '/wikia.php?controller=WikiaInteractiveMaps&method=uploadMap&format=json',
			// stack for holding choose tile set steps
			stepsStack = [],
			// cached selectors
			$sections;

		/**
		 * @desc initializes and configures UI
		 * @param {object} modalRef - modal component
		 * @param {string} mustacheTemplate - mustache template
		 */

		function init(modalRef, mustacheTemplate) {
			modal = modalRef;
			template = mustacheTemplate;

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
			modal.$innerContent.html(utils.render(template, templateData));

			// cache selectors
			$sections = modal.$innerContent.children();

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
						modal.trigger('error', response.error);
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
