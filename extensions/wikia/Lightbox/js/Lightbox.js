var Lightbox = {
	lightboxLoading: false,
	videoThumbWidthThreshold: 320,
	inlineVideos: $(),	// jquery array of inline videos
	inlineVideoLinks: $(),	// jquery array of inline video links
	log: function(content) {
		$().log(content, "Lightbox");
	},
	// cached thumbnail arrays and detailed info 
	cache:{
		articleMedia: [], // Article Media
		relatedVideos: [], // Related Video
		latestPhotos: [], // Lates Photos
		details: {} // all media details
	},
	current: {
		type: '', // image or video
		title: '', // currently displayed file name
		carouselType: '', // articleMedia, relatedVideos, or latestPhotos
		index: -1 // ex: Lightbox.cache[Lightbox.current.carouselType][index]		
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
		var article;

		if (!window.wgEnableLightboxExt) {
			Lightbox.log('Lightbox disabled');
			return;
		}

		if (window.skin == 'oasis') {
			article = $('#WikiaArticle, .LatestPhotosModule, #article-comments, #RelatedVideosRL');
		}
		else {
			article = $('#bodyContent');
		}

		Lightbox.log('Lightbox init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(e) {
                Lightbox.handleClick(e, $(this));
			});
		
		// Clicking left/right arrows inside Lightbox
		$('body').on('click', '#LightboxNext, #LightboxPrevious', function(e) {
			Lightbox.handleArrows(e);
		});

	},
	handleClick: function(ev, parent) {
		var id = parent.attr('id');

		// Set carousel type based on parent of image
		switch(id) {
			case "WikiaArticle": 
				Lightbox.current.carouselType = "articleMedia";
				break;
			case "article-comments":
				Lightbox.current.carouselType = "articleMedia";
				break;
			case "RelatedVideosRL":
				Lightbox.current.carouselType = "relatedVideo";
				break;
			default: // .LatestPhotosModule
				Lightbox.current.carouselType = "latestPhotos";
		}
		
		// figure out target
		if(Lightbox.lightboxLoading) {
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
		Lightbox.target = target;

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
			Lightbox.current.type = 'video';
			
			if ( target.data('video-name') ) {
				mediaTitle = target.data('video-name');
			} else if ( targetChildImg.data('video') ) {
				mediaTitle = targetChildImg.data('video');
			}
			
			// check if we need to play video inline, and stop lightbox execution
			if (mediaTitle && targetChildImg.width() >= Lightbox.videoThumbWidthThreshold) {
				Lightbox.displayInlineVideo(target, targetChildImg, mediaTitle);
				ev.preventDefault();
				return false;	// stop modal dialog execution
			}
		} else {
			Lightbox.current.type = 'image';
		}
		

		// load modal
		if(mediaTitle != false) {
			Lightbox.current.title = mediaTitle;
			Lightbox.loadLightbox();
		}
	},
	loadLightbox: function() {
		Lightbox.lightboxLoading = true;

		// Display modal with default dimensions
		Lightbox.openModal = $("<div>").makeModal(Lightbox.modal.initial);
		Lightbox.openModal.find(".modalContent").startThrobbing();

		// Load resources
		$.when(
			$.loadMustache(),
			$.getResources([$.getSassCommonURL('/extensions/wikia/Lightbox/css/Lightbox.scss')])
		).done(Lightbox.makeLightbox);

	},
	makeLightbox: function() {
		$.nirvana.sendRequest({
			controller: 'Lightbox',
			method: 'lightboxModalContent',
			type: 'POST',	/* TODO (hyun) - might change to get */
			format: 'html',
			data: {
				title: Lightbox.current.title
			},
			callback: function(html) {
				// restore inline videos to default state, because flash players overlaps with modal
				Lightbox.removeInlineVideos();

				// Add template to modal
				Lightbox.openModal.find(".modalContent").html(html); // adds initialFileDetail js to DOM
				
				Lightbox.current.carouselType = "articleMedia"; // TODO: get this from back end
				Lightbox.cache.articleMedia = mediaThumbs.thumbs;
				
				for(var i = 0; i < mediaThumbs.thumbs.length; i++) {
					if(mediaThumbs.thumbs[i].title == Lightbox.current.title) {
						Lightbox.current.index = i;
						break;
					}
				}
				
				// pre-cache known doms
				Lightbox.openModal.header = Lightbox.openModal.find('header');
				
				var updateCallback = function(json) {
					Lightbox.cache.details[Lightbox.current.title] = json;
					Lightbox[Lightbox.current.type].updateLightbox(json);
				};
				if(Lightbox.current.type == 'image') {
					updateCallback(initialFileDetail);
				} else {
					// normalize for jwplayer
					Lightbox.normalizeMediaDetail(initialFileDetail, updateCallback);
				}
			}
		});
	},
	image: {
		updateLightbox: function(data) {
			Lightbox.image.getDimensions(data.imageUrl, function(dimensions) {
				
				Lightbox.openModal.css({
					top: dimensions.topOffset,
					height: dimensions.modalHeight
				});

				var contentArea = Lightbox.openModal.find(".WikiaLightbox");
				
				// extract mustache templates
				var photoTemplate = Lightbox.openModal.find("#LightboxPhotoTemplate");
				
				// render media
				var json = {
					imageHeight: dimensions.imageHeight,
					imageUrl: data.imageUrl
				};
								
				var renderedResult = photoTemplate.mustache(json);
	
				// Hack to vertically align the image in the lightbox
				renderedResult = $(renderedResult).css('line-height', dimensions.modalHeight+'px');
				
				var mediaDiv = contentArea.find('.media');
				if(mediaDiv.length) {
					mediaDiv.replaceWith(renderedResult);
				} else {
					renderedResult.insertBefore("#LightboxCaoursel");			
				}
				
				Lightbox.updateArrows();
				Lightbox.renderHeader();
				
				Lightbox.lightboxLoading = false;
				Lightbox.log("Lightbox modal loaded");
					
			});

			/* get media details based on title - nirvana request or from template */
			/* call getDimensions */
			/* resize modal */
			/* render mustache template */		
		},
		getDimensions: function(imageUrl, callback) {
			// Get image url from json - preload image
			// TODO: cache image dimensions so we don't have to preload the image again
			var image = $('<img id="LightboxPreload" src="'+imageUrl+'" />').appendTo('body');
			
			// Do calculations
			image.load(function() {
				var image = $(this),
					topOffset = Lightbox.modal.defaults.topOffset,
					modalMinHeight = Lightbox.modal.defaults.height,
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
		updateLightbox: function(data) {
			// Get lightbox dimensions
			var dimensions = Lightbox.video.getDimensions();
			
			// Resize modal
			Lightbox.openModal.css({
				top: dimensions.topOffset,
				height: dimensions.modalHeight
			});
			
			var contentArea = Lightbox.openModal.find(".WikiaLightbox");
	
			// extract mustache templates
			var videoTemplate = Lightbox.openModal.find("#LightboxVideoTemplate");
	
			// render media
			var json = {
				embed: data.videoEmbedCode // initialFileDetail defined in modal template
			}
			
			// render mustache template		
			var renderedResult = videoTemplate.mustache(json);
			
			// Hack to vertically align video
			renderedResult = $(renderedResult).css('margin-top', dimensions.videoTopMargin);
	
			var mediaDiv = contentArea.find('.media');
			if(mediaDiv.length) {
				mediaDiv.replaceWith(renderedResult);
			} else {
				renderedResult.insertBefore("#LightboxCaoursel");			
			}
			
			Lightbox.updateArrows();
			
			// if player script exists, run it
			if(data.playerScript) {
				$('body').append('<script>' + data.playerScript + '</script>');
			}
			
			Lightbox.log("Lightbox modal loaded");
			Lightbox.lightboxLoading = false;
			
		},
		getDimensions: function() {
			// if window is larger than min modal height, update modal height
			var topOffset = Lightbox.modal.defaults.topOffset,
				modalMinHeight = Lightbox.modal.defaults.height,
				windowHeight = $(window).height(),
				modalHeight = windowHeight - topOffset*2 - 10, // 5px modal border
				modalHeight = modalHeight < modalMinHeight ? modalMinHeight : modalHeight,
				videoTopMargin = (modalHeight - Lightbox.modal.defaults.videoHeight) / 2;
			
				topOffset = topOffset + $(window).scrollTop();

				var dimensions = {
					modalHeight: modalHeight,
					topOffset: topOffset,
					videoTopMargin: videoTopMargin
				}
				
				return dimensions;
		}	
	},
	renderHeader: function() {
		var headerTemplate = Lightbox.openModal.find("#LightboxHeaderTemplate");	//TODO: replace with cache
		Lightbox.getMediaDetail({title: Lightbox.current.title}, function(json) {
			var renderedResult = headerTemplate.mustache(json)
			Lightbox.openModal.header.html(renderedResult).removeClass('hidden');
			Lightbox.eventHooks.header = setTimeout(
				function() {
					Lightbox.openModal.header.addClass('hidden');
				}, 3000
			);
		});
	},
	displayInlineVideo: function(target, targetChildImg, mediaTitle) {
		Lightbox.getMediaDetail({
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
			Lightbox.inlineVideoLinks = target.add(Lightbox.inlineVideoLinks);
			Lightbox.inlineVideos = videoReference.add(Lightbox.inlineVideos);
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
	handleArrows: function(e) {
		var target = $(e.target);
		
		if(target.is('.disabled')) {
			return false;
		}
		
		var carouselType = Lightbox.current.carouselType,
			mediaArr = Lightbox.cache[carouselType],
			idx = Lightbox.current.index;
		
		Lightbox.openModal.find('.media').html("").startThrobbing();
	
		if(target.is("#LightboxNext")) {
			idx++;
		} else {
			idx--;
		}
		
		if(idx > -1 && idx < mediaArr.length) {
			Lightbox.current.index = idx;
			
			var title = Lightbox.current.title = mediaArr[idx].title;
			var type = Lightbox.current.type = mediaArr[idx].type;
			
			Lightbox.getMediaDetail({
				title: Lightbox.current.title,
				type: type
			}, function(data) {
				Lightbox[type].updateLightbox(data);		
			});			
		}
	},
	updateArrows: function() {		
		var carouselType = Lightbox.current.carouselType,
			mediaArr = Lightbox.cache[carouselType],
			idx = Lightbox.current.index;
			
		var next = $('#LightboxNext'),
			previous = $('#LightboxPrevious');
			
		if(idx == (mediaArr.length - 1)) {
			next.addClass('disabled');
			previous.removeClass('disabled');
		} else if(idx == 0) {
			previous.addClass('disabled');
			next.removeClass('disabled');
		} else {
			previous.removeClass('disabled');
			next.removeClass('disabled');
		}
	},
	getMediaDetail: function(mediaParams, callback) {
		var title = mediaParams['title'];
		if(Lightbox.cache.details[title]) {
			callback(Lightbox.cache.details[title]);
		} else {
			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'getMediaDetail',
				type: 'POST',	/* TODO (hyun) - might change to get */
				format: 'json',
				data: mediaParams,
				callback: function(json) {
					Lightbox.normalizeMediaDetail(json, function(json) {
						Lightbox.cache.details[title] = json;
						callback(json);
					});
				}
			});
		}
	},
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
	Lightbox.init();
});