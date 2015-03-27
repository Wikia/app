require([
	'wikia.window', 'wikia.underscore', 'wikia.document', 'wikia.tracker', 'wikia.dropdownNavigation', 'jquery'
], function(win, _, doc, tracker, dropdownNavigation, $) {
	'use strict';

	var dropdownId = 'shareActionsDropdown',
		dropdownParams = {
			id: dropdownId,
			trigger: 'articleShareActions',
			render: false
		},
		delayHoverParams = {
			onActivate: show,
			onDeactivate: hide,
			activateOnClick: false
		},
		$win = $(win),
		isTouchScreen = win.Wikia.isTouchScreen(),
		dropdown,
		$dropdown,
		$parent,
		trackFunc,
		debouncedUpdatePosition;

	/**
	 * @desc Tracking function
	 */
	trackFunc = tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'share',
		trackingMethod: 'analytics'
	});

	/**
	 * @desc Share click handler
	 *
	 * @param {Event} event
	 */
	function shareLinkClick(event) {
		$('.article-navigation > ul > li.active').removeClass('active');

		var url = event.target.getAttribute('href'),
			title = event.target.getAttribute('title'),
			h = (win.innerHeight / 2 | 0),
			w = (win.innerWidth / 2 | 0);

		win.open(url, title, 'width=' + w + ',height=' + h);

		event.stopPropagation();
		event.preventDefault();
	}

	/**
	 * @desc Share link tracking handler
	 *
	 * @param {Event} event
	 */
	function shareLinkTrack(event) {
		trackFunc({label: event.target.getAttribute('data-share-name')});
	}


	/**
	 * @desc How much user has scrolled, if enough hide multiple share buttons and show dropdown (and unbind)
	 */
	function updatePosition() {
		if ($win.scrollTop() > 250) {
			win.removeEventListener('scroll', debouncedUpdatePosition);

			$('.article-navigation').addClass('single-share');

			initializeDropdown();
		}
	}

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
	 * @desc initialize dropdown
	 */
	function initializeDropdown() {
		dropdown = dropdownNavigation(dropdownParams);

		$dropdown = $('#' + dropdownId);
		$parent = $dropdown.parent();

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
	}

	// bind events to links
	$('.share-link').each(function() {
		$(this).on('click', shareLinkClick).on('touchstart mousedown', shareLinkTrack);
	});

	// initialize one-time event to hide multiple shares
	debouncedUpdatePosition = _.debounce(updatePosition, 10);
	win.addEventListener('scroll', debouncedUpdatePosition);

	// also update position for the first time
	$(updatePosition);
});
