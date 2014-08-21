require(['mediaGallery.toggler', 'mediaGallery.media'], function (Toggler, Media) {
	'use strict';
	$(function () {
		var visibleCount = 8,
			$galleries = $('.media-gallery-wrapper'),
			togglers = [];

		$galleries.each(function () {
			var $this = $(this),
				media = [],
				toggler = new Toggler({
					$el: $this
				});

			// create new views for each media item
			toggler.$media.each(function () {
				var medium = new Media({
					$el: $(this)
				});
				medium.init();
				media.push(medium);
			});

			visibleCount = $this.attr('data-visible-count') || visibleCount;
			if (toggler.$media.length > visibleCount) {
				toggler.init();
				togglers.push(toggler);
			}
		});
	});
});
