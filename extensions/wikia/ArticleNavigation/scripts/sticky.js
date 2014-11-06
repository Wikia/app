require([
	'wikia.document', 'wikia.stickyElement', 'venus.variables', 'wikia.tracker'
], function(doc, stickyElement, v) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	// Sticky navigation
	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset,
		v.breakpointSmallMin);
});
