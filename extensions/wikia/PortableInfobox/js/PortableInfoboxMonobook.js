(function () {
	'use strict';

	var ImageLink = {
		init: function ($content) {
			var $anchors = $content.find('.portable-infobox .pi-image > a.image');

			$anchors.each(function () {
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
