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
				var photoTemplate = modal.find("#LightboxPhotoTemplate").html();
				var contentArea = modal.find(".WikiaLightbox");
				var json = {
					greeting: 'Hello World' 
				}, renderedResult = Mustache.render(photoTemplate, json); 
				contentArea.append(renderedResult);
				Lightbox.log("Lightbox modal loaded");
			}
		});
	}
};

$(function() {
	Lightbox.init();
});