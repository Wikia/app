/**
 * Curtain module to handle curtain that can overlay whole page
 */
(function () {
	'use strict';

	var $ = require('jquery'),
		window = require('wikia.window'),
		activeClass = 'active',
		$trigger = $.event.trigger,
		$d = $(window.document),
		$curtain = $('#wkCurtain').on('click', function () {
			if ($curtain.toggleClass(activeClass).hasClass(activeClass)) {
				$trigger('curtain:shown');
			} else {
				$trigger('curtain:hidden');
			}
		});

	$d.on('curtain:hide', function () {
		if ($curtain.hasClass(activeClass)) {
			$curtain.removeClass();
			$trigger('curtain:hidden');
		}
	}).on('curtain:show', function () {
		if (!$curtain.hasClass(activeClass)) {
			$curtain.addClass(activeClass);

			$trigger('curtain:shown');
		}
	});
})();
