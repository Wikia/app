var ImageLightbox = {
	log: function(msg) {
		$().log(msg, 'ImageLightbox');
	},

	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('lightbox' + fakeUrl);
	},

	isEditPage: function() {
		return $('#wikiPreview').exists();
	},

	// setup clicks on links with .lightbox class
	init: function() {
		var self = this;

		// don't run on edit page
		if (this.isEditPage()) {
			return;
		}

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

		// tracking
		this.track('/init');

		// render caption bar
		if (typeof caption != 'undefined') {
			caption = '<div id="lightbox-caption-content">' + caption + '</div>';
		}
		else {
			caption = '';
		}

		$.getJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
			'title': imageName,
			'maxwidth': $.getViewportWidth(),
			'maxheight': $.getViewportHeight()
		}, function(res) {
			if (res.html) {
				// open modal
				$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
					var html = '<div id="lightbox-image" title="' + res.name + '" style="text-align: center">' +
						res.html +
						'<div id="lightbox-caption" class="neutral clearfix">' +
						'<a id="lightbox-link" href="' + res.href + '" title="' + res.msg.tooltip + '"></a>' +
						caption +
						'</div></div>';

					$("#positioned_elements").append(html);
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
