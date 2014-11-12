require([
	'wikia.document', 'wikia.stickyElement', 'venus.variables', 'wikia.tracker'
], function(doc, stickyElement, v) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100;

	// this function is needed for additional margin for screens >= 1024px
	// (because header is getting float: left on medium and higher breakpoints)
	function adjustPosition(value, typ) {
		switch(typ) {
			case 'topScrollLimit':
			case 'topSticked':
				if (window.matchMedia("(min-width: 1024px)").matches) {
					return value + $('#WikiaArticle').find('> header').outerHeight(true);
				}
			// fall-through on purpose!
			default:
				return value;
		}
	}

	// Sticky navigation
	stickyElement.spawn().init({
		sourceElement: navigationElement,
		alignToElement: boundBoxElement,
		topFixed: globalNavigationHeight + additionalTopOffset,
		minWidth: v.breakpointSmallMin,
		adjustFunc: adjustPosition
	});
});
