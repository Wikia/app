(function (window) {
	'use strict';

	var ImageLink = {
		init: function ($content) {
			$content.find('.portable-infobox .pi-image > a.image').on('click', function () {
				var $anchor = $(this),
					fileName = $anchor.find('img[data-image-key]').data('image-key');

				// If users create markup manually and there is no data-image-key then cancel the change
				if (fileName) {
					$anchor.attr('href', window.wgArticlePath.replace(/\$1/, 'File:' + fileName));
				}
			});
		}
	};

	mw.hook('wikipage.content').add(function ($content) {
		ImageLink.init($content);
	});
})(window);
