/**
 * Clicking on the more suggestions link will slide down a row of
 * thumbnails that are additional possible matches for the non-premium
 * video
 */
define('lvs.suggestions', [], function () {
	'use strict';

	function init($container) {
		var $suggestions = $container.find('.more-videos');
		$suggestions.find('.title a').ellipses();
		updateSizeClass($suggestions);
		makeActive($suggestions);
	}

	function makeActive($elem) {
		$elem.find('li:first-child').addClass('selected');
	}

	/**
	 * Suggested thumbnails come back from LVS script as large - set them to small
	 * @param $elem
	 */
	function updateSizeClass($elem) {
		$elem.find('.large').each(function () {
			$(this).removeClass('large').addClass('small');
		});
	}

	return {
		init: init
	};
});
