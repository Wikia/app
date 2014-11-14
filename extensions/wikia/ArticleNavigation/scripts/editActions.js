require([
	'wikia.nirvana', 'wikia.tracker', 'wikia.window', 'wikia.dropdownNavigation', 'jquery'
], function (nirvana, tracker, win, dropdownNavigation, $) {
	'use strict';

	var dropdownId = 'editActionsDropdown',
		dropdownParams = {
			id: dropdownId,
			trigger: 'articleEditActions',
			render: false
		},
		delayHoverParams = {
			onActivate: show,
			onDeactivate: hide,
			activateOnClick: false
		},
		dropdown,
		$dropdown,
		$parent;

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
	 * @param {jQuery} $dropdown
	 */
	function trackEditAction($dropdown) {
		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			trackingMethod: 'both'
		});

		$dropdown.on('mousedown touchstart', 'a', function (event) {
			var $target = $(event.currentTarget),
				id = $target.data('tracking-id').replace('ca-', ''),
				label;

			// Primary mouse button only
			if (event.which !== 1) {
				return;
			}

			if (win.veTrack) {
				if (id === 'edit') {
					win.veTrack({
						action: 'other-edit-click'
					});
				}
				if (id === 've-edit') {
					win.veTrack({
						action: 've-edit-click'
					});
				}
			}

			switch (id) {
				case 'comment': {
					label = $target.hasClass('talk') ? 'talk' : 'comment';
					break;
				}
				case 'edit': {
					label = id;
					break;
				}
				case 'delete':
				case 'history':
				case 'move':
				case 'protect': {
					label = 'edit-' + id;
					break;
				}
				default:
					break;
			}

			if (label !== undefined) {
				track({
					browserEvent: event,
					category: 'article',
					label: label
				});
			}
		});
	}

	// Initialize edit actions
	dropdown = dropdownNavigation(dropdownParams);

	$dropdown = $('#' + dropdownId);
	$parent = $dropdown.parent();

	win.delayedHover($parent[0], delayHoverParams);
	trackEditAction($dropdown);
});
