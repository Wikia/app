var ImageLightbox = {
	log: function(msg) {
		$().log(msg, 'ImageLightbox');
	},

	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('lightbox' + fakeUrl);
	},

	// setup click handler on article content
	init: function() {
		var self = this;

		// is ImageLightbox extension enabled? (RT #47665)
		if (!window.wgEnableImageLightboxExt) {
			this.log('disabled');
			return;
		}

		if (window.skin == 'oasis') {
			var article = $('#WikiaArticle, .LatestPhotosModule');
		}
		else {
			var article = $('#bodyContent');
		}

		this.log('init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(ev) {
				self.onClick.call(self, ev);
			});
	},

	// handle clicks on article content and handle clicks on links only
	onClick: function(ev) {
		var target = $(ev.target);

		// move to parent of an image -> anchor
		if (target.is('img')) {
			target = target.parent();
		}

		// handle clicks on links only
		if (!target.is('a')) {
			return;
		}

		// handle clicks on "a.lightbox, a.image" only
		if (!target.hasClass('lightbox') && !target.hasClass('image')) {
			return;
		}

		// don't show thumbs for gallery images linking to a page
		if (target.hasClass('link-internal')) {
			return;
		}

		// don't open lightbox when user do Ctrl + click (RT #48476)
		if (ev.ctrlKey) {
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
		//imageName = "File:acat.jpg";
		if (imageName != false) {
			// RT #44281
	
			imageName = decodeURIComponent(imageName);

			// find caption node and use it in lightbox popup
			var caption = false;

			if (target.hasClass('slideshow')) {
				// <gallery type="slideshow"> lightboxes
				caption = target.prev('label').html();
			}
			else if (target.hasClass('lightbox')) {
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

		// calculate maximum dimensions for image
		var maxWidth = $.getViewportWidth();
		var maxHeight = $.getViewportHeight();

		if (window.skin == 'oasis') {
			maxHeight -= 75;
			maxWidth = 850;
		}

		// get resized image from server
		$.getJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
			'maxheight': maxHeight,
			'maxwidth': maxWidth,
			'title': imageName
		}, function(res) {
			if (res && res.html) {
				// open modal
				$.showModal(res.title, res.html, {
					'id': 'lightbox',
					'width': res.width,

					// track when popup is closed
					'onClose': function() {
						self.track('/close');
					},

					// setup tracking
					'callback': function() {
						$('#lightbox-link').click(function() {
							self.track('/details');
						});

						$('#lightbox-caption-content').html(caption);

						// remove lock
						delete self.lock;
					}
				});
			}
		});
	}
};

if ( (typeof window.skin != 'undefined') && (window.skin == 'monaco' || window.skin == 'oasis') ) {
	$(function() {
		ImageLightbox.init.call(ImageLightbox);
	});
}
