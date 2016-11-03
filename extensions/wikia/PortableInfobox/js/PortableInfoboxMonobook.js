(function () {
	'use strict';

	var ImageLink = {
		init: function ($content) {
			$content.find('.portable-infobox .pi-image > a.image').on('click', function () {
				var $anchor = $(this),
					fileName = $anchor.children('.pi-image-thumbnail').data('image-key');

				$anchor.attr('href', '/wiki/File:' + encodeURIComponent(fileName));
			});
		}
	};

	mw.hook('wikipage.content').add(function ($content) {
		ImageLink.init($content);
	});
})();
