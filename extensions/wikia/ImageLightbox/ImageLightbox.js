var ImageLightbox = {
	log: function(msg) {
		$().log(msg, 'ImageLightbox');
	},

	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('lightbox' + fakeUrl);
	},

	// setup clicks on links with .lightbox class
	init: function() {
		var self = this;

		// is ImageLightbox extension enabled? (RT #47665)
		if (!window.wgEnableImageLightboxExt) {
			this.log('disabled');
			return;
		}

		var images = $('#bodyContent').find('a.lightbox, a.image');
		if (!images.exists()) {
			return;
		}

		this.log('init for ' + images.length + ' images');

		images.
			unbind('.lightbox').
			bind('click.lightbox', function(ev) {
				self.onClick.call(self, ev);
			});
	},

	// handle click on link
	onClick: function(ev) {
		var target = $(ev.target);

		// move to parent to an image - anchor
		if (target.is('img')) {
			target = target.parent();
		}

		// don't show thumbs for gallery images linking to a page
		if (target.hasClass('link-internal')) {
			return;
		}

		// get name of an image
		var imageName = false;

		// ref="File:Foo.jpg"
		if (target.attr('ref')) {
			imageName = target.attr('ref');
		}
		// href="/wiki/File:Foo.jpg"
		else {
			var re = wgArticlePath.replace(/\$1/, '(.*)');
			var matches = target.attr('href').match(re);

			if (matches) {
				imageName = matches.pop();
			}
		}

		if (imageName != false) {
			// RT #44281
			imageName = decodeURIComponent(imageName);

			// find caption node and use it in lightbox popup
			var caption = false;

			if (target.hasClass('lightbox')) {
				// <gallery> lightboxes
				caption = target.closest('.thumb').next('.lightbox-caption').html();
			}
			else if (target.hasClass('image')) {
				// image thumbs
				var captionNode = target.next('.thumbcaption').clone();
				captionNode.children('.magnify').remove();

				caption = captionNode.html();
			}

			this.show(imageName, caption);

			// don't follow href
			ev.preventDefault();
		}
	},

	// show lightbox
	show: function(imageName, caption) {
		var self = this;
		this.log(imageName);

		// locking to prevent double clicks
		if (this.lock) {
			this.log('lock detected: another lightbox is loading');
			return;
		}

		this.lock = true;

		// fix caption when not provided
		caption = caption || '';

		// tracking
		this.track('/init');

		$.getJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
			'title': imageName,
			'maxwidth': $.getViewportWidth(),
			'maxheight': $.getViewportHeight()
		}, function(res) {
			if (res.html) {
				// open modal
				$.loadModalJS(function() {
					$("#positioned_elements").append(res.html);

					$('#lightbox-caption-content').html(caption);

					$('#lightbox-image').makeModal({
						'id': 'lightbox',
						'width': res.width,

						// track when popup is closed
						'onClose': function() {
							self.track('/close');
						}
					});

					// tracking
					$('#lightbox-link').click(function() {
						self.track('/details');
					});
				});

				// remove lock
				delete self.lock;
			}
		});
	}
};

if ( (typeof window.skin != 'undefined') && (window.skin == 'monaco') ) {
	$(function() {
		ImageLightbox.init.call(ImageLightbox);
	});
}
