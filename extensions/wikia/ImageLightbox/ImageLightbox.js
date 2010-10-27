var ImageLightbox = {
	// store element which was clicked to trigger lightbox - custom event will be fired when lightbox will be shown
	target: false,

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

//		this.log('init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(ev) {
				self.onClick.call(self, ev);
			});
	},

	// get caption node for given target node
	getCaption: function(target) {
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

		return caption;
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

		// don't show lightbox for linked slideshow with local images (RT #73121)
		if (target.hasClass('wikia-slideshow-image') && !target.parent().hasClass('wikia-slideshow-from-feed')) {
			return;
		}

		// don't open lightbox when user do Ctrl + click (RT #48476)
		if (ev.ctrlKey) {
			return;
		}

		// store clicked element
		this.target = target;

		// handle lightboxes for external images
		if (target.hasClass('link-external')) {
			var caption = this.getCaption(target);

			var image = target.children('img');
			var html = '<div id="lightbox-image" style="text-align: center"><img src="' + image.attr('src') + '" alt="" /></div>' +
				'<div id="lightbox-caption-content"></div>';

			this.showLightbox(target.closest('.wikia-gallery').attr('data-feed-title'), html, caption);

			// don't follow the link
			ev.preventDefault();
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
			var caption = this.getCaption(target);
			this.fetchLightbox(imageName, caption);

			// don't follow href
			ev.preventDefault();
		}
	},

	// fetch data and show lightbox
	fetchLightbox: function(imageName, caption) {
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
				self.showLightbox(res.title, res.html, caption, res.width);
			}
		});
	},

	// create modal popup
	showLightbox: function(title, content, caption, width) {
		var self = this;

		// fix caption when not provided
		caption = caption || '';

		$.showModal(title, content, {
			'id': 'lightbox',
			'width': width ? width : 'auto',

			// track when popup is closed
			'onClose': function() {
				self.track('/close');
			},

			// setup tracking
			'callback': function() {
				var lightbox = $('#lightbox');

				$('#lightbox-link').click(function() {
					self.track('/details');
				});

				$('#lightbox-caption-content').html(caption);

				// resize lightbox (used mostly for external images)
				lightbox.resizeModal(lightbox.width());

				// RT #69824
				if (window.skin == 'oasis') {
					lightbox.css('top', lightbox.getModalTopOffset());
				}

				// fire custom event (RT #74852)
				if (self.target) {
					self.target.trigger('lightbox', [lightbox]);
					self.target = false;
				}

				// remove lock
				delete self.lock;
			}
		});
	}
};

if ( (typeof window.skin != 'undefined') && (window.skin == 'monaco' || window.skin == 'oasis') ) {
	$(function() {
		ImageLightbox.init.call(ImageLightbox);
	});
}
