/**
 * Clicking on the more suggestions link will slide down a row of
 * thumbnails that are additional possible matches for the non-premium
 * video
 */
define('lvs.suggestions', [], function () {
	'use strict';

	function init($container) {
		$container.find('.suggestion-title').ellipses();
		updateSizeClass($container);

		$container
			.off('click.lvsSuggestions')
			.on('click.lvsSuggestions', '.more-link', function (e) {
				e.preventDefault();
				var $this = $(this),
					$toggleDiv = $this.parent().next('.more-videos');

				if ($this.hasClass('collapsed')) {
					// Show suggestions
					$this.removeClass('collapsed');
					$toggleDiv.removeClass('collapsed');
				} else {
					// Hide suggestions
					$this.addClass('collapsed');
					$toggleDiv.addClass('collapsed');
				}
			});
	}

	function updateSizeClass($elem) {
		$elem.find('.more-videos .large').each(function () {
			$(this).removeClass('large').addClass('small');
		});
	}

	return {
		init: init
	};
});
