require(['mediaGallery.toggler'], function (Toggler) {
	'use strict';
	$(function () {
		var visible = 8,
			$galleries = $('.media-gallery-wrapper'),
			togglers = [];

		$galleries.each(function () {
			var $this = $(this),
				toggler = new Toggler({
				$el: $(this)
			});

			visible = $this.attr('data-visible') || visible;
			if (toggler.$media.length > visible) {
				toggler.init();
				togglers.push(toggler);
			}
		});
	});
});
