require(['wikia.window', 'wikia.document', 'wikia.stickyElement', 'venus.variables'], function(win, doc, stickyElement, v) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	// Sticky navigation
	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset,
		v.breakpointSmallMin);

	//Share link events
	[].forEach.call(doc.getElementsByClassName('share-link'), function(element) {
		console.log(element);

		element.addEventListener('click', function(event) {
			var url = element.getAttribute('href'),
				title = element.getAttribute('title'),
				h = (window.innerHeight / 2 | 0),
				w = (window.innerWidth / 2 | 0);

			win.open(url, title, 'width=' + w + ',height=' + h);

			event.stopPropagation();
			event.preventDefault();
			return false;
		});
	});
});
