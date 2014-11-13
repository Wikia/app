/* global require */
require([
	'wikia.document', 'wikia.stickyElement', 'venus.variables', 'wikia.articleNavUserTools',
], function (doc, stickyElement, v, userTools) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset,
		v.breakpointSmallMin);

	//Initialize user tools
	userTools.init();
});
