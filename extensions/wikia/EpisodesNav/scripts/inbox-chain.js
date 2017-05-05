require(['jquery'], function ($) {
	'use strict';

	var $similars = $('.similars'),
		$similarsBlock = $('.similars-block'),
		$rightBox = $('.scroll-right'),
		$leftBox = $('.scroll-left');

	function scroll(direction) {
		var pos = $similars.position(),
			newPos = Math.min(pos.left + (direction * 720), 0),
			width = $similars.width();

		if (Math.abs(newPos) < width) {
			$similars.css('left', newPos + 'px');
		}

		if (Math.abs(newPos) + 720 > width) {
			$rightBox.addClass('scroll-disabled');
		} else if ($rightBox.hasClass('scroll-disabled')) {
			$rightBox.removeClass('scroll-disabled');
		}

		if (newPos == 0) {
			$leftBox.addClass('scroll-disabled')
		} else if ($leftBox.hasClass('scroll-disabled')) {
			$leftBox.removeClass('scroll-disabled');
		}
	}

	$(function () {
		if ($similars.width() > $similarsBlock.width()) {
			$rightBox.removeClass('scroll-disabled');
		}

		$('.scroll-left').on('click', function () {
			scroll(1);
		});
		$('.scroll-right').on('click', function () {
			scroll(-1);
		});
	});
});
