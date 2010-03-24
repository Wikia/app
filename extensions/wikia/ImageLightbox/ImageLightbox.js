var ImageLightbox = {
	log: function(msg) {
		$().log(msg, 'ImageLightbox');
	},

	isEditPage: function() {
		return $('#wikiPreview').exists();
	},

	// setup clicks on links with .lightbox class
	init: function() {
		// don't run on edit page
		if (ImageLightbox.isEditPage()) {
			return;
		}

		var images = $('#bodyContent').find('.lightbox');
		if (!images.exists()) {
			return;
		}

		ImageLightbox.log('init for ' + images.length + ' images');
		//ImageLightbox.log(images);

		images.click(ImageLightbox.onClick);
	},

	// handle click on link
	onClick: function(ev) {
		var target = $(ev.target);

		// move to parent to an image - anchor
		if (target.is('img')) {
			target = target.parent();
		}

		// get name of an image
		var re = wgArticlePath.replace(/\$1/, '(.*)');
		var matches = target.attr('href').match(re);

		if (matches) {
			var imageName = matches.pop();
			ImageLightbox.show(imageName);
		}

		// don't follow href
		ev.preventDefault();
	},

	// show lightbox
	show: function(imageName) {
		ImageLightbox.log(imageName);

		// locking to prevent double clicks
		if (ImageLightbox.lock) {
			ImageLightbox.log('lock detected: another lightbox is loading');
			return;
		}

		ImageLightbox.lock = true;

		$.getJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
			'title': imageName,
			'maxwidth': $.getViewportWidth(),
			'maxheight': $.getViewportHeight()
		}, function(res) {
			if (res.html) {
				// popup title
				var desc = imageName.replace(/_/g, ' ');

				// open modal
				$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
					var html = '<div id="lightbox-image" title="' + desc  +'">' +
						res.html +
						'<div id="lightbox-caption" class="neutral"><a id="lightbox-link" href="' + res.href + '">&nbsp;</a></div>' +
						'</div>';

					$("#positioned_elements").append(html);
					$('#lightbox-image').makeModal({
						'id': 'lightbox',
						'width': res.width
						});
					});

				// remove lock
				delete ImageLightbox.lock;
			}
		});
	}
};

if (window.skin == 'monaco') {
	$(ImageLightbox.init);
}
