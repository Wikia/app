require(['jquery'], function($) {

	var $toc = $('#styleguideTOC');

	/**
	 * Fix / unfix TOC position
	 */

	if ($toc.length) {
		require(['wikia.window'], function(w) {

			var tocOffset = $toc.offset(),
				TOC_TOP_MARGIN = 10; // top margin of fixed TOC set in CSS

			function setTOCPosition() {

				if($('body').scrollTop() >= tocOffset.top - TOC_TOP_MARGIN) {
					$toc.addClass('toc-fixed');
				} else {
					$toc.removeClass('toc-fixed');
				}
			}

			var throttled = $.throttle( 200, setTOCPosition);
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

	// show / hide Style guide sections
	$('body').on('click', '#mw-content-text section .toggleParameters', function(event) {
		event.preventDefault();

		showHideSections($(event.target));
	});
});
