define('wikia.intMaps.createMapUI', ['jquery', 'wikia.window', 'wikia.mustache'], function ($, w, mustache) {
	'use strict';

	var doc = w.document,
		body = doc.getElementsByTagName('body')[0],
		// placeholder for holding reference to modal instance
		createMapModal,
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
		// holds config for each step
		steps = [{
			id: 'intMapsChooseType'
		}, {
			id: 'intMapsChooseTileSet',
			buttons: {
				intMapBack: true
			}
		}, {
			id: 'intMapsAddTitle',
			buttons: {
				intMapBack: true,
				intMapNext: true
			},
			errorMsgKeys: {
				invalidTitle: 'wikia-interactive-maps-create-map-error-invalid-map-title'
			}
		}, {
			id: 'intMapsPinTypes',
			buttons: {
				intMapBack: true,
				intMapNext: true
			}
		}],
		// class used for hiding elements
		hiddenClass = 'hidden',
		// modal configuration
		modalConfig = {
			vars: {
				id: 'intMapCreateMapModal',
				classes: ['intMapCreateMapModal'],
				size: 'medium',
				content: '',
				title: $.msg('wikia-interactive-maps-create-map-header'),
				buttons: [{
					vars: {
						value: $.msg('wikia-interactive-maps-create-map-next-btn'),
						classes: ['normal', 'primary'],
						id: 'intMapNext',
						data: [{
							key: 'event',
							value: 'next'
						}]
					}
				}, {
					vars: {
						value: $.msg('wikia-interactive-maps-create-map-back-btn'),
						id: 'intMapBack',
						data: [{
							key: 'event',
							value: 'back'
						}]
					}
				}]
			}
		},
		// data for mustache template
		templateData = {
			mapType: [{
				type: 'Geo',
				name: $.msg('wikia-interactive-maps-create-map-choose-type-geo')
			}, {
				type: 'Custom',
				name: $.msg('wikia-interactive-maps-create-map-choose-type-custom')
			}],
			uploadFileBtn: $.msg('wikia-interactive-maps-create-map-upload-file'),
			titlePlaceholder: $.msg('wikia-interactive-maps-create-map-title-placeholder')
		},
		// modal event handlers
		modalEvents = {
			next: nextStep,
			back: previousStep,
			intMapCustom: function () {
				switchStep(1);
			},
			intMapGeo: function () {
				switchStep(2);
			}
		};

	// TODO: figure out where is better place to place it and move it there
	body.addEventListener('change', function (event) {
		var target = event.target;

		if (target.id === 'intMapUpload') {
			uploadMap($(target).parent().get(0));
		}
	});

	/**
	 * @desc Sends and AJAX request to upload map image
	 * @param {object} form
	 */

	function uploadMap(form) {
		var entryPoint = '/wikia.php?controller=WikiaInteractiveMaps&method=uploadMap&format=json';

		$.ajax({
			type: 'POST',
			url: w.wgScriptPath + entryPoint,
			data: new FormData(form),
			success: function (response) {
				var res = response.results;
				if (res && res.isGood) {
					$('#intMapPreviewImage').attr('src', res.fileUrl);
					nextStep();
				} else {
					handleUploadErrors(response);
				}
			},
			error: function (response) {
				handleUploadErrors(response);
			},
			contentType: false,
			processData: false
		});
	}

	/**
	 * @desc Handles upload errors&exceptions
	 * @param {object} response
	 */

	function handleUploadErrors(response) {
		// TODO: handle errors (MOB-1626)
	}

	/**
	 * @desc Entry point for create map modal
	 * @param {array} templates - mustache templates
	 */

	function init(templates) {
		renderModalContentMarkup(modalConfig, templates[0], templateData);
		createModal(modalConfig, function () {
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
	 * @param {object} modalConfig - modal config
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
		Object.keys(events).forEach(function (event) {
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
		setStep(index);
		showStepContent(index);
		showStepModalButtons(index);
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
		var id = steps[index].id;

		modalSections.addClass(hiddenClass);
		modalSections.filter('#' + id).removeClass(hiddenClass);
	}

	/**
	 * @desc shows step buttons
	 * @param {number} index - step index
	 */

	function showStepModalButtons(index) {
		var buttons = Object.keys(steps[index].buttons || {});

		modalButtons.addClass(hiddenClass);

		buttons.forEach(function (id) {
			modalButtons.filter('#' + id).removeClass(hiddenClass);
		});
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
		var $errorContainer = $('.map-creation-error'),
			errorMessage = $.msg(steps[index].errorMsgKeys[validationError]);

		$errorContainer.html('');
		$errorContainer.html(errorMessage);
		$errorContainer.removeClass(hiddenClass);
	}

	return {
		init: init
	};
});
