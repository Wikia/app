/*global WikiaPhotoGalleryView, WikiaPhotoGallery */
var WikiaPhotoGallerySlideshow = {
	log: function(msg) {
		$().log(msg, 'WikiaPhotoGallery:Slideshow');
	},

	init: function(params) {
		var slideshow = $('#' + params.id),
			hash = slideshow.attr('data-hash'),
			crop = slideshow.attr('data-crop');

		var slideCallback = function(index) {
			var item = slideshow.find('li').eq(index),
				img = item.find('img').first(),
				src = img.attr('data-src');

			if(src) {
				if(crop) {
					src = Wikia.Thumbnailer.getThumbURL(src, 'image', parseInt(params.width), parseInt(params.height));
					img.css({width: params.width, height: params.height});
				}
				img.attr('src', src).removeAttr('data-src');
			}
		};

		// Lazy load first image
		slideCallback(0);

		slideshow.slideshow({
			buttonsClass: 'wikia-button',
			nextClass: 'wikia-slideshow-next',
			prevClass: 'wikia-slideshow-prev',
			slideWidth: params.width,
			slidesClass: 'wikia-slideshow-images',
			slideCallback: slideCallback,
			stayOn: true
		});

		var lastInView = false;
		$(window).on('scrollstop', function() {
			var scrollTop = $(window).scrollTop();
			var scrollBottom = scrollTop + $(window).height();
			var elemTop = slideshow.offset().top;
			var elemBottom = elemTop + slideshow.height();
			var inView = (	(scrollTop <= elemTop && scrollBottom >= elemTop) ||
				(scrollTop <= elemBottom && scrollBottom >= elemBottom ) );
			if ( inView != lastInView ) {
				if (inView) {
					slideshow.trigger('start');
				} else {
					slideshow.trigger('stop');
				}
			}
			lastInView = inView;
		});

		slideshow.find('a.wikia-slideshow-image').click(function(ev) {
			var linkType = 'lightbox';

			if (this.className.indexOf('link-internal') !== -1) {
				linkType = 'link-internal';
			} else if (this.className.indexOf('link-external') !== -1) {
				linkType = 'link-external';
			}

			Wikia.Tracker.track({
				action: 'click',
				category: 'article',
				label: 'show-slideshow-' + linkType,
				trackingMethod: 'analytics',
				value: 0
			}, {});
		});

		// handle clicks on "Add Image"
		slideshow.find('.wikia-slideshow-addimage').click(function(e) {

			// BugId:7453
			if (WikiaPhotoGalleryView.forceLogIn()) {
				return;
			}

			$.when(
				WikiaPhotoGalleryView.loadEditorJS(),
				WikiaPhotoGalleryView.ajax('getGalleryData', {hash:hash, articleId:wgArticleId})
			).then(function(loadEditorJSScripts,data) {

				//get data stuff from jQuery object passed by promise pattern
				data = data[0];

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

		// update counter
		slideshow.bind('slide', function(ev, data) {
			var counter = slideshow.find('.wikia-slideshow-toolbar-counter');
			counter.text( counter.data('counter').replace(/\$1/, 1 + data.currentSlideId) );
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

		// show slideshow toolbar
		slideshow.find('.wikia-slideshow-toolbar').show();

		// hide "Add photo" button when not in view mode
		if (!WikiaPhotoGalleryView.isViewPage()) {
			slideshow.find('.wikia-slideshow-addimage').hide();
		}

		this.log('#' + params.id + ' initialized');
	}
};
