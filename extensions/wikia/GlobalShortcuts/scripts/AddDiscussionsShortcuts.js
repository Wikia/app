/**
 * A module for adding shortcut key to GlobalShortcuts extension for opening discussions page
 */
require(['GlobalShortcuts', 'PageActions', 'mw', 'wikia.window'],
	function (GlobalShortcuts, PageActions, mw, w) {
		'use strict';

		var actionId = 'page:Discussions',
			actionDescription = {
				id: actionId,
				caption: 'Open discussions',
				fn: openDiscussions,
				weight: 600,
				category: 'Current wikia'
			};

		PageActions.add(actionDescription);
		GlobalShortcuts.add(actionId, 'g d');

		function openDiscussions() {
			w.location.href = mw.config.get('location').origin + '/d';
		}
	}
);
