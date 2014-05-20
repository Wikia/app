define('wikia.intMaps.createMapUI', ['jquery', 'wikia.window', 'wikia.mustache'], function($, w, mustache) {
	'use strict';

	var doc = w.document,
		body = doc.getElementsByTagName('body')[0],

		createMapModal, // placeholder for holding reference to modal instance
		modalSections,
		modalButtons,
		currentStep = 0, // holds current step of create map flow
		steps = [ // holds config for each step
			{
				id: 'intMapsChooseType'
			},
			{
				id: 'intMapsChooseTileSet',
				buttons: {
					intMapBack: true
				}
			}
		],
		hiddenClass = 'hidden',

		modalConfig = {
			vars: {
				id: 'intMapCreateMapModal',
				size: 'medium',
				content: '',
				title: $.msg('wikia-interactive-maps-create-map'),
				buttons: [
					{
						vars: {
							value: $.msg('wikia-interactive-maps-create-map-next-btn'),
							classes: ['normal', 'primary'],
							id: "intMapNext",
							data: [
								{
									key: 'event',
									value: 'next'
								}
							]
						}
					},
					{
						vars: {
							value:  $.msg('wikia-interactive-maps-create-map-back-btn'),
							id: "intMapBack",
							data: [
								{
									key: 'event',
									value: 'back'
								}
							]
						}
					}
				]
			}
		},
		templateData = {
			typeGeo: $.msg('wikia-interactive-maps-create-map-choose-type-geo'),
			typeCustom: $.msg('wikia-interactive-maps-create-map-choose-type-custom'),
			uploadFileBtn: $.msg('wikia-interactive-maps-create-map-upload-file')
		};

	// TODO: move it somewhere else
	body.addEventListener('click', function(event) {
		if (event.target.id === 'intMapCustom') {
			event.preventDefault();
			switchStep(1);
		}
	});

	/**
	 * @desc Entry point for create map modal
	 * @param {array} templates - mustache templates
	 */

	function init(templates) {
		renderModalContentMarkup(modalConfig, templates[0], templateData)
		createModal(modalConfig, function() {
			// attach handlers to modal events
			createMapModal.bind('next', nextStep);
			createMapModal.bind('back', previousStep);

			// cache modal sections and buttons
			modalSections = createMapModal.$content.children();
			modalButtons = createMapModal.$element.find('.buttons').children();

			// set initial step
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
				})
			})
		});
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
		currentStep = index;
	}

	/**
	 * @desc switches to the next step in create map flow
	 */

	function nextStep() {
		switchStep(currentStep + 1)
	}

	/**
	 * @desc switches to the previous step in create map flow
	 */

	function previousStep() {
		switchStep(currentStep - 1)
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

		buttons.forEach(function(id) {
			modalButtons.filter('#'+  id).removeClass(hiddenClass);
		});
	}

	return {
		init: init
	}
});
