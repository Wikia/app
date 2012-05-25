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
		details: {}, // all media details
		share: {}
	},
	eventTimers: {
		lastMouseUpdated: 0
	},
	current: {
		type: '', // image or video
		title: '', // currently displayed file name
		carouselType: '', // articleMedia, relatedVideos, or latestPhotos
		index: -1 // ex: Lightbox.cache[Lightbox.current.carouselType][Lightbox.current.index]		
	},
	modal: {
		defaults: {
			videoHeight: 360,
			topOffset: 25,
			height: 628
		},
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
	openModal: false, // gets replaced with dom object of open modal
	templates: {},
	init: function() {
		var article;

		if (!window.wgEnableLightboxExt) {
			Lightbox.log('Lightbox disabled');
			return;
		}

		article = $('#WikiaArticle, .LatestPhotosModule, #article-comments, #RelatedVideosRL');

		Lightbox.log('Lightbox init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(e) {
                Lightbox.handleClick(e, $(this));
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
		if(Lightbox.assetsLoaded) {
			Lightbox.makeLightbox();
		} else {
			$.when(
				$.loadMustache(),
				$.getResources([$.getSassCommonURL('/extensions/wikia/Lightbox/css/Lightbox.scss')])
			).done(Lightbox.makeLightbox);
		}

	},
	makeLightbox: function() {
		Lightbox.assetsLoaded = true;
		$.nirvana.sendRequest({
			controller:	'Lightbox',
			method:		'lightboxModalContent',
			type:		'GET',
			format: 'html',
			data: {
				mediaTitle: Lightbox.current.title,
				carouselType: Lightbox.current.carouselType,
				articleTitle: wgTitle,
				articleId: wgArticleId,
				cb: Lightbox.getCacheId() /* not really required, just for caching */
			},
			callback: function(html) {
				// restore inline videos to default state, because flash players overlaps with modal
				Lightbox.removeInlineVideos();

				// Add template to modal
				Lightbox.openModal.find(".modalContent").html(html); // adds initialFileDetail js to DOM
				
				Lightbox.openModal.WikiaLightbox = Lightbox.openModal.find('.WikiaLightbox');
				
				Lightbox.cache[Lightbox.current.carouselType] = Lightbox.mediaThumbs.thumbs;
				
				
				// Set up carousel
				var carouselTemplate = $('#LightboxCarouselTemplate');	// TODO: template cache
				var moreInfoTemplate = $('#LightboxMoreInfoTemplate');	// TODO: template cache
				var shareTemplate = $('#LightboxShareTemplate');	// TODO: template cache
				
				for(var i = 0; i < Lightbox.mediaThumbs.thumbs.length; i++) {
					if(Lightbox.mediaThumbs.thumbs[i].title == Lightbox.current.title) {
						Lightbox.current.index = i;
						break;
					}
				}
				
				var carousel = $(carouselTemplate).mustache({
					thumbs: Lightbox.mediaThumbs.thumbs,
					progress: "1-6 of 24" // TODO: calculate progress and i18n "of"
				});
				
				// pre-cache known doms
				Lightbox.openModal.carousel = $('#LightboxCarousel');
				Lightbox.openModal.header = Lightbox.openModal.find('.LightboxHeader');
				Lightbox.openModal.lightbox = Lightbox.openModal.find('.WikiaLightbox');
				Lightbox.openModal.moreInfo = Lightbox.openModal.find('.more-info');
				Lightbox.openModal.share = Lightbox.openModal.find('.share');
				Lightbox.openModal.media = Lightbox.openModal.find('.media');
				Lightbox.openModal.arrows = Lightbox.openModal.find('.lightbox-arrows');
				Lightbox.openModal.closeButton = Lightbox.openModal.find('.close');
				Lightbox.current.type = Lightbox.initialFileDetail.mediaType;
				
				Lightbox.openModal.carousel.append(carousel);
				Lightbox.openModal.data('overlayactive', true);
				
				Lightbox.setUpCarousel();
				
				var updateCallback = function(json) {
					Lightbox.cache.details[Lightbox.current.title] = json;
					Lightbox[Lightbox.current.type].updateLightbox(json);
					Lightbox.showOverlay();
					Lightbox.hideOverlay(3000);
					
					Lightbox.lightboxLoading = false;
					Lightbox.log("Lightbox modal loaded");
					/* lightbox loading ends here */
				};

				// Update modal with main image/video content								
				if(Lightbox.current.type == 'image') {
					updateCallback(Lightbox.initialFileDetail);
				} else {
					// normalize for jwplayer
					Lightbox.normalizeMediaDetail(Lightbox.initialFileDetail, updateCallback);
				}
				
				// attach event handlers
				Lightbox.openModal.on('mousemove.Lightbox', function(evt) {
					var target = $(evt.target);
					Lightbox.showOverlay();
					if(!(target.closest('.arrow, .LightboxHeader, .LightboxCarousel')).exists()) {
						Lightbox.hideOverlay();
					}
				// Hide Lightbox header and footer on mouse leave. 
				}).on('mouseleave.Lightbox', function(evt) {
					Lightbox.hideOverlay();
				// Show more info screen on button click
				}).on('click.Lightbox', '.LightboxHeader .more-info-button', function(evt) {
					if(Lightbox.current.type === 'video') {
						Lightbox.video.destroyVideo();
					}
					Lightbox.openModal.addClass('more-info-mode');
					Lightbox.getMediaDetail({title: Lightbox.current.title}, function(json) {
						Lightbox.openModal.moreInfo.append(moreInfoTemplate.mustache(json));
					});
				// Show share screen on button click
				}).on('click.Lightbox', '.LightboxHeader .share-button', function(evt) {
					if(Lightbox.current.type === 'video') {
						Lightbox.video.destroyVideo();
					}
					Lightbox.openModal.addClass('share-mode');
					Lightbox.getShareCodes({fileTitle: Lightbox.current.title, articleTitle:wgTitle}, function(json) {
						Lightbox.openModal.share.append(shareTemplate.mustache(json))
							.find('input[type=text]').click(function() {
								$(this).select();
							})
							.filter('.share-input')
							.click();
						Lightbox.openModal.share.shareUrl = json.shareUrl; // cache shareUrl for email share
						Lightbox.setupShareEmail();
					});
				// Close more info and share screens on button click
				}).on('click.Lightbox', '.more-info-close', function(evt) {
					if(Lightbox.current.type === 'video') {
						Lightbox.getMediaDetail({'title': Lightbox.current.title}, Lightbox.video.renderVideo);
					}
					Lightbox.openModal.removeClass('share-mode').removeClass('more-info-mode');
					Lightbox.openModal.share.html('');
					Lightbox.openModal.moreInfo.html('');
				// Pin the toolbar on icon click
				}).on('click.Lightbox', '.LightboxCarousel .toolbar .pin', function(evt) {
					var target = $(evt.target);
					var overlayActive = Lightbox.openModal.data('overlayactive');
					if(overlayActive) {
						target.addClass('active');	// add active state to button when carousel overlay is active
						Lightbox.openModal.addClass('pinned-mode');
					} else {
						target.removeClass('active');
						Lightbox.openModal.removeClass('pinned-mode');
					}
					Lightbox.openModal.data('overlayactive', !overlayActive);	// flip overlayactive state
					
					// update image if image
					if(Lightbox.current.type == 'image') {
						Lightbox.updateMedia();
					}
				}).on('click', '#LightboxNext, #LightboxPrevious', function(e) {
					var target = $(e.target);
					
					if(target.is('.disabled')) {
						return false;
					}
					
					if(target.is("#LightboxNext")) {
						Lightbox.current.index++;
					} else {
						Lightbox.current.index--;
					}
					
					Lightbox.openModal.find('.carousel li').eq(Lightbox.current.index).trigger('click');
				});
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
				
				// extract mustache templates
				var photoTemplate = Lightbox.openModal.find("#LightboxPhotoTemplate");
				
				// render media
				data.imageHeight = dimensions.imageHeight;
								
				var renderedResult = photoTemplate.mustache(data);
				
				// Hack to vertically align the image in the lightbox
				Lightbox.openModal.media
					.removeClass('video-media')
					.css({
						'margin-top': '',
						'line-height': dimensions.imageContainerHeight+'px'
					}).html(renderedResult);
				
				Lightbox.updateArrows();
				
				Lightbox.renderHeader();
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
					modalHeight = modalHeight < modalMinHeight ? modalMinHeight : modalHeight,
					currentModalHeight = Lightbox.openModal.height();

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
					// If currentModalHeight is greater than calculated modalHeight, adjust the top offset
					topOffset = currentModalHeight > modalHeight ? topOffset - 5 : topOffset;
				}
				
				topOffset = topOffset + $(window).scrollTop();
				
				var imageContainerHeight = modalHeight;
				if(Lightbox.openModal.hasClass('pinned-mode')) {
					imageContainerHeight -= 220;
					if(imageHeight > (modalHeight - 220) ) {
						imageHeight -= 220;
					}
				}
				
				var dimensions = {
					modalHeight: modalHeight,
					topOffset: topOffset,
					imageHeight: imageHeight,
					imageContainerHeight: imageContainerHeight
				}
				
				// remove preloader image
				$(this).remove();
				
				callback(dimensions);
			});
		}
	},
	video: {
		renderVideo: function(data) {
			// extract mustache templates
			var videoTemplate = Lightbox.openModal.find("#LightboxVideoTemplate");	//TODO: cache template
	
			// render mustache template		
			var renderedResult = videoTemplate.mustache(data);
			
			Lightbox.openModal.media
				.addClass('video-media')
				.html(renderedResult);
		},
		destroyVideo: function() {
			Lightbox.openModal.media.html('');
		},
		updateLightbox: function(data) {
			// Get lightbox dimensions
			var dimensions = Lightbox.video.getDimensions();
			
			// Resize modal
			Lightbox.openModal.css({
				top: dimensions.topOffset,
				height: dimensions.modalHeight
			});
	
			Lightbox.video.renderVideo(data);
			// Hack to vertically align video
			Lightbox.openModal.media.css({
				'margin-top': dimensions.videoTopMargin,
				'line-height': 'auto'
			});
			
			Lightbox.updateArrows();
			
			// if player script exists, run it
			if(data.playerScript) {
				$('body').append('<script>' + data.playerScript + '</script>');
			}
			
			Lightbox.renderHeader();
		},
		getDimensions: function() {
			// TODO: if the lightbox is already as big as the window, don't shrink it. 
			// if window is larger than min modal height, update modal height
			var topOffset = Lightbox.modal.defaults.topOffset,
				modalMinHeight = Lightbox.modal.defaults.height,
				windowHeight = $(window).height(),
				currentModalHeight = Lightbox.openModal.height(),
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
			Lightbox.openModal.header
				.html(renderedResult)
				.prepend($(Lightbox.openModal.closeButton).clone(true, true));	// clone close button into header
		});
	},
	showOverlay: function() {
		clearTimeout(Lightbox.eventTimers.overlay);
		Lightbox.eventTimers.overlay = 0;
		var overlay = Lightbox.openModal;
		if(overlay.hasClass('overlay-hidden') && overlay.data('overlayactive')) {
			overlay.removeClass('overlay-hidden');
		}
	},
	hideOverlay: function(delay) {
		var overlay = Lightbox.openModal;
		if(!overlay.hasClass('overlay-hidden') && !Lightbox.eventTimers.overlay && overlay.data('overlayactive')) {
			Lightbox.eventTimers.overlay = setTimeout(
				function() {
					overlay.addClass('overlay-hidden');
				}, (delay || 1200)
			);
		}
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
	updateMedia: function() {
		// update image/video based on whatever the current index is now
		var carouselType = Lightbox.current.carouselType,
			mediaArr = Lightbox.cache[carouselType],
			idx = Lightbox.current.index;
		
		Lightbox.openModal.find('.media').html("").startThrobbing();
	
		if(idx > -1 && idx < mediaArr.length) {
			
			var title = Lightbox.current.title = mediaArr[idx].title;
			var type = Lightbox.current.type = mediaArr[idx].type;
			
			Lightbox.getMediaDetail({
				title: title,
				type: type
			}, function(data) {
				Lightbox[type].updateLightbox(data);		
				Lightbox.showOverlay();
				Lightbox.hideOverlay();
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
	getShareCodes: function(mediaParams, callback) {
		var title = mediaParams['title'];
		if(Lightbox.cache.share[title]) {
			callback(Lightbox.cache.share[title]);
		} else {
			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'getShareCodes',
				type: 'POST',	/* TODO (hyun) - might change to get */
				format: 'json',
				data: mediaParams,
				callback: function(json) {
					Lightbox.cache.share[title] = json;
					callback(json);
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
	},
	setUpCarousel: function() {
		var itemClick = function(e) {
			var idx = $(this).index();

			Lightbox.current.index = idx;
			
			Lightbox.updateMedia();	
		}
		
		var trackProgressCallback = function(idx1, idx2, total) {
			var template = $('#LightboxCarouselProgressTemplate');
			
			var html = template.mustache({
				idx1: idx1,
				idx2: idx2,
				total: total
			});
			
			$('#LightboxCarouselProgress').html(html);
		}
		
		var beforeMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').hide();
		}
		
		var afterMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').show();
		}

		$('#LightboxCarouselContainer').carousel({
			itemsShown: 6,
			itemSpacing: 8,
			transitionSpeed: 1000,
			itemClick: itemClick,
			activeIndex: Lightbox.current.index,
			trackProgress: trackProgressCallback,
			beforeMove: beforeMove,
			afterMove: afterMove
		});
	},

	getCacheId: function() {
		switch(Lightbox.current.carouselType) {
			case "articleMedia":
				return wgCurRevisionId;
				break;
			case "relatedVideo":
				var cacheId = 0;
				$('.RelatedVideos a.video-thumbnail').each( function() {
					cacheId = $.md5(cacheId + $(this).attr('data-video-name'));
				});
				return cacheId;
				break;
			case "latestPhotos":
				var cacheId = 0;
				$('.LatestPhotosModule a.image').each( function() {
					cacheId = $.md5(cacheId + $(this).attr('data-ref'));
				});
				return cacheId;
				break;
			default: // fallback, should not happen
				return wgCurRevisionId;
		}
	},
	
	setupShareEmail: function() {
		var shareEmailForm = $('#shareEmailForm'),
			wikiaForm = new WikiaForm(shareEmailForm);
		
		function doShareEmail(addresses) {
			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'shareFileMail',
				type: 'POST',
				data: {
					addresses: addresses,
					shareUrl: Lightbox.openModal.share.shareUrl
				}, 
				callback: function(data) {
					// TODO: i18n
					var msg = "";

					if(data.errors.length) {
						$(data.errors).each(function() {
							msg += this;
						})
					}
					if(data.notsent.length) {
						msg += "Email not sent to " + data.notsent.join() + ". ";
					}
					if(data.sent.length) {
						msg += "Email sent to " + data.sent.join() + ". ";
					}
					
					if(!msg.length) {
						msg = "There was an unknown error.  Please try again later."
					}
					
					wikiaForm.showGenericError(msg);					
				}
			});
		}

		shareEmailForm.submit(function(e) {
			e.preventDefault();
			var addresses = $(this).find('input').first().val();

			// make sure user is logged in
			if(wgUserName) {
				doShareEmail(addresses);
			} else {
				UserLoginModal.show({
					callback: function() {
						doShareEmail(addresses);
					}
				});
			}
		});
	}
};

$(function() {
	Lightbox.init();
	var fileTitle = $.getUrlVar('file');
	if(fileTitle) {
		var file = $('#WikiaArticle .image[data-image-name="' + fileTitle + '"]');
		if (file.exists()) {
			var localWindow = $(window);
			localWindow.scrollTop(file.offset().top + file.height()/2 - localWindow.height()/2);
			file.find('img').click();
		} else {
			Lightbox.current.title = fileTitle;
			Lightbox.loadLightbox();
		}
	}

});

