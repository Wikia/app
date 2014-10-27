require(['venus.infobox', 'wikia.document'], function(infoboxModule, d) {
	'use strict';

	var infoboxWrapper = d.getElementById('infoboxWrapper'),
		seeMoreButtonId = 'infoboxSeeMoreButton';

	function init() {
		var infobox = infoboxWrapper.firstChild,
			articleContent = d.getElementById('mw-content-text'),
			seeMoreButton;

		articleContent.classList.add('clear-none');

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
