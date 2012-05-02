var Lightbox = {

	log: function(msg) {
		$().log(msg, 'Lightbox');
	},

	track: function(fakeUrl) {
		// TODO: this is the old tracker system.  Should be replaced with new data warehouse stuff. 
		window.jQuery.tracker.byStr('lightbox' + fakeUrl);
	},

	// setup click handler on article content
	init: function() {
		// is Lightbox extension enabled?
		if (!window.wgEnableLightboxExt) {
			this.log('disabled');
			return;
		}
		
		var article = $('#WikiaArticle, .LatestPhotosModule, #article-comments');
		article.on('click', this.handleClick);
	
	},
	
	// handle clicks on article content and handle clicks on links only
	handleClick: function(e) {
		var target = $(e.target);
        this.wikiAddress = false;

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
		if (e.ctrlKey) {
			return;
		}
		
		// store clicked element
		this.target = target;
		
		alert('open lightbox');

		e.preventDefault();
		return;
	}
}


if ( window.skin && window.skin == 'oasis') {
	$(function() {
		Lightbox.init();
		
		// TODO: figure out what this does (copied from ImageLightbox.js)
		var image = $('#' + $.getUrlVar('image'));
		if (image.exists()) {
			$(window).scrollTop(image.offset().top + image.height()/2 - $(window).height()/2);
			image.find('img').click();
		}
	});
}
