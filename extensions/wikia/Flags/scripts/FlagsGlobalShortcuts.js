/**
 * Flags module for adding shortcut key to GlobalShortcuts extension
 */
define('FlagsGlobalShortcuts',
	['GlobalShortcuts', 'PageActions'],
	function (GlobalShortcuts, PageActions) {
		'use strict';

		var actionId = 'page:Flag',
			actionDescription = {
				id: actionId,
				caption: 'Change page flags',
				weight: 110,
				category: 'Current page'
			};

		function add(openModal) {
			actionDescription.fn = openModal;
			PageActions.add(actionDescription);
			GlobalShortcuts.add(actionId, 'f');
		}

		return {
			add: add
		};
	}
);
