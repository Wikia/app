require([
	'wikia.document', 'wikia.stickyElement', 'venus.variables', 'wikia.tracker'
], function(doc, stickyElement, v) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100,
		$source = $(navigationElement),
		$target = $(boundBoxElement),
		$doc = $(doc),
		stickyElementObject = stickyElement.spawn();

	// this function is needed for additional margin for screens >= 1024px
	// (because header is getting float: left on medium and higher breakpoints)
	function adjustValueFunction(value, typ) {
		switch(typ) {
			case 'topScrollLimit':
			case 'topSticked':
				if (window.matchMedia("(min-width: 1024px)").matches && $('#infoboxWrapper').length) {
					return value + $('#WikiaArticle').find('> header').outerHeight(true);
				}
			// fall-through on purpose!
			default:
				return value;
		}
	}

	function adjustPositionFunction(scrollY, sourceElement, targetElement) {
		var targetBottom = $target.position().top +
			$target.outerHeight(true) -
			$source.outerHeight(true);

		if ($doc.scrollTop() >= targetBottom) {
			stickyElementObject.sourceElementPosition('absolute', 'top', targetBottom);
			return true;
		} else {
			return false;
		}
	}

	// Sticky navigation
	stickyElementObject.init({
		sourceElement: navigationElement,
		alignToElement: boundBoxElement,
		topFixed: globalNavigationHeight + additionalTopOffset,
		minWidth: v.breakpointSmallMin,
		adjustFunc: adjustValueFunction,
		adjustPositionFunc: adjustPositionFunction
	});
});
