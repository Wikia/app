/*global WikiaPhotoGalleryView, WikiaPhotoGallery */
var WikiaPhotoGallerySlideshow = {
	log: function(msg) {
		$().log(msg, 'WikiaPhotoGallery:Slideshow');
	},

	init: function(params) {
		var slideshow = $('#' + params.id),
			hash = slideshow.attr('data-hash'),
			item = slideshow.find('li').first(),
			title = item.attr('title');

		if (title != '') {
			item.css('backgroundImage', 'url(' + title + ')');
		}

		item.removeAttr('title');

		slideshow.slideshow({
			buttonsClass: 'wikia-button',
			nextClass: 'wikia-slideshow-next',
			prevClass: 'wikia-slideshow-prev',
			slideWidth: params.width,
			slidesClass: 'wikia-slideshow-images',
			slideCallback: function(index) {
				var item = slideshow.find('li').eq(index),
					title = item.attr('title');
				if (title) {
					item.css('backgroundImage', 'url(' + title + ')');
					item.removeAttr('title');
				}
			}
		});

		// handle clicks on "Pop Out" button
		slideshow.find('.wikia-slideshow-popout').click(this.onPopOutClickFn)

		// handle clicks on slideshow images
		.find('.wikia-slideshow-images a').click(this.onPopOutClickFn)

		// handle clicks on "Add Image"
		.find('.wikia-slideshow-addimage').click(function(e) {
			WikiaPhotoGalleryView.loadEditorJS(function() {
				// tracking
				WikiaPhotoGalleryView.track('/slideshow/basic/addImage');

				// BugId:7453
				if (WikiaPhotoGalleryView.forceLogIn()) {
					return;
				}

				WikiaPhotoGallery.ajax('getGalleryData', {hash:hash, articleId:wgArticleId}, function(data) {
					if (data && data.info == 'ok') {
						data.gallery.id = params.id;
						WikiaPhotoGallerySlideshow.log(data.gallery);
						WikiaPhotoGallery.showEditor({
							from: 'view',
							gallery: data.gallery,
							target: $(e.target).closest('.wikia-slideshow')
						});
					} else {
						WikiaPhotoGallery.showAlert(
							data.errorCaption,
							data.error
						);
					}
				});
			});
		})

		// update counter
		.bind('slide', function(ev, data) {
			var counter = slideshow.find('.wikia-slideshow-toolbar-counter');
			counter.text( counter.data('counter').replace(/\$1/, 1 + data.currentSlideId) );
		})

		// track clicks on prev / next
		.bind('onPrev', function() {
			WikiaPhotoGalleryView.track('/slideshow/basic/previous');
		})

		.bind('onNext', function() {
			WikiaPhotoGalleryView.track('/slideshow/basic/next');
		})

		// on-hover effects
		.find('.wikia-slideshow-images').bind({
			'mouseover': function(ev) {
				$(this).addClass('hover');
			},
			'mouseout': function(ev) {
				$(this).removeClass('hover');
			}
		})

		// show slideshow toolbar
		.find('.wikia-slideshow-toolbar').show();

		// hide "Add photo" button when not in view mode
		if (!WikiaPhotoGalleryView.isViewPage()) {
			slideshow.find('.wikia-slideshow-addimage').hide();
		}

		this.log('#' + params.id + ' initialized');
	},

	onPopOutClickFn: function(ev) {
		var node = $(this),
		slideshow = node.closest('.wikia-slideshow'),
		nodeId = node.attr('id'),
		// if user clicked on slideshow image, open popout on this image (index)
		index = nodeId ? parseInt(nodeId.split('-').pop()) : 0,
		isFromFeed = node.parent().hasClass('wikia-slideshow-from-feed'),
		// tracking
		fakeUrl = '/slideshow/basic';

		// stop slideshow animation
		slideshow.trigger('stop');

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

		WikiaPhotoGalleryView.track(fakeUrl);

		// linked image - leave here
		if (node.attr('href') && !isFromFeed) {
			return;
		}

		if (isFromFeed) {
			//every image in feed slideshow has href - ctrl+click will lead to that page but by default - display popup
			ev.preventDefault();
		}

		// load popout
		WikiaPhotoGalleryView.loadEditorJS(function() {
			WikiaPhotoGallery.showSlideshowPopOut(slideshow.attr('id'), slideshow.attr('data-hash'), index, WikiaPhotoGalleryView.isViewPage(), isFromFeed);
		});
	}
};
