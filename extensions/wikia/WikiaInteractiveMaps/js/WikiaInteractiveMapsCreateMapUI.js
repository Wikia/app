define(
	'wikia.intMaps.createMap.ui',
	[
		'jquery',
		'wikia.window',
		'wikia.mustache',
		'wikia.intMaps.createMap.config',
		'wikia.intMaps.createMap.bridge'
	],
	function($, w, mustache, config, bridge) {
		'use strict';

		// placeholder for holding reference to modal instance
		var createMapModal,
			// placeholder for caching create map flow modal sections
			modalSections,
			// placeholder for caching create map modal buttons
			modalButtons,
			// stack for holding modal steps
			stack =[],
			// placeholder for validation error name
			validationError,
			// placeholder for mustache templates
			mustacheTemplates,
			// modal event handlers
			modalEvents = {
				next: createMap,
				back: previousStep,
				intMapCustom: function() {
					switchStep('customTileSet');
				},
				intMapGeo: function() {
					// TODO: need geo map data
					renderCreateMapStep({});
					switchStep('createMap');
				}
			};

		// TODO: figure out where is better place to place it and move it there
		$('body').on('change', '#intMapUpload', function(event) {
			uploadMapImage($(event.target).parent().get(0));
		});


		/**
		 * @desc Entry point for create map modal
		 * @param {array} templates - mustache templates
		 */

		function init(templates) {
			// set reference to mustache templates
			mustacheTemplates = templates;

			renderModalContentMarkup(config.modalConfig, templates[0], config.templateData);

			createModal(config.modalConfig, function() {
				// cache modal sections and buttons
				modalSections = createMapModal.$content.children();
				modalButtons = createMapModal.$element.find('.buttons').children();

				bindEvents(createMapModal, modalEvents);
				// set initial create map step
				switchStep('tileSetType');
				createMapModal.show();
			});
		}

		/**
		 * @desc renders HTML markup and adds it to modal config
		 * @param {object} modalConfig - modal configuration
		 * @param {string} template - mustache template
		 * @param {object} data - mustache template data
		 */

		function renderModalContentMarkup(modalConfig, template, data) {
			modalConfig.vars.content = mustache.render(template, data);
		}

		/**
		 * @desc prepares image preview and  data for requests to int map service
		 * @param {object} data - params needed to display image preview and prepare data for requests to int map service
		 */

		function renderCreateMapStep(data) {
			var templateData = {
				titlePlaceholder: $.msg('wikia-interactive-maps-create-map-title-placeholder'),
				orgImage: data.fileUrl,
				tileSetId: data.tileSetId,
				thumbnailUrl: data.fileThumbUrl,
				userName: w.wgUserName
			};

			$(config.steps.createMap.id).html(mustache.render(mustacheTemplates[1], templateData));
		}

		/**
		 * @desc creates modal component
		 * @param {object} config - modal config
		 * @param {function} cb - callback function called after creating modal
		 */

		function createModal(config, cb) {
			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(function (uiModal) {
					uiModal.createComponent(config, function (modal) {
						// set reference to modal component
						createMapModal = modal;

						cb();
					});
				});
			});
		}

		/**
		 * @desc binds events to modal
		 * @param {object} modal - instance of modal component
		 * @param {object} events - events to be bind to the modal
		 */

		function bindEvents(modal, events) {
			Object.keys(events).forEach(function(event) {
				modal.bind(event, events[event]);
			});
		}

		/**
		 * @desc switches to the next step in create map flow
		 */

		function createMap() {
			// TODO: add create map logic
		}

		/**
		 * @desc switches to the previous step in create map flow
		 */

		function previousStep() {
			// removes current step from stack
			stack.pop();

			switchStep(stack.pop());
		}

		/**
		 * @desc switches to the given step in create map flow
		 * @param {string} step - key of the step
		 */

		function switchStep(step) {
			addToStack(step);
			showStepContent(step);
			showStepModalButtons(step);
		}

		/**
		 * @desc adds step to steps stack
		 * @param {string} step - key of the step
		 */

		function addToStack(step) {
			stack.push(step);
		}

		/**
		 * @desc shows step content
		 * @param {string} step - key of the step
		 */

		function showStepContent(step) {
			modalSections.addClass(config.hiddenClass);
			modalSections.filter(config.steps[step].id).removeClass(config.hiddenClass);
		}

		/**
		 * @desc shows step buttons
		 * @param {string} step - key of the step
		 */

		function showStepModalButtons(step) {
			var buttons = config.steps[step].buttons || [];

			modalButtons.addClass(config.hiddenClass);

			buttons.forEach(function(id) {
				modalButtons.filter(id).removeClass(config.hiddenClass);
			});
		}

		/**
		 * @desc Handler for uploading map image
		 * @param {object} form - html form node element
		 */

		function uploadMapImage(form) {
			bridge.uploadMapImage(
				form,
				function(data) {
					renderCreateMapStep(data);
					switchStep('createMap');
				},
				function(data) {
					handleUploadErrors(data);
				}
			);
		}

		/**
		 * @desc Handles upload errors&exceptions
		 * @param {object} response
		 */

		function handleUploadErrors( response ) {
			// TODO: handle errors (MOB-1626)
		}

		/**
		 * Validates map title
		 * @returns {boolean}
		 */

		function isMapTitleValid() {
			var title = $('#intMapTitle').val(),
				result = true;

			if (title.length === 0 || !title.trim()) {
				validationError = 'invalidTitle';
				result = false;
			}

			return result;
		}

		/**
		 * Gets correct data from steps configuration to display a validation error
		 * @param index
		 */

		function displayError(index) {
			var $errorContainer = $('.map-creation-error'),
				errorMessage = $.msg(config.steps[index].errorMsgKeys[validationError]);

			$errorContainer.html('');
			$errorContainer.html(errorMessage);
			$errorContainer.removeClass(config.hiddenClass);
		}

		return {
			init: init
		};
	}
);
