require(['wikia.document', 'wikia.stickyElement'], function(doc, stickyElement) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		minimalTopOffset = 100;

	stickyElement.spawn().init(navigationElement, boundBoxElement, minimalTopOffset);
});
