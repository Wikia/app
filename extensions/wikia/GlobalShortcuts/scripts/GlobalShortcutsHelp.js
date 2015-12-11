define('GlobalShortcutsHelp', ['mw', 'wikia.nirvana', 'wikia.throbber'], function (mw, nirvana, throbber) {
	'use strict';

	function Init() {
		var modalConfig;

		function open() {
			throbber.cover();
			$.when(
				getHelp()
			).done(handleRequestsForModal);
		}

		function getHelp() {
			return nirvana.sendRequest({
				controller: 'GlobalShortcuts',
				method: 'getHelp',
				type: 'get',
				format: 'html'
			});
		}

		function handleRequestsForModal(help) {
			// Set modal content
			setupTemplateClassificationModal(
				help
			);
			require(['wikia.ui.factory'], function (uiFactory) {
				/* Initialize the modal component */
				uiFactory.init(['modal']).then(createComponent);
			});
		}

		/**
		 * Creates modal UI component
		 * One of sub-tasks for getting modal shown
		 */
		function createComponent(uiModal) {
			/* Create the wrapping JS Object using the modalConfig */
			uiModal.createComponent(modalConfig, processInstance);
		}

		/**
		 * CreateComponent callback that finally shows modal
		 * and binds submit action to Done button
		 * One of sub-tasks for getting modal shown
		 */
		function processInstance(modalInstance) {
			/* Show the modal */
			modalInstance.show();
			throbber.uncover();
		}

		function setupTemplateClassificationModal(content) {
			/* Modal component configuration */
			modalConfig = {
				vars: {
					id: 'GlobalShortcutsHelp',
					classes: ['global-shortcuts-help'],
					size: 'medium', // size of the modal
					content: content, // content
					title: 'Keyboard shortcuts'
				}
			};
		}

		return {
			open: open
		};
	}

	return new Init();
});

