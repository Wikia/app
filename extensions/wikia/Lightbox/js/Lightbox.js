var Lightbox = {
	lightboxLoading: false,
	
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
		var imageName = false;

		// data-image-name="Foo.jpg"
		if (target.attr('data-image-name')) {
			imageName = target.attr('data-image-name');
		}
		// ref="File:Foo.jpg"
		else if (target.attr('ref')) {
			imageName = target.attr('ref').replace('File:', '');
		}
		// href="/wiki/File:Foo.jpg"
		else {
			var re = wgArticlePath.replace(/\$1/, '(.*)');
			var matches = target.attr('href').match(re);

			if (matches) {
				imageName = matches.pop().replace('File:', '');
			}

		}
		
		// for Video Thubnails:
		var targetChildImg = target.find('img').eq(0);
		if ( targetChildImg.length > 0 && targetChildImg.hasClass('Wikia-video-thumb') ) {
			Lightbox.type = 'video';
			
			if ( target.attr('data-video-name') ) {
				
				imageName = target.attr('data-video-name');
			
			} else if ( targetChildImg.length > 0 && targetChildImg.attr('data-video') ) {
				
				imageName = targetChildImg.attr('data-video');
			}
			
			if (imageName && targetChildImg.width() >= this.videoThumbWidthThreshold) {

				this.displayInlineVideo(targetChildImg, imageName);
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
		if(imageName != false) {
			this.imageName = imageName;
			this.loadLightbox();
		}
	},
	loadLightbox: function() {
		Lightbox.lightboxLoading = true;

		$.loadLibrary(
			'Lightbox', 
			[
				stylepath + '/common/jquery/jquery.mustache.js',
				$.getSassCommonURL('/extensions/wikia/Lightbox/css/Lightbox.scss')
			],
			typeof Mustache,
			this.showLightbox
		);
	},
	showLightbox: function() {
		$.nirvana.sendRequest({
			controller: 'Lightbox',
			method: 'lightboxModalContent',
			type: 'POST',	/* TODO (hyun) - might change to get */
			format: 'html',
			data: {
				title: Lightbox.imageName,
				type: Lightbox.type
			},
			callback: function(html) {
				/* calculate modal dimensions here */
				
				image = $(html).find('#lightbox-preload').appendTo('body');
				
				image.load(function() {
					// set default dimensions if image height takes up whole window
					var image = $(this),
						topOffset = 25,
						windowHeight = $(window).height(),
						modalHeight = windowHeight - topOffset*2,  
						modalMinHeight = 648,
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
					}	
										
					var modalOptions = {
						id: 'LightboxModal',
						className: 'LightboxModal',
						height: modalHeight,
						width: 970, // modal adds 30px of padding to width
						noHeadline: true,
						topOffset: topOffset,
						topOffsetPadding: 0
					};

					Lightbox.modal = $(html).makeModal(modalOptions);
					var modal = Lightbox.modal;
					var contentArea = modal.find(".WikiaLightbox");
					
					/* extract mustache templates */
					var photoTemplate = modal.find("#LightboxPhotoTemplate").html();
					// var videoTemplate = blah blah blah 
					
					/* render media */
					var json = {
						imageHeight: imageHeight,
						imageSrc: image.attr('src')
					}; 
					
					var renderedResult = Mustache.render(photoTemplate, json);

					// Hack to vertically align the image in the lightbox
					renderedResult = $(renderedResult).css('line-height', modalHeight+'px');
					
					contentArea.append(renderedResult);					
					
					Lightbox.lightboxLoading = false;
					Lightbox.log("Lightbox modal loaded");
				});
			}
		});
		
	},
	displayInlineVideo: function() {
		// TODO: Set this up to match old version
		alert('play video inline');
	}
};

$(function() {
	Lightbox.init();
});