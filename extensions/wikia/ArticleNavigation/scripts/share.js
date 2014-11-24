require([
	'wikia.window', 'wikia.document', 'wikia.tracker', 'jquery'
], function(win, doc, tracker, $) {
	'use strict';

	var trackFunc = tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'share',
		trackingMethod: 'both'
	});

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

	function shareLinkTrack(event) {
		trackFunc({label: event.target.getAttribute('data-share-name')});
	}

	[].forEach.call(doc.getElementsByClassName('share-link'), function(element) {
		element.addEventListener('click', shareLinkClick);
		element.addEventListener('touchstart', shareLinkTrack);
		element.addEventListener('mousedown', shareLinkTrack);
	});
});
