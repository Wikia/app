require(['venus.infobox', 'wikia.document'], function(infoboxModule, d) {
	'use strict';

	var infoboxContainer = d.getElementById('infoboxContainer'),
		infoboxWrapper = d.getElementById('infoboxWrapper'),
		seeMoreButtonId = 'infoboxSeeMoreButton';

	function init() {
		var infobox = infoboxWrapper.firstChild,
			articleContent = d.getElementById('mw-content-text'),
			seeMoreButton;

		articleContent.classList.add('clear-none');
		infoboxContainer.nextSibling.classList.add('clear-left');

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
