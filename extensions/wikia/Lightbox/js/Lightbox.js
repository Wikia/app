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
			article = $('#WikiaArticle, .LatestPhotosModule, #article-comments');
		}
		else {
			article = $('#bodyContent');
		}

		self.log('Lightbox init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(ev) {
				self.onClick.call(self, ev);
			});

        // also bind to right rail RelatedVideos module
        // TODO (hyun) - combine this with above, or separate it
        /*
        $('#RelatedVideosRL').
            unbind('.lightbox').
            bind('click.lightbox', function(ev) {
                self.onClick.call(self, ev);
            });
        */
	},
	onClick: function(ev) {
		ev.preventDefault();
		
		/* figure out target */
		
		/* handle click ignore cases */
		
		/* extract caption - (might not need to do this since we'll be getting caption from datasource) */
		
		/* handle shared help images (ask someone who knows about this, probably TOR) */
		/* sample: http://lizlux.wikia.com/wiki/Help:Start_a_new_Wikia_wiki */
		/* (BugId:981) */
		/* note - let's not implement this for now, let normal lightbox handle it normally, and get back to it after new lightbox is complete - hyun */
		
		/* handle external images (find an example for this, ask TOR) */
		
		/* figure out media type (image|video) */
			/* if video and less than width threshhold, play inline video, and don't show lightbox (return) */
		
		/* figure out title */
		
		/* load modal */
		
		if(!window.Mustache) {
			$.loadMustache();
		}
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
				var modalOptions = {
					height: 600,
					width: 1000
				};
				Lightbox.modal = $(html).makeModal(modalOptions);
				var modal = Lightbox.modal;
				var contentArea = modal.find(".WikiaLightbox");
				
				/* extract mustache templates */
				var photoTemplate = modal.find("#LightboxPhotoTemplate").html();
				// var videoTemplate = blah balh blah 
				
				/* render media */
				var json = {
					greeting: 'Hello World' 
				}, renderedResult = Mustache.render(photoTemplate, json); 
				contentArea.append(renderedResult);
				
				
				Lightbox.log("Lightbox modal loaded");
			}
		});
	},
	showLightBox: function() {
		
	}
};

$(function() {
	Lightbox.init();
});