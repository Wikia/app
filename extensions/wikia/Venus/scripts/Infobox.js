(function(){
	'use strict';

	var infoboxContainer = document.getElementById('infoboxContainer'),
		seeMore,
		maxInfoboxHeight = 700;

	/**
	 * Check if infobox is heigher than maxInfoboxHeight
	 * and add see more button
	 */
	function collapseInfobox() {
		var infoboxHeight = infoboxContainer.offsetHeight;

		if( infoboxHeight > maxInfoboxHeight ) {
			infoboxContainer.classList.add('collapsed-infobox');
			addSeeMoreElement();
		}
	}

	/**
	 * Expand infobox
	 */
	function expandInfobox() {
		infoboxContainer.classList.remove('collapsed-infobox');
		seeMore.classList.add('hide');
	}

	/**
	 * Create and add see more button to infobox
	 */
	function addSeeMoreElement() {
		var infobox = infoboxContainer.firstChild,
			infoboxStyles,
			bgColor;

		if (infobox) {
			infoboxStyles = window.getComputedStyle(infobox);
			bgColor = infoboxStyles.getPropertyValue('background-color');

			seeMore = document.createElement('div');

			// translations needed
			seeMore.innerHTML = window.mw.msg('venus-article-infobox-see-more');

			seeMore.classList.add('see-more');
			seeMore.style.backgroundColor = bgColor;
			seeMore.addEventListener('click', expandInfobox);

			infoboxContainer.appendChild(seeMore);
		}
	}

	if (infoboxContainer) {
		collapseInfobox();
	}
}());
