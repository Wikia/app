require(['wikia.document', 'wikia.stickyElement'], function(doc, stickyElement) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset);
});
