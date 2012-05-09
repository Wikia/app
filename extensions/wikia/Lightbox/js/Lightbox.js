var Lightbox = {
	lightboxLoading: false,
	videoThumbWidthThreshold: 320,
	inlineVideos: $(),	// jquery array of inline videos
	inlineVideoLinks: $(),	// jquery array of inline video links
	log: function(content) {
		$().log(content, "Lightbox");
	},
	// Array of image/video titles on the page. This will come from backend.
	media: {
		type: '', // image or video
		title: '', // currently displayed file name
		carouselType: '', // article, relatedVideos, or latestPhotos
		currIndex: 1, //-1, // ex: Lightbox.media[Lightbox.media.carouselType][currIndex]
		// Article Media
		article: [],
		// Related Video
		relatedVideos: [],
		// Lates Photos
		latestPhotos: [],	
	},
	modal: {
		defaults: {
			videoHeight: 360,
			topOffset: 25,
			height: 648
		},
		// start with default modal options
		initial: {
			id: 'LightboxModal',
			className: 'LightboxModal',
			width: 970, // modal adds 30px of padding to width
			noHeadline: true,
			topOffset: 25,
			height: 648
		}
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
			bind('click.lightbox', function(e) {
                self.handleClick.call(self, e, $(this));
			});
				
		// Clicking left/right arrows inside Lightbox
		$('body').on('click', '#LightboxNext, #LightboxPrevious', function(e) {
			var carouselType = self.media.carouselType,
				mediaArr = self.media[carouselType],
				idx = self.media.currIndex,
				target = $(e.target);
		
			if(target.is("#LightboxNext")) {
				idx++;
			} else {
				idx--;
			}
			if(idx > -1 && idx < mediaArr) {
				self.media.title = mediaArr[idx].title;
				var type = mediaArr[idx].type;
				self.updateArrows();
				$.proxy(self[type].updateLightbox(), self);
			}
		});

	},
	handleClick: function(ev, parent) {
		var self = this,
			id = parent.attr('id');

		// Set carousel type based on parent of image
		switch(id) {
			case "WikiaArticle": 
				self.media.carouselType = "article";
				break;
			case "article-comments":
				self.media.carouselType = "article";
				break;
			case "RelatedVideosRL":
				self.media.carouselType = "relatedVideo";
				break;
			default: // .LatestPhotosModule
				self.media.carouselType = "latestPhotos";
		}
		
		/* figure out target */
		if(this.lightboxLoading) {
			ev.preventDefault();
			Lightbox.log('Already Loading');
			return;
		}
		
		var target = $(ev.target);

		// move to parent of an image -> anchor
		if ( target.is('span') || target.is('img') ) {
			target = target.parent();
			if ( target.hasClass('Wikia-video-play-button') || target.hasClass('Wikia-video-thumb') ) {
				target.addClass('image');
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
		
		// for Video Thumbnails:
		var targetChildImg = target.find('img').eq(0);
		if ( targetChildImg.length > 0 && targetChildImg.hasClass('Wikia-video-thumb') ) {
			Lightbox.media.type = 'video';
			
			if ( target.data('video-name') ) {
				mediaTitle = target.data('video-name');
			} else if ( targetChildImg.data('video') ) {
				mediaTitle = targetChildImg.data('video');
			}
			
			// check if we need to play video inline, and stop lightbox execution
			if (mediaTitle && targetChildImg.width() >= this.videoThumbWidthThreshold) {
				this.displayInlineVideo(target, targetChildImg, mediaTitle);
				ev.preventDefault();
				return false;	// stop modal dialog execution
			}
		} else {
			Lightbox.media.type = 'image';
		}
		
		
		/* extract caption - (might not need to do this since we'll be getting caption from datasource) */
		
		
		/* figure out media type (image|video) */
			/* if video and less than width threshhold, play inline video, and don't show lightbox (return) */
		
		/* figure out title */
		
		/* load modal */
		if(mediaTitle != false) {
			this.media.title = mediaTitle;
			this.loadLightbox();
		}
	},
	loadLightbox: function() {
		Lightbox.lightboxLoading = true;

		// Load resources
		$.when(
			$.loadMustache(),
			$.getResources([$.getSassCommonURL('/extensions/wikia/Lightbox/css/Lightbox.scss')])
		).done(this.makeLightbox);

	},
	makeLightbox: function() {
		$.nirvana.sendRequest({
			controller: 'Lightbox',
			method: 'lightboxModalContent',
			type: 'POST',	/* TODO (hyun) - might change to get */
			format: 'html',
			data: {
				title: Lightbox.media.title,
			},
			callback: function(html) {
				// restore inline videos to default state, because flash players overlaps with modal
				Lightbox.removeInlineVideos();

				/* Display modal with default dimensions */
				Lightbox.openModal = $(html).makeModal(Lightbox.modal.initial);
	
				data = $.parseJSON(initialFileDetail); // defined in modal template
				
				if(Lightbox.media.type == 'image') {
					Lightbox.image.updateLightbox(data);
				} else {
					Lightbox.makeVideoModal(html);
				}
			}
		});
	},
	image: {
		updateLightbox: function(data) {

			this.getDimensions(data.imageUrl, function(dimensions) {
				Lightbox.openModal.animate({
					top: dimensions.topOffset,
					height: dimensions.modalHeight
				}, 
				500, 
				function() {
					var contentArea = $(this).find(".WikiaLightbox");
					
					// extract mustache templates
					var photoTemplate = $(this).find("#LightboxPhotoTemplate");
					
					// render media
					var json = {
						imageHeight: dimensions.imageHeight,
						imageUrl: data.imageUrl
					};
					
					var renderedResult = photoTemplate.mustache(json);
		
					// Hack to vertically align the image in the lightbox
					renderedResult = $(renderedResult).css('line-height', dimensions.modalHeight+'px');
					
					contentArea.append(renderedResult);			
					
					Lightbox.updateArrows();
					Lightbox.lightboxLoading = false;
					Lightbox.log("Lightbox modal loaded");
					
				});
			});

			/* get media details based on title - nirvana request or from template */
			/* call getDimensions */
			/* resize modal */
			/* render mustache template */		
		},
		getDimensions: function(imageUrl, callback) {
			/* Get image url from json - preload image */
			var image = $('<img id="LightboxPreload" src="'+imageUrl+'" />').appendTo('body');
			
			/* do calculations */
			image.load(function() {
				var image = $(this),
					topOffset = Lightbox.modal.defaults.topOffset,
					modalMinHeight = Lightbox.modal.defaults.modalMinHeight,
					windowHeight = $(window).height(),
					modalHeight = windowHeight - topOffset*2,  
					modalHeight = modalHeight < modalMinHeight ? modalMinHeight : modalHeight;

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
				
				topOffset = topOffset + $(window).scrollTop();
				
				var dimensions = {
					modalHeight: modalHeight,
					topOffset: topOffset,
					imageHeight: imageHeight
				}
				
				// remove preloader image
				$(this).remove();
				
				callback(dimensions);
			});
		}
	},
	video: {
		updateLightbox: function() {
			var title = self.media.title;
			console.log(title);
			/* call getDimensions */
			/* resize modal */
			/* render mustache template */		
		},
		getDimensions: function() {
			/* if window is larger than min modal height, update modal height */
		}	
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
		var videoTemplate = modal.find("#LightboxVideoTemplate");

		/* render media */
		var json = {
			embed: initialFileDetail.videoEmbedCode // initialFileDetail defined in modal template
		}
		
		var renderedResult = videoTemplate.mustache(json);

		renderedResult = $(renderedResult).css('margin-top', mediaTopMargin);

		contentArea.append(renderedResult);					
		
		Lightbox.updateArrows();
		Lightbox.log("Lightbox modal loaded");
		Lightbox.lightboxLoading = false;
	},
	displayInlineVideo: function(target, targetChildImg, mediaTitle) {
		$.nirvana.sendRequest({
			controller: 'Lightbox',
			method: 'getMediaDetail',
			type: 'POST',	/* TODO (hyun) - might change to get */
			format: 'json',
			data: {
				title: mediaTitle,
				height: targetChildImg.height(),
				width: targetChildImg.width()
			},
			callback: function(json) {
				var embedCode = $(json['videoEmbedCode']);
				target.hide().after(embedCode);
				var videoReference = target.next();	//retrieve DOM reference
				
				// save references for inline video removal later
				Lightbox.inlineVideoLinks = target.add(Lightbox.inlineVideoLinks);
				Lightbox.inlineVideos = videoReference.add(Lightbox.inlineVideos);
			}
		});
	},
	removeInlineVideos: function() {
		Lightbox.inlineVideos.remove();
		Lightbox.inlineVideoLinks.show();
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
		Lightbox.log(this.media.title);
	},
	updateArrows: function() {
		var self = this; // for consistency
		
		var carouselType = self.media.carouselType,
			mediaArr = self.media[carouselType],
			idx = self.media.currIndex;
			
		var next = $('#LightboxNext'),
			previous = $('#LightboxPrevious');
			
		if(idx == mediaArr - 1) {
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