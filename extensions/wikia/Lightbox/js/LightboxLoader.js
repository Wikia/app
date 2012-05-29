var LightboxLoader = {
	cache: {
		articleMedia: [], // Article Media
		relatedVideos: [], // Related Video
		latestPhotos: [], // Lates Photos
		details: {}, // all media details
		share: {}
	},
	inlineVideos: $(),	// jquery array of inline videos
	inlineVideoLinks: $(),	// jquery array of inline video links
	lightboxLoading: false,
	modal: {
		// start with default modal options
		initial: {
			id: 'LightboxModal',
			className: 'LightboxModal',
			width: 970, // modal adds 30px of padding to width
			noHeadline: true,
			topOffset: 25,
			height: 628
		}
	},
	videoThumbWidthThreshold: 320,
	log: function(content) {
		$().log(content, "LightboxLoader");
	},
	init: function() {
		var article;

		if (!window.wgEnableLightboxExt) {
			return;
		}

		article = $('#WikiaArticle, .LatestPhotosModule, #article-comments, #RelatedVideosRL');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(e) {
                LightboxLoader.handleClick(e, $(this));
			});

	},
	handleClick: function(ev, parent) {
		var id = parent.attr('id');

		// Set carousel type based on parent of image
		switch(id) {
			case "WikiaArticle": 
				LightboxLoader.carouselType = "articleMedia";
				break;
			case "article-comments":
				LightboxLoader.carouselType = "articleMedia";
				break;
			case "RelatedVideosRL":
				LightboxLoader.carouselType = "relatedVideo";
				break;
			default: // .LatestPhotosModule
				LightboxLoader.carouselType = "latestPhotos";
		}
		
		// figure out target
		if(LightboxLoader.lightboxLoading) {
			ev.preventDefault();
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
				
		// get file name
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
			if ( target.data('video-name') ) {
				mediaTitle = target.data('video-name');
			} else if ( targetChildImg.data('video') ) {
				mediaTitle = targetChildImg.data('video');
			}
			
			// check if we need to play video inline, and stop lightbox execution
			if (mediaTitle && targetChildImg.width() >= LightboxLoader.videoThumbWidthThreshold) {
				LightboxLoader.displayInlineVideo(target, targetChildImg, mediaTitle);
				ev.preventDefault();
				return false;	// stop modal dialog execution
			}
		}
		

		// load modal
		if(mediaTitle != false) {
			LightboxLoader.loadLightbox(mediaTitle);
		}
	},
	loadLightbox: function(mediaTitle) {
		// restore inline videos to default state, because flash players overlaps with modal
		LightboxLoader.removeInlineVideos();
		LightboxLoader.lightboxLoading = true;

		// Display modal with default dimensions
		var openModal = $("<div>").makeModal(LightboxLoader.modal.initial);
		openModal.find(".modalContent").startThrobbing();
		
		var lightboxParams = {
			'title': mediaTitle,
			'modal': openModal,
			'carouselType': LightboxLoader.carouselType
		};

		// Load resources
		if(LightboxLoader.assetsLoaded) {
			Lightbox.makeLightbox(lightboxParams);
		} else {
			$.when(
				$.loadMustache(),
				$.getResources([$.getSassCommonURL('/extensions/wikia/Lightbox/css/Lightbox.scss')]),
				$.getResources([window.wgExtensionsPath + '/wikia/Lightbox/js/Lightbox.js'])
			).done(function() {
				LightboxLoader.assetsLoaded = true;
				Lightbox.makeLightbox(lightboxParams);
			});
		}

	},
	displayInlineVideo: function(target, targetChildImg, mediaTitle) {
		LightboxLoader.getMediaDetail({
			title: mediaTitle,
			height: targetChildImg.height(),
			width: targetChildImg.width()
		}, function(json) {
			var embedCode = json['videoEmbedCode'];
			target.hide().after(embedCode);
			var videoReference = target.next();	//retrieve DOM reference
			
			// if player script, run it
			if(json.playerScript) {
				$('body').append('<script>' + json.playerScript + '</script>');
			}
			
			// save references for inline video removal later
			LightboxLoader.inlineVideoLinks = target.add(LightboxLoader.inlineVideoLinks);
			LightboxLoader.inlineVideos = videoReference.add(LightboxLoader.inlineVideos);
		});
	},
	removeInlineVideos: function() {
		LightboxLoader.inlineVideos.remove();
		LightboxLoader.inlineVideoLinks.show();
	},
	getMediaDetail: function(mediaParams, callback) {
		var title = mediaParams['title'];
		if(LightboxLoader.cache.details[title]) {
			callback(LightboxLoader.cache.details[title]);
		} else {
			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'getMediaDetail',
				type: 'POST',	/* TODO (hyun) - might change to get */
				format: 'json',
				data: mediaParams,
				callback: function(json) {
					LightboxLoader.normalizeMediaDetail(json, function(json) {
						LightboxLoader.cache.details[title] = json;
						callback(json);
					});
				}
			});
		}
	},
	/* function to normalize backend deficiencies */
	normalizeMediaDetail: function(json, callback) {
		/* normalize JWPlayer instances */
		var embedCode = json['videoEmbedCode'];
		
		/* embedCode can be a json object, not a html.  It is implied that only JWPlayer (Screenplay) items do this. */
		if(typeof embedCode === 'object') {
			var playerJson = embedCode;	// renaming to keep my sanity
			$.getScript(json['playerAsset'], function() {
				json['videoEmbedCode'] = '<div id="' + playerJson['id'] + '"></div>';	//$("<div>").attr("id", playerJson['id']);
				json['playerScript'] = playerJson['script'] + ' loadJWPlayer();';
				callback(json);
			});	
		} else {
			callback(json);
		}
	}
};

$(function() {
	LightboxLoader.init();
	var fileTitle = $.getUrlVar('file');
	if(fileTitle) {
		var file = $('#WikiaArticle .image[data-image-name="' + fileTitle + '"]');
		if (file.exists()) {
			var localWindow = $(window);
			localWindow.scrollTop(file.offset().top + file.height()/2 - localWindow.height()/2);
			file.find('img').click();
		} else {
			LightboxLoader.carouselType = 'articleMedia';
			LightboxLoader.loadLightbox(fileTitle);
		}
	}

});