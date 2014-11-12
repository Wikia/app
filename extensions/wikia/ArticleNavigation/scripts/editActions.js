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
		});
	}
});
