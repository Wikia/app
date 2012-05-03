var Lightbox = {
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
		
		
		/* extract caption - (might not need to do this since we'll be getting caption from datasource) */
		
		
		/* figure out media type (image|video) */
			/* if video and less than width threshhold, play inline video, and don't show lightbox (return) */
		
		/* figure out title */
		
		/* load modal */
		this.loadLightbox();
	},
	loadLightbox: function() {
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
				title: "Image name here"
			},
			callback: function(html) {
				/* calculate modal dimensions here */
				
				var windowHeight = $(window).height(),
					modalHeight = windowHeight - 40,
					// Never call and image with a width greater than 1000px.  
					// TODO: The image source will come from back end
					//imageSrc = 'http://placekitten.com/300/1200', // tall and skinny image
					//imageSrc = 'http://placekitten.com/1000/300', // short and fat image
					imageSrc = 'http://placekitten.com/300/300', // short and skinny image
					//imageSrc = 'http://placekitten.com/1200/1200', // tall and fat image (only happens if image is external)
					image = $("<img id='lightbox-preload' src='"+imageSrc+"' />").appendTo('body');
				
				image.load(function() {
				
					// We'll never call images that are wider than 1000px unless they are external and out of our control
					if($(this).width() > 1000) {
						$(this).width(1000);
					}
					var imageHeight = $(this).height();
								
					if(imageHeight < modalHeight) {
						modalHeight = imageHeight;
					} else {
						imageHeight = modalHeight;					
					}
					
					var modalOptions = {
						height: modalHeight,
						width: 1000
					};
					console.log("modalHeight "+modalHeight);
					console.log("imageHeight "+imageHeight);
					Lightbox.modal = $(html).makeModal(modalOptions);
					var modal = Lightbox.modal;
					var contentArea = modal.find(".WikiaLightbox");
					
					/* extract mustache templates */
					var photoTemplate = modal.find("#LightboxPhotoTemplate").html();
					// var videoTemplate = blah balh blah 
					
					/* render media */
					var json = {
						imageHeight: imageHeight,
						imageSrc: imageSrc
					}, renderedResult = Mustache.render(photoTemplate, json);
					console.log(renderedResult);
					contentArea.append(renderedResult);
					
					
					Lightbox.log("Lightbox modal loaded");
				});
			}
		});
		
	}
};

$(function() {
	Lightbox.init();
});