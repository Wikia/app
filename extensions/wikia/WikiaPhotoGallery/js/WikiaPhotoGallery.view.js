/* JS to be used in view mode in Monaco skin */
var WikiaPhotoGalleryView = {
	log: function(msg) {
		$().log(msg, 'ImageGallery');
	},

	getArticle: function() {
		return (window.skin == 'oasis') ? $('#WikiaArticle') : $('#bodyContent');
	},

	// check are we on view page
	isViewPage: function() {
		var urlVars = $.getUrlVars();
		return (window.wgAction == 'view' || window.wgAction == 'purge') &&	// view page
			(typeof urlVars.oldid == 'undefined') &&			// ignore diffs between revisions
			(window.wgNamespaceNumber != -1);				// ignore special pages
	},

	// load jQuery UI + editor JS (if not loaded yet) and fire callback
	loadEditorJS: function(callback) {
		if (typeof WikiaPhotoGallery == 'undefined') {
			$.getScript(wgExtensionsPath + '/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js?' + wgStyleVersion, function() {
				$.loadJQueryUI(callback);
			});
		} else {
			callback();
		}
	},

	// track events
	track: function(fakeUrl) {
		$.tracker.byStr('articleAction/photogallery' + fakeUrl);

		// extra tracking for Oasis (RT #68550)
		if (window.skin == 'oasis') {
			var part = fakeUrl.split('/').pop();
			if (part == 'next' || part == 'previous' || part == 'popout') {
				$.tracker.byStr('contentpage/slideshow/' + part);
			}
		}
	},

	init: function() {
		// don't run on edit page and view with oldid param in URL (leave galleries shown in preview)
		if (this.isViewPage()) {
			this.initGalleries();
		}

		this.lazyLoadGalleryImages();
		this.initSlideshows();
	},

	initGalleries: function () {
		var self = this;

		// find galleries in article content
		var galleries = this.getArticle().find('.wikia-gallery').not('.template');
		if (galleries.exists()) {
			this.log('found ' + galleries.length + ' galleries');
		}

		var addButtonSelector = (window.skin == 'oasis') ? '.wikia-photogallery-add' : '.wikia-gallery-add';

		galleries.
			children(addButtonSelector).
				// show "Add a picture to this gallery" button
				show().

					// show editor after click on a link
					click(function(ev) {
						ev.preventDefault();

						var gallery = $(this).closest('.wikia-gallery');
						var hash = gallery.attr('hash');
						var id = gallery.attr('id');
						self.log(gallery);

						var gallery = $().find('.wikia-gallery');

						self.loadEditorJS(function() {
							// tracking
							//self.track('/gallery/addImage'); // RT #75226

							WikiaPhotoGallery.ajax('getGalleryData', {hash:hash, title:wgPageName}, function(data) {
								if (data && data.info == 'ok') {
									data.gallery.id = id;
									WikiaPhotoGallery.showEditor({
										from: 'view',
										gallery: data.gallery
									});
								} else {
									WikiaPhotoGallery.showAlert(
										data.errorCaption,
										data.error
									);
								}
							});
						});
					}).

					// highlight gallery
					hover(
						// onmousein - highlight the gallery
						function(ev) {
							if (window.skin == 'oasis') return;

							var gallery = $(this).closest('.wikia-gallery');

							gallery.
								css({
									'border-style': 'solid',
									'border-width': '1px',
									'padding': 0
								}).
								addClass('accent');
						},

						// onmouseout
						function (ev) {
							if (window.skin == 'oasis') return;

							var gallery = $(this).closest('.wikia-gallery');

							gallery.
								css({
									'border': '',
									'padding': '1px'
								}).
								removeClass('accent');
						}
					);
	},

	initSlideshows: function() {
		var self = this;

		// find slideshows in article content
		var slideshows = this.getArticle().find('.wikia-slideshow');
		if (slideshows.exists()) {
			this.log('found ' + slideshows.length + ' slideshows');
		}

		slideshows.each(function() {
			var slideshow = $(this);
			var hash = slideshow.attr('hash');
			var id = slideshow.attr('id');

			var onPopOutClickFn = function(ev) {
				// stop slideshow animation
				slideshow.trigger('stop');

				var node = $(this);

				// if user clicked on slideshow image, open popout on this image (index)
				var nodeId = node.attr('id');
				var index = nodeId ? parseInt(nodeId.split('-').pop()) : 0;

				var isFromFeed = node.parent().hasClass('wikia-slideshow-from-feed');

				// tracking
				var fakeUrl = '/slideshow/basic';

				if (node.hasClass('wikia-slideshow-popout')) {
					// zoom icon clicked
					fakeUrl += '/popout';
				}
				else {
					// slideshow image clicked
					if (node.attr('href') && !isFromFeed) {
						// linked image
						fakeUrl += '/imageClick/link';
					}
					else {
						fakeUrl += '/imageClick/popout';
					}
				}

				self.track(fakeUrl);

				// linked image - leave here
				if (node.attr('href') && !isFromFeed) {
					return;
				}

				if (isFromFeed) {
					//every image in feed slideshow has href - ctrl+click will lead to that page but by default - display popup
					ev.preventDefault();
				}

				// load popout
				self.loadEditorJS(function() {
					WikiaPhotoGallery.showSlideshowPopOut(id, hash, index, self.isViewPage(), isFromFeed);
				});
			};

			// handle clicks on "Pop Out" button
			slideshow.find('.wikia-slideshow-popout').click(onPopOutClickFn);

			// handle clicks on slideshow images
			slideshow.find('.wikia-slideshow-images').find('a').click(onPopOutClickFn);

			// handle clicks on "Add Image"
			slideshow.find('.wikia-slideshow-addimage').click(function() {
				self.loadEditorJS(function() {
					// tracking
					self.track('/slideshow/basic/addImage');

					WikiaPhotoGallery.ajax('getGalleryData', {hash:hash, title:wgPageName}, function(data) {
						if (data && data.info == 'ok') {
							data.gallery.id = id;
							WikiaPhotoGallery.showEditor({
								from: 'view',
								gallery: data.gallery
							});
						} else {
							WikiaPhotoGallery.showAlert(
								data.errorCaption,
								data.error
							);
						}
					});
				});
			});

			// update counter
			slideshow.bind('slide', function(ev, data) {
				var counter = slideshow.find('.wikia-slideshow-toolbar-counter');
				counter.text( counter.attr('value').replace(/\$1/, 1 + data.currentSlideId) );
			});

			// track clicks on prev / next
			slideshow.bind('onPrev', function() {
				self.track('/slideshow/basic/previous');
			});

			slideshow.bind('onNext', function() {
				self.track('/slideshow/basic/next');
			});

			// on-hover effects
			slideshow.find('.wikia-slideshow-images').bind({
				'mouseover': function(ev) {
					$(this).addClass('hover');
				},
				'mouseout': function(ev) {
					$(this).removeClass('hover');
				}
			});

			// hide "Add photo" button when not in view mode
			if (!self.isViewPage()) {
				slideshow.find('.wikia-slideshow-addimage').hide();
			}

			// show slideshow toolbar
			slideshow.find('.wikia-slideshow-toolbar').show();
		});
	},

	lazyLoadCache: {},

	loadAndResizeImage: function(image, thumbWidth, thumbHeight, callback, crop) {
		var self = this;
		var onload = function(img) {
			img.onload = null;	//animated gifs on IE fire this for each loop

			// fit images inside wrapper
			var imageWidth = img.width;
			var imageHeight = img.height;

			// resize image
			if (crop) {
				var widthResize = imageWidth / thumbWidth;
				var heightResize = imageHeight / thumbHeight;
				var resizeRatio = Math.min(widthResize, heightResize);

				imageHeight = Math.min(imageHeight, parseInt(imageHeight / resizeRatio));
				imageWidth = Math.min(imageWidth, parseInt(imageWidth / resizeRatio));
			}
			else {
				if (imageWidth > thumbWidth) {
					imageHeight /= (imageWidth / thumbWidth);
					imageWidth = thumbWidth;
				}
				if (imageHeight > thumbHeight) {
					imageWidth /= (imageHeight / thumbHeight);
					imageHeight = thumbHeight;
				}
			}

			imageHeight = parseInt(imageHeight);
			imageWidth = parseInt(imageWidth);

			// CSS magic for correct placement of images
			image.
				css({
					height: imageHeight,
					width: imageWidth
				}).
				attr('src', image.attr('data-src')).
				removeAttr('data-src');

			self.log('loaded: ' + image.attr('src') + ' (' + imageWidth  + 'x' + imageHeight + ')' + (crop ? ' + crop' : ''));

			if (typeof callback == 'function') {
				callback(image);
			};
		};

		// use local cache to speed up things
		var key = image.attr('data-src');

		if (typeof self.lazyLoadCache[key] != 'undefined') {
			// get dimensions from cache
			var img = {
				'width': self.lazyLoadCache[key].width,
				'height': self.lazyLoadCache[key].height
			};
			self.log('loaded: using cache');
			onload(img);
		}
		else {
			// lazy load an image
			var img = new Image();
			img.onload = function() {
				self.lazyLoadCache[key] = {
					'width': img.width,
					'height': img.height
				};

				onload(img);
			};
			img.src = image.attr('data-src');
		}
	},

	lazyLoadGalleryImages: function() {
		var self = this;

		this.log('lazy loading images...');
		$('.gallery-image-wrapper').find('img[data-src]').each(
			function() {
				var image = $(this);

				var thumb = image.closest('.gallery-image-wrapper');
				var thumbWidth = thumb.innerWidth();
				var thumbHeight = thumb.innerHeight();

				var crop = !!image.closest('.wikia-gallery').attr('data-crop');

				// lazy load current image and make it fit box with dimensions provided
				self.loadAndResizeImage(image, thumbWidth, thumbHeight, function(image) {
					var imageHeight = image.height();
					var imageWidth = image.width();

					if (crop) {
						var wrapperHeight = Math.min(image.height(), thumbHeight);
						var wrapperWidth = Math.min(image.width(), thumbWidth);
					}
					else {
						var wrapperHeight = imageHeight;
						var wrapperWidth = imageWidth;
					}

					// position image wrapper
					var wrapperOffsetLeft = (thumbWidth - wrapperWidth) >> 1;
					var wrapperOffsetTop = (thumbHeight - wrapperHeight) >> 1;

					thumb.css({
						height: wrapperHeight,
						left: wrapperOffsetLeft,
						margin: 0,
						position: 'relative',
						'top': wrapperOffsetTop,
						width: wrapperWidth,
						visibility: 'visible'
					});

					// position an image (center it within thumb node)
					image.css({
						'margin-left': Math.min(0, (thumbWidth - parseInt(imageWidth)) >> 1),
						'margin-top': Math.min(0, (thumbHeight - parseInt(imageHeight)) >> 1)
					});
				}, crop);
			}
		);
	}
};

$(function() {
	WikiaPhotoGalleryView.init.call(WikiaPhotoGalleryView);
});