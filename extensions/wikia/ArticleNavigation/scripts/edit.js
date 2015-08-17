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
		isTouchScreen = win.Wikia.isTouchScreen(),
		modalStylesLoaded = false,
		dropdown,
		$dropdown,
		$parent;

	/**
	 * @desc shows dropdown
	 * @param {Event=} event
	 */
	function show(event) {
		$('.article-navigation > ul > li.active').removeClass('active');

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
			trackingMethod: 'analytics'
		});

		$dropdown.on('mousedown touchstart', 'a', function (event) {
			var $target = $(event.currentTarget),
				id = $target.data('tracking-id'),
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
	$dropdown = $('#' + dropdownId);
	$parent = $dropdown.parent();
	dropdown = dropdownNavigation(dropdownParams);

	if (isTouchScreen) {
		$parent.on('click', function(e) {
			e.stopPropagation();

			if($parent.hasClass('active')) {
				hide();
			} else {
				show();
			}
		});
	} else {
		win.delayedHover($parent[0], delayHoverParams);
	}

	/**
	 * Show user login modal when user clicks edit link
	 * @param {Event} event - event object
	 * @returns {boolean}
	 */
	function showUserLoginModal(event) {
		var target = event.currentTarget;
		if (!modalStylesLoaded) {
			$.getResources([
				$.getSassCommonURL(
					'extensions/wikia/Venus/styles/modules/modalVenus.scss'
				)
			]).done(function() {
				modalStylesLoaded = true;
				callUserLoginModalShow(target);
			});
		} else {
			callUserLoginModalShow(target);
		}

		return false;
	}

	/**
	 * Call userLoginModal.show function with correct params
	 * @param {Object} target - href which was clicked
	 */
	function callUserLoginModalShow(target) {
		win.UserLoginModal.show({
			origin: 'venus-article-edit',
			callback: function() {
				win.location = target.href;
			}
		});
	}

	$dropdown.find('.force-user-login').on('click', showUserLoginModal);

	trackEditAction($dropdown);
});
