/* JS to be used in view mode in Monaco skin */
var WikiaImageGalleryView = {
	log: function(msg) {
		$().log(msg, 'ImageGallery');
	},

	isEditPage: function() {
		return $('#wikiPreview').exists();
	},

	init: function() {
		// don't run on edit page (leave galleries shown in preview)
		if (WikiaImageGalleryView.isEditPage()) {
			return;
		}

		// find galleries in article content
		var galleries = $('#bodyContent').find('.wikia-gallery');
		if (!galleries.exists()) {
			return;
		}

		WikiaImageGalleryView.log('found ' + galleries.length + ' galleries');

		galleries.
			hover(
				// onmousein - highlight the gallery
				function(ev) {
					$(this).
						css('border', 'solid 1px').
						addClass('accent');
				},

				// onmouseout
				function (ev) {
					$(this).
						css('border', '').
						removeClass('accent');
				}
			).
			children('.wikia-gallery-add').
				// show "Add a picture to this gallery" button
				show().

				// show editor after click on a link
				children('a').click(function(ev) {
					ev.preventDefault();

					var gallery = $(this).parent().parent();
					WikiaImageGalleryView.log(gallery);

					// TODO: show editor
				});
	}
};

$(WikiaImageGalleryView.init);
