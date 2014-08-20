require(['mediaGallery.toggler'], function (Toggler) {
	'use strict';
	$(function () {
		var visibleCount = 8,
			$galleries = $('.media-gallery-wrapper'),
			togglers = [];

		$galleries.each(function () {
			var $this = $(this),
				toggler = new Toggler({
					$el: $this
				});

			visibleCount = $this.attr('data-visible-count') || visibleCount;
			if (toggler.$media.length > visibleCount) {
				toggler.init();
				togglers.push(toggler);

				toggler.$media.each(function () {
					$this.on('click', function () {
						Wikia.Tracker.track({
							category: 'article',
							action: Wikia.Tracker.ACTIONS.click,
							label: 'show-new-gallery-lightbox',
							trackingMethod: 'both',
							value: 0
						}, {});
					});
				});
			}
		});
	});
});
