require([
	'wikia.window', 'wikia.document', 'wikia.stickyElement', 'venus.variables', 'wikia.tracker'
], function(win, doc, stickyElement, v, tracker) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	// Sticky navigation
	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset,
		v.breakpointSmallMin);

	//Share link events and tracking
	function shareLinkClick(event) {
		var url = event.target.getAttribute('href'),
			title = event.target.getAttribute('title'),
			h = (win.innerHeight / 2 | 0),
			w = (win.innerWidth / 2 | 0);

		win.open(url, title, 'width=' + w + ',height=' + h);

		event.stopPropagation();
		event.preventDefault();
		return false;
	}

	function shareLinkTrack(event) {
		var name = event.target.getAttribute('data-share-name'),
			track;

		track = tracker.buildTrackingFunction({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'share',
			label: name,
			trackingMethod: 'both'
		});

		track();
	}

	[].forEach.call(doc.getElementsByClassName('share-link'), function(element) {
		element.addEventListener('click', shareLinkClick);
		element.addEventListener('touchstart', shareLinkTrack);
		element.addEventListener('mousedown', shareLinkTrack);
	});
});
