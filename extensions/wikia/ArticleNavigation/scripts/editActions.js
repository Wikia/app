require([
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.dropdownNavigation', 'jquery'
], function (nirvana, tracker, win, dropdownNavigation, $) {
	'use strict';

	var dropdown,
		dropdownParams = {
			id: 'editActionsDropdown',
			trigger: 'articleEditActions',
			render: false
		},
		delayHoverParams = {
			onActivate: show,
			onDeactivate: hide,
			activateOnClick: false
		},
		$parent = $('#articleEditActions').parent();

	/**
	 * @desc shows dropdown
	 * @param {Event=} event
	 */
	function show(event) {
		$parent.addClass('active');

		// handle touch interactions
		if (event) {
			event.stopPropagation();
		}

		$('body').one('click', hide);
	}

	/**
	 * @desc hides dropdown
	 */
	function hide() {
		dropdown.resetUI();
		$parent.removeClass('active');
	}

	/**
	 * @desc all logic related with tracking edit actions
	 */
	function trackEditAction() {
		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			trackingMethod: 'both'
		});

		$('#editActionsDropdown').on('mousedown touchstart', 'a', function (event) {

		});
	}

	// Initialize edit actions
	dropdown = dropdownNavigation(dropdownParams);
	win.delayedHover($parent[0], delayHoverParams);
	trackEditAction();
});
