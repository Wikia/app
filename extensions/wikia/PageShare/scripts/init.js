require(['wikia.window', 'wikia.tracker', 'jquery'], function(win, tracker, $) {
	'use strict';

	var trackFunc = tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'share',
		trackingMethod: 'both'
	});

	/**
	 * @desc Share click handler
	 *
	 * @param {Event} event
	 */
	function shareLinkClick(event) {
		event.stopPropagation();
		event.preventDefault();

		var service = $(event.target).closest('a'),
			url = service.prop('href'),
			title = service.prop('title'),
			h = (win.innerHeight / 2 | 0), // round down
			w = (win.innerWidth / 2 | 0);  // round down

		trackFunc({label: service.data('share-service')});

		win.open(url, title, 'width=' + w + ',height=' + h);
	}

	// bind events to links
	$(function(){
		$('#PageShareToolbar').on('click', '.page-share a', shareLinkClick);
	});
});
