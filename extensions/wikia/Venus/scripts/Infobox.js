require(['venus.infobox', 'wikia.document'], function (infoboxModule, d) {
	'use strict';
	function init() {
		var infoboxContainer = d.getElementById('infoboxContainer'),
			infoboxWrapper = d.getElementById('infoboxWrapper'),
			$infoboxWrapper = $(infoboxWrapper),
			seeMoreButtonId = 'infoboxSeeMoreButton',
			articleContent = d.getElementById('mw-content-text'),
			seeMoreButton,
			infobox;
		if (!infoboxWrapper) {
			return;
		}
		infobox = infoboxWrapper.firstChild,
		articleContent.classList.add('clear-none');
		infoboxContainer.nextElementSibling.classList.add('clear-left');

		if (infoboxModule.isInfoboxCollapsible(infoboxWrapper)) {
			infoboxModule.collapseInfobox(infoboxWrapper);

			seeMoreButton = infoboxModule.createSeeMoreButton(infobox, seeMoreButtonId);
			seeMoreButton.addEventListener('click', function (e) {
				infoboxModule.expandInfobox(infoboxWrapper, seeMoreButton);
				e.preventDefault();
			});

			infoboxWrapper.appendChild(seeMoreButton);
		}

		$infoboxWrapper.trigger('initialized.infobox');
	}

	if (infoboxWrapper) {
		// waiting for document ready when makeCollapsible is loaded
		$(d).ready(function() {
			// Wrap collapsible sections
			$infoboxWrapper.find('.mw-collapsible').makeCollapsible();
			// Wrap whole infobox by adding see more button
			init();
			// Init after reloading article content with AJAX
			mw.hook('postEdit').add(init);
		});
	}
});
