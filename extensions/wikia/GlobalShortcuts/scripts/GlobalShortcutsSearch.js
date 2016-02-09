define('GlobalShortcutsSearch', ['mw', 'wikia.loader', 'wikia.nirvana', 'wikia.throbber', 'GlobalShortcutsSuggestions'],
	function (mw, loader, nirvana, throbber, GlobalShortcutsSuggestions) {
	'use strict';

	function Init() {
		var modalConfig, suggestions;

		function open() {
			throbber.cover();

			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'GlobalShortcuts'
					}
				})
			).done(function (res) {
				mw.messages.set(res.messages);
				processOpen();
			});
		}

		function processOpen() {
			var html = [
				'<div class="full-width global-shortcuts-field-wrapper">',
				'<input type="text" placeholder="' + mw.message('global-shortcuts-search-placeholder').escaped() +
				'" id="global_shortcuts_search_field" />',
				'</div>',
				'<div class="full-width global-shortcuts-autocomplete-wrapper">',
				'</div>'
			].join('');
			setupModalConfig(html);

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

			suggestions = new GlobalShortcutsSuggestions($('#global_shortcuts_search_field'), function () {
				modalInstance.trigger('close');
			});
		}

		function setupModalConfig(content) {
			modalConfig = {
				vars: {
					id: 'GlobalShortcutsSearch',
					classes: ['global-shortcuts-search'],
					size: 'medium', // size of the modal
					content: content, // content
					title: 'Action explorer'
				}
			};
		}

		return {
			open: open
		};
	}

	return Init;
});

