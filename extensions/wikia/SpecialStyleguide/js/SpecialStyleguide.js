(function () {
	'use strict';

	var $ = require('jquery'),
		w = require('wikia.window'),
		TOC = require('wikia.ui.toc');

	$(function () {
		var $toc = $('#styleguideTOC'),
			TOC_TOP_MARGIN = 10, // const for top margin of fixed TOC set in CSS
			tocOffsetTop,
			tocInstance,
			throttled;

		if ($toc.length) {
			tocOffsetTop = $toc.offset().top;
			tocInstance = new TOC($toc);

			tocInstance.init();

			/**
			 * Fix / unfix TOC position
			 */
			function setTOCPosition() {
				var scrollTop = $('body').scrollTop();

				// in Chrome $('body').scrollTop() does change when you scroll
				// whereas $('html').scrollTop() doesn't
				// in Firefox/IE $('html').scrollTop() does change when you scroll
				// whereas $('body').scrollTop() doesn't
				scrollTop = ( scrollTop === 0 ) ? $('html').scrollTop() : scrollTop;

				if (scrollTop >= tocOffsetTop - TOC_TOP_MARGIN) {
					$toc.addClass('toc-fixed');
				} else {
					$toc.removeClass('toc-fixed');
				}
			}

			throttled = $.throttle(50, setTOCPosition);
			$(w).on('scroll', throttled);
		}

		/**
		 * Show hide Style guide section
		 *
		 * @param {Object} $target - show/hide jQuery object that gives context to which element should be shown / hiden
		 */
		function showHideSections($target) {
			var $section = $target.parent().next(),
				linkLabel;

			$section.toggleClass('shown');

			linkLabel = ($section.hasClass('shown') ?
				$.msg('styleguide-hide-parameters') : $.msg('styleguide-show-parameters'));
			$target.text(linkLabel);
		}

		/** Attach events */
		$('body').on('click', '#mw-content-text section .toggleParameters', function (event) {
			event.preventDefault();
			showHideSections($(event.target));
		});

		/** Let's skip default browser action for example links/buttons (DAR-2172) */
		$('.example').on('click', 'a', function (event) {
			event.preventDefault();
		});
	});
})();
