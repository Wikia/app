require(
	['jquery', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'mw'],
	function ($, loader, nirvana, mustache, mw)
{
	'use strict';

	/* Modal buttons config for done and cancel buttons */
	var buttonsForFlagsExistingState = [{
		vars: {
			value: mw.message('flags-edit-modal-done-button-text').escaped(),
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

	/* Modal close button config*/
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
	};

	function init() {
		$('#ca-flags').on('click', showModal);
	}

	/**
	 * Function for showing modal.
	 * First function in showing modal process.
	 * Performs all necessary job to display modal with flags ready to edit
	 */
	function showModal() {
		$.when(
				nirvana.sendRequest({
					controller: 'Flags',
					method: 'editForm',
					data: {
						page_id: window.wgArticleId
					},
					type: 'get'
				}),
				loader({
					type: loader.MULTI,
					resources: {
						mustache: '/extensions/wikia/Flags/controllers/templates/FlagsController_editForm.mustache',
						styles: '/extensions/wikia/Flags/styles/EditFormModal.scss',
					}
				})
			).done(function (flagsData, res) {
				var template;

				loader.processStyle(res.styles);
				template = res.mustache[0];

				flagsData[0].flags = prepareFlagsData(flagsData[0].flags);

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

		for( flagTypeId in flagsData) {
			params = [];
			if (flagsData[flagTypeId]['flag_params_names']) {
				paramsNames  = JSON.parse(flagsData[flagTypeId]['flag_params_names']);
				for (paramName in paramsNames) {
					param = [];
					param['param_name'] = paramName;
					param['param_description'] = paramsNames[paramName];
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
				$flagsEditForm.trigger('submit');
			});
		}

		/* Show the modal */
		modalInstance.show();
	}

	// Run initialization method on DOM ready
	$(init);
});
