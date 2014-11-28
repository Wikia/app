require(['wikia.document', 'wikia.stickyElement', 'venus.layout'], function(doc, stickyElement, layout) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset,
		layout.breakpoints.smallMin);
});
