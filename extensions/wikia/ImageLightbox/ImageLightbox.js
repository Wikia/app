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

		var images = $('#bodyContent').find('.lightbox');
		if (!images.exists()) {
			return;
		}

		this.log('init for ' + images.length + ' images');

		images.click(function(ev) {
			self.onClick.call(self, ev);
		});
	},

	// handle click on link
	onClick: function(ev) {
		// don't follow href
		ev.preventDefault();

		var target = $(ev.target);

		// move to parent to an image - anchor
		if (target.is('img')) {
			target = target.parent();
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
			var caption = target.closest('.thumb').next('.lightbox-caption').html();

			this.show(imageName, caption);
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
				$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
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
