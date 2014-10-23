require(['venus.infobox', 'wikia.document'], function(infoboxModule, d) {
	'use strict';

	var infoboxContainer = d.getElementById('infoboxContainer'),
		seeMoreButtonId = 'infoboxSeeMoreButton';

	function init() {
		var infobox = infoboxContainer.firstChild,
			articleContent = d.getElementById('mw-content-text'),
			seeMoreButton;

		articleContent.classList.add('clear-none');

		if(infoboxModule.isInfoboxCollapsible(infoboxContainer)) {
			infoboxModule.collapseInfobox(infoboxContainer);

			seeMoreButton = infoboxModule.createSeeMoreButton(infobox, seeMoreButtonId);
			seeMoreButton.addEventListener('click', function(e) {
				infoboxModule.expandInfobox(infoboxContainer, seeMoreButton);
				e.preventDefault();
			});
			infoboxContainer.appendChild(seeMoreButton);
		}
	}

	if(infoboxContainer) {
		init();
	}
});
