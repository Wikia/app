require([
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.dropdownNavigation', 'jquery'
], function (nirvana, tracker, win, dropdownNavigation, $) {
	'use strict';

	/**
	 * Initialize edit actions
	 */
	dropdownNavigation({
		id: 'editActionsDropdown',
		trigger: 'articleEditActions'
	});

	trackEditAction();

	/**
	 * All logic related with tracking edit actions
	 */
	function trackEditAction() {
		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			trackingMethod: 'both'
		});

		$('#editActionsDropdown').on('mousedown touchstart', 'a', function (e) {
			var label,
				el = e.target,
				name = $(el).data('name');

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			switch (name) {
				case 'customize':
				case 'follow':
				case 'history':
				case 'whatlinkshere':
					label = name;
					break;
				default:
					label = 'custom';
					break;
			}

			//add anon prefix for not logged in users
			if (!win.wgUserName) {
				label = 'anon-' + label;
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: 'toolbar',
					label: label
				});
			}
		});
	}
});
