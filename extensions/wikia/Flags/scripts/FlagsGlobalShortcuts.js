/**
 * Flags module for adding shortcut key to GlobalShortcuts extension
 */
define('FlagsGlobalShortcuts',
	['GlobalShortcuts', 'PageActions', 'mw', 'wikia.loader'],
	function (GlobalShortcuts, PageActions, mw, loader) {
		'use strict';

		function init(openModal) {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'GlobalShortcuts'
					}
				})
			).done(function (res) {
					mw.messages.set(res.messages);
					addShortcuts(openModal);
				});
		}

		function addShortcuts(openModal) {
			var actionId = 'page:Flag',
				actionDescription = {
					id: actionId,
					fn: openModal,
					caption: mw.message('flags-edit-flags-button-text').escaped(),
					weight: 110,
					category: mw.message('global-shortcuts-category-current-page').escaped()
				};

			PageActions.add(actionDescription);
			GlobalShortcuts.add(actionId, 'f');
		}

		function add(openModal) {
			init(openModal);
		}

		return {
			add: add
		};
	}
);
