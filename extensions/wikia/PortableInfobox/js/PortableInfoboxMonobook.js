(function (window) {
	'use strict';

	var ImageLink = {
		init: function ($content) {
			$content.find('.portable-infobox .pi-image > a.image').on('click', function () {
				var $anchor = $(this),
					fileName = $anchor.children('.pi-image-thumbnail').data('image-key'),
					href = window.wgArticlePath.replace(/\$1/, 'File:' + encodeURIComponent(fileName));

				$anchor.attr('href', href);
			});
		}
	};

	mw.hook('wikipage.content').add(function ($content) {
		ImageLink.init($content);
	});
})(window);
