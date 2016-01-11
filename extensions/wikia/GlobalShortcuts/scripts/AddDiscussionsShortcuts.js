/**
 * A module for adding shortcut key to GlobalShortcuts extension for opening discussions page
 */
require(['GlobalShortcuts', 'PageActions'],
	function (GlobalShortcuts, PageActions) {
		'use strict';

		var actionId = 'page:Classify',
			actionDescription = {
				id: 'page:Discussions',
				caption: 'Open discussions',
				fn: openDiscussions,
				weight: 600,
				category: 'Current wikia'
			};

		PageActions.add(actionDescription);
		GlobalShortcuts.add(actionId, 'g d');

		function openDiscussions() {
			window.location.href = mw.config.get('location').origin + '/d';
		}
	}
);
