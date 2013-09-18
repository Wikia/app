require(['jquery'], function($) {
	$(function() {

		var $toc = $('#styleguideTOC');

		if ($toc.length) {
			require(['wikia.window', 'wikia.ui.toc'], function(w, TOC) {

				var tocOffsetTop = $toc.offset().top,
					TOC_TOP_MARGIN = 10, // const for top margin of fixed TOC set in CSS
					tocInstance = new TOC($toc);

				tocInstance.init();

				/**
				 * Fix / unfix TOC position
				 */

				function setTOCPosition() {

					if($('body').scrollTop() >= tocOffsetTop - TOC_TOP_MARGIN) {
						$toc.addClass('toc-fixed');
					} else {
						$toc.removeClass('toc-fixed');
					}
				}

				var throttled = $.throttle( 50, setTOCPosition);
				$(w).on('scroll', throttled);
			});
		}

		/**
		 * Show hide Style guide section
		 *
		 * @param {Object} $target - jQuery selector (show/hide link) that gives context to which element should be show / hide
		 */

		function showHideSections($target) {
			var	$section = $target.parent().next(),
				linkLabel;

			$section.toggleClass('shown');

			linkLabel = ($section.hasClass('shown') ? $.msg( 'styleguide-hide-parameters' ) : $.msg( 'styleguide-show-parameters' ));
			$target.text(linkLabel);

		}

		/** Attach events */

		$('body').on('click', '#mw-content-text section .toggleParameters', function(event) {
			event.preventDefault();

			showHideSections($(event.target));
		});
	});
});
