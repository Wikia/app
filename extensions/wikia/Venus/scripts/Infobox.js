require(['venus.infobox', 'wikia.document', 'wikia.window'], function(infoboxModule, d, w) {
	'use strict';

	var infoboxContainer = d.getElementById('infoboxContainer'),
		infoboxWrapper = d.getElementById('infoboxWrapper'),
		seeMoreButtonId = 'infoboxSeeMoreButton';

	function init() {
		var infobox = infoboxWrapper.firstChild,
			articleContent = d.getElementById('mw-content-text'),
			seeMoreButton,
			nextElement = infoboxContainer.nextElementSibling,
			isNextElementFloated;

		articleContent.classList.add('clear-none');
		isNextElementFloated = (window.getComputedStyle(nextElement).getPropertyValue('float') === 'right' ||
			nextElement.style.float === 'right');

		if (isNextElementFloated) {
			nextElement.classList.add('clear-both');
		} else {
			nextElement.classList.add('clear-left');
		}

		if(infoboxModule.isInfoboxCollapsible(infoboxWrapper)) {
			infoboxModule.collapseInfobox(infoboxWrapper);

			seeMoreButton = infoboxModule.createSeeMoreButton(infobox, seeMoreButtonId);
			seeMoreButton.addEventListener('click', function(e) {
				infoboxModule.expandInfobox(infoboxWrapper, seeMoreButton);
				e.preventDefault();
			});

			infoboxWrapper.appendChild(seeMoreButton);
		}
	}

	if(infoboxWrapper) {
		init();
	}
});
