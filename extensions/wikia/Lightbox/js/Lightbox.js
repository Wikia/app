var Lightbox = {
	// Array of image/video titles on the page. This will come from backend.
	mediaTitles: [
		'500x1700.jpeg',
		'IMG 1535.jpg',
		'The Dark Knight (2008) - Hit Me!',
		'Return to Fallout New Vegas Walkthrough with Commentary Part 1 - The High-Five Returns'
	],
	lightboxLoading: false,
	mediaTitle: false,
	modalConfig: {
		topOffset: 25,
		modalMinHeight: 648,
		videoHeight: 360
	},
	log: function(content) {
		$().log(content, "Lightbox");
	},
	init: function() {
		var self = this,
			article;

		if (!window.wgEnableLightboxExt) {
			self.log('Lightbox disabled');
			return;
		}

		if (window.skin == 'oasis') {
			article = $('#WikiaArticle, .LatestPhotosModule, #article-comments, #RelatedVideosRL');
		}
		else {
			article = $('#bodyContent');
		}

		self.log('Lightbox init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', $.proxy(this.handleClick, this));
				
		// Clicking left/right arrows inside Lightbox
		$('body').on('click', '#LightboxNext, #LightboxPrevious', function(e) {
			var idx = self.mediaTitles.indexOf(self.mediaTitle),
				target = $(e.target);
			if(target.is("#LightboxNext")) {
				idx++;
			} else {
				idx--;
			}
			if(idx > -1 && idx < self.mediaTitles.length) {
				self.mediaTitle = self.mediaTitles[idx];
				self.updateArrows();
				$.proxy(self.updateLightbox(), self);
			}
		});

	},
	handleClick: function(ev) {
		/* figure out target */
		if(this.lightboxLoading) {
			ev.preventDefault();
			Lightbox.log('Already Loading');
			return;
		}
		
		var target = $(ev.target);

		// move to parent of an image -> anchor
		if ( target.is('span') || target.is('img') ) {
			if ( target.hasClass('Wikia-video-play-button') || target.hasClass('Wikia-video-thumb') ) {
				target = target.parent();
				target.addClass('image');
			} else {
				target = target.parent();
			}	
		}
        // move to parent of an playButton (relatedVideos)
        if (target.is('div') && target.hasClass('playButton')) {
            target = target.parent();
        }

		// store clicked element
		this.target = target;

		/* handle click ignore cases */

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
		
		// TODO: Find out how we want to handle external images 
		/* handle shared help images and external images (ask someone who knows about this, probably Macbre) */
		/* sample: http://lizlux.wikia.com/wiki/Help:Start_a_new_Wikia_wiki */
		/* (BugId:981) */
		/* note - let's not implement this for now, let normal lightbox handle it normally, and get back to it after new lightbox is complete - hyun */		
		if (target.attr('data-shared-help') || target.hasClass('link-external')) {
			return false;
		}

		ev.preventDefault();		
		
		// get name of an image
		var mediaTitle = false;

		// data-image-name="Foo.jpg"
		if (target.attr('data-image-name')) {
			mediaTitle = target.attr('data-image-name');
		}
		// ref="File:Foo.jpg"
		else if (target.attr('ref')) {
			mediaTitle = target.attr('ref').replace('File:', '');
		}
		// href="/wiki/File:Foo.jpg"
		else {
			var re = wgArticlePath.replace(/\$1/, '(.*)');
			var matches = target.attr('href').match(re);

			if (matches) {
				mediaTitle = matches.pop().replace('File:', '');
			}

		}
		
		// for Video Thubnails:
		var targetChildImg = target.find('img').eq(0);
		if ( targetChildImg.length > 0 && targetChildImg.hasClass('Wikia-video-thumb') ) {
			Lightbox.type = 'video';
			
			if ( target.attr('data-video-name') ) {
				
				mediaTitle = target.attr('data-video-name');
			
			} else if ( targetChildImg.length > 0 && targetChildImg.attr('data-video') ) {
				
				mediaTitle = targetChildImg.attr('data-video');
			}
			
			if (mediaTitle && targetChildImg.width() >= this.videoThumbWidthThreshold) {

				this.displayInlineVideo(targetChildImg, mediaTitle);
				ev.preventDefault();
				return false;
			}
		} else {
			Lightbox.type = 'image';
		}
		
		
		/* extract caption - (might not need to do this since we'll be getting caption from datasource) */
		
		
		/* figure out media type (image|video) */
			/* if video and less than width threshhold, play inline video, and don't show lightbox (return) */
		
		/* figure out title */
		
		/* load modal */
		if(mediaTitle != false) {
			this.mediaTitle = mediaTitle;
			this.loadLightbox();
		}
	},
	loadLightbox: function() {
		Lightbox.lightboxLoading = true;

		$.when(
			$.loadMustache(),
			$.getResources([$.getSassCommonURL('/extensions/wikia/Lightbox/css/Lightbox.scss')])
		).done(this.showLightbox);

	},
	showLightbox: function() {
		$.nirvana.sendRequest({
			controller: 'Lightbox',
			method: 'lightboxModalContent',
			type: 'POST',	/* TODO (hyun) - might change to get */
			format: 'html',
			data: {
				title: Lightbox.mediaTitle,
			},
			callback: function(html) {
				if(Lightbox.type == 'image') {
					Lightbox.makeImageModal(html);
				} else {
					Lightbox.makeVideoModal(html);
				}
			}
		});
	},
	makeImageModal: function(html) {
		html = $(html);
		
		// pre-load image to calculate modal dimensions
		var image = html.find("#LightboxPreload").remove().find('img').appendTo('body');
		
		image.load(function() {
			// set default dimensions if image height takes up whole window
			var image = $(this),
				topOffset = Lightbox.modalConfig.topOffset,
				modalMinHeight = Lightbox.modalConfig.modalMinHeight,
				windowHeight = $(window).height(),
				modalHeight = windowHeight - topOffset*2,  
				modalHeight = modalHeight < modalMinHeight ? modalMinHeight : modalHeight,
				imageSrc = image.attr('src');
							
			// Just in case image is wider than 1000px
			if(image.width() > 1000) {
				image.width(1000);
			}
			var imageHeight = image.height();
						
			if(imageHeight < modalHeight) {
				// Image is shorter than screen, adjust modal height
				modalHeight = imageHeight;
				
				// Modal has a min height
				if(modalHeight < modalMinHeight) {
					modalHeight = modalMinHeight;
				}

				// Calculate modal's top offset
				var extraHeight = windowHeight - modalHeight - 10; // 5px modal border
				
				newOffset = (extraHeight / 2);
				if(newOffset < topOffset){
					newOffset = topOffset; 
				}
				topOffset = newOffset;
				
			} else {
				// Image is taller than screen, shorten image
				imageHeight = modalHeight;
				topOffset = topOffset - 5; // 5px modal border
			}	
			
			var modalOptions = Lightbox.getModalOptions(modalHeight, topOffset);
			
			var modal = html.makeModal(modalOptions);
			var contentArea = modal.find(".WikiaLightbox");
			
			// remove fake image
			image.remove();
			
			/* extract mustache templates */
			var photoTemplate = modal.find("#LightboxPhotoTemplate").html();
			
			/* render media */
			var json = {
				imageHeight: imageHeight,
				imageSrc: imageSrc
			};
			
			var renderedResult = Mustache.render(photoTemplate, json);

			// Hack to vertically align the image in the lightbox
			renderedResult = $(renderedResult).css('line-height', modalHeight+'px');
			
			contentArea.append(renderedResult);					
			
			Lightbox.updateArrows();
			Lightbox.lightboxLoading = false;
			Lightbox.log("Lightbox modal loaded");
		});
	},
	makeVideoModal: function(html) {
		html = $(html);

		var topOffset = Lightbox.modalConfig.topOffset,
			modalMinHeight = Lightbox.modalConfig.modalMinHeight,
			windowHeight = $(window).height(),
			modalHeight = windowHeight - topOffset*2 - 10, // 5px modal border
			modalHeight = modalHeight < modalMinHeight ? modalMinHeight : modalHeight,
			mediaTopMargin = (modalHeight - Lightbox.modalConfig.videoHeight) / 2;
		
		var modalOptions = Lightbox.getModalOptions(modalHeight, topOffset);
		
		
		
		var modal = $(html).makeModal(modalOptions);
		var contentArea = modal.find(".WikiaLightbox");

		/* extract mustache templates */
		var videoTemplate = modal.find("#LightboxVideoTemplate").html();

		/* render media */
		var json = {
			embed: LightboxVar.videoEmbedCode // LightboxVar defined in modal template
		}
		
		var renderedResult = Mustache.render(videoTemplate, json);

		renderedResult = $(renderedResult).css('margin-top', mediaTopMargin);

		contentArea.append(renderedResult);					
		
		Lightbox.updateArrows();
		Lightbox.log("Lightbox modal loaded");
		Lightbox.lightboxLoading = false;
	},
	displayInlineVideo: function() {
		// TODO: Set this up to match old version
		alert('play video inline');
	},
	getModalOptions: function(modalHeight, topOffset) {
		var modalOptions = {
			id: 'LightboxModal',
			className: 'LightboxModal',
			height: modalHeight,
			width: 970, // modal adds 30px of padding to width
			noHeadline: true,
			topOffset: topOffset
		};
		return modalOptions;
	},
	updateLightbox: function() {
		Lightbox.log(this.mediaTitle);
	},
	updateArrows: function() {
		var idx = this.mediaTitles.indexOf(this.mediaTitle),
			next = $('#LightboxNext'),
			previous = $('#LightboxPrevious');
			
		if(idx == this.mediaTitles.length - 1) {
			next.addClass('disabled');
			previous.removeClass('disabled');
		} else if(idx == 0) {
			previous.addClass('disabled');
			next.removeClass('disabled');
		} else {
			previous.removeClass('disabled');
			next.removeClass('disabled');
		}
	}

};

$(function() {
	Lightbox.init();
});