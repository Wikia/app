/*global WikiaPhotoGallery */
var WikiaPhotoGalleryView = {
	log: function(msg) {
		$().log(msg, 'WikiaPhotoGallery:view');
	},

	ajax: function(method, params, callback) {
		return $.get(wgScript + '?action=ajax&rs=WikiaPhotoGalleryAjax&method=' + method, params, callback, 'json');
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
			return $.getResources([
				wgExtensionsPath + '/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js',
				$.loadJQueryUI,
				$.loadJQueryAIM
			],
			callback);
		} else {
			// create deferred and automatically resolve it to pass promise pattern to callback on else statement
			var deferred = new jQuery.Deferred();
			deferred.then(callback).resolve();
			return deferred;
		}
	},

	init: function() {
		// don't run on edit page and view with oldid param in URL (leave galleries shown in preview)
		if (this.isViewPage()) {
			this.initGalleries();
		}

		this.lazyLoadGalleryImages();
	},

	// force user to log in before using gallery editor in view mode (BugId:7453)
	// returns true when log in dialog is shown
	forceLogIn: function() {
		return UserLogin.isForceLogIn();
	},

	initGalleries: function () {
		var self = this;

		// find galleries in article content
		var galleries = this.getArticle().find('.wikia-gallery').not('.template').not('.inited');
		if (galleries.exists()) {
			this.log('found ' + galleries.length + ' galleries');
		}

		var addButtonSelector = (window.skin == 'oasis') ? '.wikia-photogallery-add' : '.wikia-gallery-add';

		galleries.addClass("inited").
			children(addButtonSelector).
				// show "Add a picture to this gallery" button
				show().

					// show editor after click on a link
					click(function(ev) {
						ev.preventDefault();
						var event = jQuery.Event( "beforeGalleryShow" );
						$("body").trigger(event, [$(ev.target)]);
						if ( event.isDefaultPrevented() ) {
						    return false;
						}

						// BugId:7453
						if (self.forceLogIn()) {
							return;
						}

						var gallery = $(this).closest('.wikia-gallery'),
							hash = gallery.attr('hash'),
							id = gallery.attr('id');

						self.loadEditorJS(function() {
							WikiaPhotoGallery.ajax('getGalleryData', {hash:hash, articleId:wgArticleId}, function(data) {
								if (data && data.info == 'ok') {
									data.gallery.id = id;
									$().log('data');
									$().log(data.gallery);
									WikiaPhotoGallery.showEditor({
										from: 'view',
										gallery: data.gallery,
										target: $(ev.target).closest('.wikia-gallery')
									});
								} else {
									// something went wrong - gallery not found / user not allowed to edit
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
							if (window.skin == 'oasis') { return; }

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
							if (window.skin == 'oasis') { return; }

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
			image.css({
					height: imageHeight,
					width: imageWidth
				});
			if(!image.hasClass('lzyPlcHld')) {
				image.
					attr('src', image.attr('data-src')).
					removeAttr('data-src');
			}

			self.log('loaded: ' + image.attr('src') + ' (' + imageWidth  + 'x' + imageHeight + ')' + (crop ? ' + crop' : ''));

			if (typeof callback == 'function') {
				callback(image);
			}
		};

		// use local cache to speed up things
		var key = image.attr('data-src'),
			img;

		if (typeof self.lazyLoadCache[key] != 'undefined') {
			// get dimensions from cache
			img = {
				'width': self.lazyLoadCache[key].width,
				'height': self.lazyLoadCache[key].height
			};
			self.log('loaded: using cache');
			onload(img);
		}
		else {
			// lazy load an image
			img = new Image();
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
		$('.gallery-image-wrapper').find('img[data-src]:not(.lzyPlcHld)').each(
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
					var wrapperHeight;
					var wrapperWidth;

					if (crop) {
						wrapperHeight = Math.min(image.height(), thumbHeight);
						wrapperWidth = Math.min(image.width(), thumbWidth);
					}
					else {
						wrapperHeight = imageHeight;
						wrapperWidth = imageWidth;
					}

					// position image wrapper
					var wrapperOffsetLeft = ((thumbWidth - wrapperWidth) >> 1);
					var wrapperOffsetTop = ((thumbHeight - wrapperHeight) >> 1);

					thumb.css({
						height: wrapperHeight,
						left: wrapperOffsetLeft,
						margin: 0,
						position: 'relative',
						top: wrapperOffsetTop,
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