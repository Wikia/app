require([
	'wikia.document', 'wikia.stickyElement', 'venus.layout', 'wikia.browserDetect'
], function(doc, stickyElement, layout, browserDetect) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100,
		$source = $(navigationElement),
		$target = $(boundBoxElement),
		$bottomTarget,
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

	// Categories
	$bottomTarget = $('.article-categories');
	if ($bottomTarget.length === 0) {
		$bottomTarget = $target;
	}

	function adjustPositionFunction(scrollY, sourceElement, targetElement) {
		var additionalOffset, targetBottom;

		targetBottom = $bottomTarget.position().top +
			$bottomTarget.outerHeight(true) -
			$source.outerHeight(true);

		additionalOffset = browserDetect.isFirefox() ? 0 : additionalTopOffset;

		if ($doc.scrollTop() + additionalOffset >= targetBottom) {
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
		minWidth: layout.breakpoints.smallMin,
		adjustFunc: adjustValueFunction,
		adjustPositionFunc: adjustPositionFunction
	});
});
