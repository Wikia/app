define(
	'wikia.intMaps.createMap.ui',
	[
		'jquery',
		'wikia.window',
		'wikia.mustache',
		'wikia.querystring',
		'wikia.intMaps.createMap.config',
		'wikia.intMaps.createMap.bridge'
	],
	function($, w, mustache, qs, config, bridge) {
		'use strict';

		// placeholder for holding reference to modal instance
		var createMapModal,
			// placeholder for caching create map flow modal sections
			modalSections,
			// placeholder for caching create map modal buttons
			modalButtons,
			// placeholder for validation error name
			validationError,
			// holds last step of create map flow
			lastStep = 0,
			// holds current step of create map flow
			currentStep = 0,
			// placeholder for mustache templates
			mustacheTemplates,
			// modal event handlers
			modalEvents = {
				next: nextStep,
				back: previousStep,
				intMapCustom: function() {
					switchStep(1);
				},
				intMapGeo: function() {
					switchStep(2);
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
				switchStep(0);
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

		function nextStep() {
			if (canMoveToNextStep()) {
				switchStep(currentStep + 1);
			} else {
				displayError(currentStep);
			}
		}

		/**
		 * @desc switches to the previous step in create map flow
		 */

		function previousStep() {
			switchStep(lastStep);
		}

		/**
		 * @desc switches to the given step in create map flow
		 * @param {number} index - step index
		 */

		function switchStep(index) {
			if( config.steps[index] ) {
				setStep(index);
				showStepContent(index);
				showStepModalButtons(index);
			} else {
				createMap();
			}
		}

		/**
		 * @desc sets current step in create map flow
		 * @param {number} index - step index
		 */

		function setStep(index) {
			lastStep = currentStep;
			currentStep = index;
		}

		/**
		 * @desc shows step content
		 * @param {number} index - step index
		 */

		function showStepContent(index) {
			var id = config.steps[index].id;

			modalSections.addClass(config.hiddenClass);
			modalSections.filter(id).removeClass(config.hiddenClass);
		}

		/**
		 * @desc shows step buttons
		 * @param {number} index - step index
		 */

		function showStepModalButtons(index) {
			var buttons = Object.keys(config.steps[index].buttons || {});

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
					preparePreviewStep(data);
					switchStep(2);
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
		 * @desc prepares image preview and  data for requests to int map service
		 * @param {object} data - params needed to display image preview and prepare data for requests to int map service
		 */

		function preparePreviewStep(data) {
			var templateData = {
				titlePlaceholder: $.msg('wikia-interactive-maps-create-map-title-placeholder'),
				orgImage: data.fileUrl,
				tileSetId: data.tileSetId,
				thumbnailUrl: data.fileThumbUrl,
				userName: w.wgUserName
			};

			$(config.steps[2].id).html(mustache.render(mustacheTemplates[1], templateData));
		}

		function createMap() {
			var mapData = {};

			mapData.title = $('#intMapTitle').val();
			mapData.image = $('#intMapOrgImg').val();
			mapData.tileSetId = $('#intMapTileSet').val();

			bridge.createMap(
				mapData,
				function(data) {
				// map created, go to its page
					qs(data.mapUrl).goTo();
				},
				function(data) {
					validationError = 'notImplemented';
					displayError(currentStep);
				}
			);
		}

		/**
		 * Returns true if switching to next step is allowed
		 * @returns {boolean}
		 */

		function canMoveToNextStep() {
			var canMove = true;

			switch (currentStep) {
				case 2:
					// the step after choosing/uploading map
					// it requires valid map title
					canMove = isMapTitleValid();
					break;
			}

			return canMove;
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
			var $errorContainer = $('.map-creation-error');

			$errorContainer.html('');
			$errorContainer.html(config.steps[index].errorMsgKeys[validationError]);
			$errorContainer.removeClass(config.hiddenClass);
		}

		return {
			init: init
		};
	}
);
