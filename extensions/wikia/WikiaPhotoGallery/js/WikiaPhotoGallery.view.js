/* JS to be used in view mode in Monaco skin */
var WikiaPhotoGalleryView = {
	log: function(msg) {
		$().log(msg, 'ImageGallery');
	},

	// check are we on view page
	isViewPage: function() {
		var urlVars = $.getUrlVars();
		return (window.wgAction == 'view' || window.wgAction == 'purge') &&	// view page
			(typeof urlVars.oldid == 'undefined') &&			// ignore diffs between revisions
			(window.wgNamespaceNumber != -1);				// ignore special pages
	},

	// load editor JS (if not loaded yet) and fire callback
	loadEditorJS: function(callback) {
		if (typeof WikiaPhotoGallery == 'undefined') {
			$.getScript(wgExtensionsPath + '/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js?' + wgStyleVersion, callback);
		} else {
			callback();
		}
	},

	// track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('articleAction/photogallery' + fakeUrl);
	},

	init: function() {
		// don't run on edit page and view with oldid param in URL (leave galleries shown in preview)
		if (this.isViewPage()) {
			this.initGalleries();
		}

		this.initSlideshows();
	},

	initGalleries: function () {
		var self = this;

		// find galleries in article content
		var galleries = $('#bodyContent').find('.wikia-gallery').not('.template');
		if (galleries.exists()) {
			this.log('found ' + galleries.length + ' galleries');
		}

		galleries.
			children('.wikia-gallery-add').
				// show "Add a picture to this gallery" button
				show().

				children('a').
					// show editor after click on a link
					click(function(ev) {
						ev.preventDefault();

						var gallery = $(this).parent().parent();
						var hash = gallery.attr('hash');
						var id = gallery.attr('id');
						self.log(gallery);

						var gallery = $().find('.wikia-gallery');

						self.loadEditorJS(function() {
							// tracking
							self.track('/gallery/addImage');

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
							$(this).parent().parent().
								css({
									'border-style': 'solid',
									'border-width': '1px',
									'padding': 0
								}).
								addClass('accent');
						},

						// onmouseout
						function (ev) {
							$(this).parent().parent().
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
		var slideshows = $('#bodyContent').find('.wikia-slideshow');
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

				// tracking
				var fakeUrl = '/slideshow/basic';

				if (node.hasClass('wikia-slideshow-popout')) {
					// zoom icon clicked
					fakeUrl += '/popout';
				}
				else {
					// slideshow image clicked
					if (node.attr('href')) {
						// linked image
						fakeUrl += '/imageClick/link';
					}
					else {
						fakeUrl += '/imageClick/popout';
					}
				}

				self.track(fakeUrl);

				// linked image - leave here
				if (node.attr('href')) {
					return;
				}

				// load popout
				self.loadEditorJS(function() {
					WikiaPhotoGallery.showSlideshowPopOut(id, hash, index, self.isViewPage());
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
	}
};

$(function() {
	WikiaPhotoGalleryView.init.call(WikiaPhotoGalleryView);
});
