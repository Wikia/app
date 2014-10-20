(function(){
	'use strict';

	var infoboxContainer = document.getElementById('infoboxContainer'),
		seeMore,
		maxInfoboxHeight = 700;

	function collapseInfobox() {
		var infoboxHeight = infoboxContainer.offsetHeight;

		if( infoboxHeight > maxInfoboxHeight ) {
			infoboxContainer.classList.add('collapsed-infobox');
			addSeeMoreElement();
		}
	}

	function expandInfobox() {
		infoboxContainer.classList.remove('collapsed-infobox');
		seeMore.classList.add('hide');
	}

	function addSeeMoreElement() {
		var infobox = infoboxContainer.firstChild,
			infoboxStyles,
			bgColor;

		if (infobox) {
			infoboxStyles = window.getComputedStyle(infobox);
			bgColor = infoboxStyles.getPropertyValue('background-color');
			console.log(bgColor);
			seeMore = document.createElement('div');

			// translations needed
			seeMore.innerHTML = 'SEE MORE';

			seeMore.classList.add('see-more');
			seeMore.style.backgroundColor = bgColor;
			seeMore.addEventListener('click', expandInfobox);

			infoboxContainer.appendChild(seeMore);
		}
	}

	collapseInfobox();
}());
