require(
	['jquery', 'wikia.document', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'mw', 'wikia.tracker'],
	function ($, document, loader, nirvana, mustache, mw, tracker)
{
	'use strict';

	/* Modal buttons config for done and cancel buttons */
	var buttonsForFlagsExistingState = [{
		vars: {
			value: mw.message('flags-edit-modal-done-button-text').escaped(),
			classes: ['normal', 'primary'],
			data: [
				{
					key: 'event',
					value: 'done'
				}
			]
		}
	},
	{
		vars: {
			value: mw.message('flags-edit-modal-cancel-button-text').escaped(),
			data: [
				{
					key: 'event',
					value: 'close'
				}
			]
		}
	}],

	/* Modal close button config */
	buttonForEmptyState = [{
		vars: {
			value: mw.message('flags-edit-modal-close-button-text').escaped(),
			data: [
				{
					key: 'event',
					value: 'close'
				}
			]
		}
	}],

	/* Modal component configuration */
	modalConfig = {
		vars: {
			id: 'FlagsModal',
			classes: ['edit-flags'],
			size: 'medium', // size of the modal
			content: '', // content
			title: mw.message('flags-edit-modal-title').escaped()
		}
	},

	/* Tracking wrapper function */
	track = Wikia.Tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'flags-edit',
		trackingMethod: 'analytics'
	}),

	/* Label for on submit tracking event */
	labelForSubmitAction = 'submit-form-untouched';

	function init() {
		$('body').on('click', '#ca-flags, .bn-flags-entry-point', showModal);
		addFlagsButton();
	}

	/**
	 * Function for showing modal.
	 * First function in showing modal process.
	 * Performs all necessary job to display modal with flags ready to edit
	 */
	function showModal(event) {
		event.preventDefault();
		$.when(
				nirvana.sendRequest({
					controller: 'Flags',
					method: 'editForm',
					data: {
						'page_id': window.wgArticleId
					},
					type: 'get'
				}),
				loader({
					type: loader.MULTI,
					resources: {
						mustache: '/extensions/wikia/Flags/controllers/templates/FlagsController_editForm.mustache,/extensions/wikia/Flags/controllers/templates/FlagsController_editFormEmpty.mustache,/extensions/wikia/Flags/controllers/templates/FlagsController_editFormException.mustache',
						styles: '/extensions/wikia/Flags/styles/EditFormModal.scss'
					}
				})
			).done(function (flagsData, res) {
				var template;

				loader.processStyle(res.styles);

				if (flagsData[0].flags) {
					template = res.mustache[0];
					flagsData[0].flags = prepareFlagsData(flagsData[0].flags);
				} else if (flagsData[0].emptyMessage) {
					template = res.mustache[1];
				} else if (flagsData[0].exceptionMessage) {
					template = res.mustache[2];
				}

				modalConfig.vars.content = mustache.render(template, flagsData[0]);

				require(['wikia.ui.factory'], function (uiFactory) {
					/* Initialize the modal component */
					uiFactory.init(['modal']).then(createComponent);
				});
			});
	}

	/**
	 * Prepare data for mustache template
	 */
	function prepareFlagsData(flagsData) {
		var flagTypeId, paramName, paramsNames,
			param, params, flags = [];

		for (flagTypeId in flagsData) {
			params = [];
			if (flagsData[flagTypeId]['flag_params_names']) {
				paramsNames  = JSON.parse(flagsData[flagTypeId]['flag_params_names']);
				for (paramName in paramsNames) {
					param = [];
					param['param_name'] = paramName;
					param['param_description'] = paramsNames[paramName];
					param['param_placeholder'] = paramsNames[paramName].length ? paramsNames[paramName] : paramName;
					param['param_value'] = flagsData[flagTypeId].params ? flagsData[flagTypeId].params[paramName] : '';
					params.push(param);
				}
			}
			flagsData[flagTypeId]['flag_params_names'] = params;
			flags[flagTypeId] = flagsData[flagTypeId];
		}

		return flags;
	}

	/**
	 * Creates modal UI component
	 * One of sub-tasks for getting modal shown
	 */
	function createComponent(uiModal) {
		/* Look for existence of form tag to determine whether there are any flags on the wikia */
		if (modalConfig.vars.content.indexOf('<form') > -1) {
			modalConfig.vars.buttons = buttonsForFlagsExistingState;
		} else {
			modalConfig.vars.buttons = buttonForEmptyState;
		}
		/* Create the wrapping JS Object using the modalConfig */
		uiModal.createComponent(modalConfig, processInstance);
	}

	/**
	 * CreateComponent callback that finally shows modal
	 * and binds submit action to Done button
	 * One of sub-tasks for getting modal shown
	 */
	function processInstance(modalInstance) {
		var $flagsEditForm = modalInstance.$element.find('#flagsEditForm');
		if ($flagsEditForm.length > 0) {
			/* Submit flags edit form on Done button click */
			modalInstance.bind('done', function () {
				track({
					action: tracker.ACTIONS.CLICK_LINK_BUTTON,
					label: labelForSubmitAction
				});
				$flagsEditForm.trigger('submit');
			});
			/* Track clicks on modal form */
			$flagsEditForm.bind('click', trackModalFormClicks);
			/* Detect form change */
			$flagsEditForm.on('change', function () {
				labelForSubmitAction = 'submit-form-touched';
				$flagsEditForm.off('change');
			});
		}

		/* Track all ways of closing modal */
		modalInstance.bind('close', function () {
			track({
				label: 'modal-close'
			});
		});

		/* Show the modal */
		modalInstance.show();
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'modal-shown'
		});
	}

	/**
	 * Track clicks within modal form
	 * (links and checkboxes)
	 */
	function trackModalFormClicks(e) {
		var $target = $(e.target),
			$targetLinkDataId;

		/* Track checkbox toggling */
		if ($target.is('input[type=checkbox]')) {
			if ($target[0].checked) {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'checkbox-checked'
				});
			} else {
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'checkbox-unchecked'
				});
			}
			return;
		}

		/* Track links clicks */
		if ($target.is('a')) {
			$targetLinkDataId = $target.data('id');
			if ($targetLinkDataId) {
				track({
					action: tracker.ACTIONS.CLICK_LINK_TEXT,
					label: $targetLinkDataId
				});
			}
		}
	}

	/**
	 * Adds edit flags button before and after generated flags in view
	 */
	function addFlagsButton() {
		var $a = $(document.createElement('a'))
				.addClass('flags-icon')
				.html(mw.message('flags-edit-flags-button-text').escaped())
				.click(showModal),
			$div = $(document.createElement('div'))
				.addClass('flags-edit')
				.html($a);
		var flagsContainer = $('.portable-flags');
		if (flagsContainer.length !== 0) {
			flagsContainer.prepend($div).append($div.clone(true));
		} else {
			flagsContainer = $('.portable-flags-inline');
			if (flagsContainer.length !== 0) {
				flagsContainer.prepend($div).append($div.clone(true));
			}
		}
	}

	// Run initialization method on DOM ready
	$(init);
});
