/*global LightboxLoader:true*/

var Lightbox = {
	log: function(content) {
		$().log(content, "Lightbox");
	},
	eventTimers: {
		lastMouseUpdated: 0
	},
	current: {
		type: '', // image or video
		title: '', // currently displayed file name
		carouselType: '', // articleMedia, relatedVideos, or latestPhotos
		index: -1, // ex: LightboxLoader.cache[Lightbox.current.carouselType][Lightbox.current.index]
		thumbs: [], // master list of thumbnails inside carousel; purged after closing the lightbox
		placeholderIdx: -1
	},
	// Modal vars
	openModal: false, // gets replaced with dom object of open modal
	shortScreen: false, // flag if the screen is shorter than LightboxLoader.defaults.height
	
	// Carousel vars
	thumbPlayButton: '<span class="Wikia-video-play-button min" style="width: 90px; height: 55px;"></span>', // overlay for thumb images
	thumbLoadCount: 20, // Number of thumbs to load at a time.  Must be at least 9 (i.e. number of items in carousel)
	backfillCount: 0,
	backfillCountMessage: false,
	to: 0, // timestamp for getting wiki images
	includeLatestPhotos: !$('#LatestPhotosModule').length, // if we don't have latest photos in the DOM, request them from back end
	
	dom: {
		relatedVideos: $('#RelatedVideosRL').find('.Wikia-video-thumb')
	},
	
	makeLightbox: function(params) {	
		Lightbox.openModal = params.modal;
		Lightbox.current.title = params.title.toString(); // Added toString() for edge cases where titles are numbers
		
		var id = params.parent ? params.parent.attr('id') : '';

		// Set carousel type based on parent of image
		switch(id) {
			case "WikiaArticle": 
				Lightbox.current.carouselType = "articleMedia";
				Lightbox.trackingCarouselType = "article";
				break;
			case "article-comments":
				Lightbox.current.carouselType = "articleMedia";
				Lightbox.trackingCarouselType = "article";
				break;
			case "RelatedVideosRL":
				Lightbox.current.carouselType = "relatedVideos";
				Lightbox.trackingCarouselType = "related-videos";
				break;
			default: // .LatestPhotosModule
				Lightbox.current.carouselType = "latestPhotos";
				Lightbox.trackingCarouselType = "latest-photos";
		}
		
		// Check screen height for future interactions
		Lightbox.shortScreen = $(window).height() < LightboxLoader.defaults.height + LightboxLoader.defaults.topOffset ? true : false;
		
		// Add template to modal
		Lightbox.openModal.find(".modalContent").html(LightboxLoader.templateHtml);
		
		if(!Lightbox.initialFileDetail['exists']) {
			// We're showing an error template
			Lightbox.handleErrorTemplate();
			return;
		}
		
		// Template cache
		Lightbox.openModal.moreInfoTemplate = $('#LightboxMoreInfoTemplate');
		Lightbox.openModal.shareTemplate = $('#LightboxShareTemplate');
		Lightbox.openModal.progressTemplate = $('#LightboxCarouselProgressTemplate');
		Lightbox.openModal.videoTemplate = $("#LightboxVideoTemplate");
		Lightbox.openModal.headerTemplate = $("#LightboxHeaderTemplate");
		Lightbox.openModal.headerAdTemplate = $("#LightboxHeaderAdTemplate");
		
		// pre-cache known doms
		Lightbox.openModal.carousel = $('#LightboxCarouselContainer .carousel');
		Lightbox.openModal.header = Lightbox.openModal.find('.LightboxHeader');
		Lightbox.openModal.lightbox = Lightbox.openModal.find('.WikiaLightbox');
		Lightbox.openModal.moreInfo = Lightbox.openModal.find('.more-info');
		Lightbox.openModal.share = Lightbox.openModal.find('.share');
		Lightbox.openModal.media = Lightbox.openModal.find('.media');
		Lightbox.openModal.arrows = Lightbox.openModal.find('.lightbox-arrows');
		Lightbox.openModal.closeButton = Lightbox.openModal.find('.close');
		Lightbox.current.type = Lightbox.initialFileDetail.mediaType;
		
		// Set up carousel
		Lightbox.setUpCarousel();
		
		// Set up tracking
		Lightbox.openModal.aggregateViewCount = 0;
		
		// callback to finish lighbox loading
		var updateCallback = function(json) {
			LightboxLoader.cache.details[Lightbox.current.title] = json;
			Lightbox.updateMedia();
			Lightbox.showOverlay();
			Lightbox.hideOverlay(3000);

			LightboxLoader.lightboxLoading = false;
			Lightbox.log("Lightbox modal loaded");
			/* lightbox loading ends here */ // TODO: this comment might not be accurate now due to asynchronus backfill content loading - liz
			
			/* tracking after lightbox has fully loaded */
			var trackingTitle = Lightbox.getTitleForTracking();
			LightboxLoader.track(WikiaTracker.ACTIONS.IMPRESSION, '', Lightbox.current.placeholderIdx, {title: trackingTitle, 'carousel-type': Lightbox.trackingCarouselType});
		};

		// Update modal with main image/video content								
		if(Lightbox.current.type == 'image') {
			updateCallback(Lightbox.initialFileDetail);
		} else {
			// normalize for jwplayer
			LightboxLoader.normalizeMediaDetail(Lightbox.initialFileDetail, updateCallback);
		}
		
		// attach event handlers
		Lightbox.openModal.on('mousemove.Lightbox', function(evt) {
			var time = new Date().getTime();
			if ( ( time - Lightbox.eventTimers.lastMouseUpdated ) > 100 ) { 
				Lightbox.eventTimers.lastMouseUpdated = time; 
				var target = $(evt.target);
				Lightbox.showOverlay();
				if(!(target.closest('.LightboxHeader, .LightboxCarousel')).exists()) {
					Lightbox.hideOverlay();
				}
			}
		// Hide Lightbox header and footer on mouse leave. 
		}).on('mouseleave.Lightbox', function(evt) {
			Lightbox.hideOverlay(10);
		// Show more info screen on button click
		}).on('click.Lightbox', '.LightboxHeader .more-info-button', function(evt) {
			if(Lightbox.current.type === 'video') {
				Lightbox.video.destroyVideo();
			}
			Lightbox.openModal.addClass('more-info-mode');
			LightboxLoader.getMediaDetail({fileTitle: Lightbox.current.title}, function(json) {
				Lightbox.openModal.moreInfo.append(Lightbox.openModal.moreInfoTemplate.mustache(json));
			});
		// Show share screen on button click
		}).on('click.Lightbox', '.LightboxHeader .share-button', function(evt) {
			if(Lightbox.current.type === 'video') {
				Lightbox.video.destroyVideo();
			}
			Lightbox.openModal.addClass('share-mode');
			Lightbox.getShareCodes({fileTitle: Lightbox.current.title, articleTitle:wgTitle}, function(json) {
				Lightbox.openModal.share.append(Lightbox.openModal.shareTemplate.mustache(json))
					.find('input[type=text]').click(function() {
						$(this).select();
					})
					.filter('.share-input')
					.click();
				
				var trackingTitle = Lightbox.getTitleForTracking();
				LightboxLoader.track(WikiaTracker.ACTIONS.CLICK, null, null, {title: trackingTitle, type: Lightbox.current.type});
				
				Lightbox.openModal.share.shareUrl = json.shareUrl; // cache shareUrl for email share
				Lightbox.setupShareEmail();
				
				Lightbox.openModal.share.find('.social-links').on('click', 'a', function() {
					var shareType = $(this).attr('class');
					LightboxLoader.track(WikiaTracker.ACTIONS.SHARE, shareType, null, {title: trackingTitle, type: Lightbox.current.type});
				});

			});
		// Close more info and share screens on button click
		}).on('click.Lightbox', '.more-info-close', function(evt) {
			if(Lightbox.current.type === 'video') {
				LightboxLoader.getMediaDetail({fileTitle: Lightbox.current.title}, Lightbox.video.renderVideo);
			}
			Lightbox.openModal.removeClass('share-mode').removeClass('more-info-mode');
			Lightbox.openModal.share.html('');
			Lightbox.openModal.moreInfo.html('');
		// Pin the toolbar on icon click
		}).on('click.Lightbox', '.LightboxCarousel .toolbar .pin', function(evt) {
			var target = $(evt.target);
			var overlayActive = Lightbox.openModal.data('overlayactive');
			if(overlayActive) {
				var pinnedTitle = target.data('pinned-title');
				target.addClass('active').attr('title', pinnedTitle);	// add active state to button when carousel overlay is active
				Lightbox.openModal.addClass('pinned-mode');
			} else {
				var pinTitle = target.data('pin-title');
				target.removeClass('active').attr('title', pinTitle);
				Lightbox.openModal.removeClass('pinned-mode');
			}
			Lightbox.openModal.data('overlayactive', !overlayActive);	// flip overlayactive state
			
			// update image if image
			if(Lightbox.current.type == 'image') {
				Lightbox.updateMedia();
			}
		}).on('click.Lightbox', '#LightboxNext, #LightboxPrevious', function(e) {
			var target = $(e.target);
			
			if(target.is('.disabled')) {
				return false;
			}

			// If an ad is showing, we want to show the current index, not move on
			if(Lightbox.ads.adIsShowing) { 
				Lightbox.ads.reset();
			} else {
				if(target.is("#LightboxNext")) {
					Lightbox.current.index++;
					// Don't stop on placeholder
					if(Lightbox.current.index == Lightbox.current.placeholderIdx) {
						Lightbox.current.index++;
					}
				} else {
					Lightbox.current.index--;
					// Don't stop on placeholder
					if(Lightbox.current.index == Lightbox.current.placeholderIdx) {
						Lightbox.current.index--;
					}
				}						
			}

			Lightbox.openModal.find('.carousel li').eq(Lightbox.current.index).trigger('click');
		});
	},
	clearTrackingTimeouts: function() {
		// Clear video tracking timeout
		clearTimeout(Lightbox.video.trackingTimeout);
		// Clear image tracking 
		clearTimeout(Lightbox.image.trackingTimeout);	
	},
	image: {
		trackingTimeout: false,
		updateLightbox: function(data) {
			Lightbox.image.getDimensions(data.imageUrl, function(dimensions) {

				var css = {height: dimensions.modalHeight};
				
				// don't change top offset if the screen is shorter than the min modal height
				if(!Lightbox.shortScreen) {
					css['top'] = dimensions.topOffset;
				}
				
				Lightbox.openModal.css(css);
				
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
						'line-height': (dimensions.imageContainerHeight - 3) + 'px' // -3 hack to remove white line in chrome
					}).html(renderedResult);

				$(window).trigger('resize'); // firefox image loading hack (BugId:32477)

				Lightbox.updateArrows();

				Lightbox.renderHeader();

				Lightbox.updateMediaType();

				Lightbox.openModal.aggregateViewCount++;
				
				Lightbox.clearTrackingTimeouts();

				var trackingTitle = Lightbox.getTitleForTracking(); // prevent race conditions from timeout
				Lightbox.image.trackingTimeout = setTimeout(function() {
					LightboxLoader.track(WikiaTracker.ACTIONS.VIEW, 'image', Lightbox.openModal.aggregateViewCount, {title: trackingTitle});			
				}, 500);
	
			});

		},
		getDimensions: function(imageUrl, callback) {
			// Get image url from json - preload image
			// TODO: cache image dimensions so we don't have to preload the image again
			var image = $('<img id="LightboxPreload" src="'+imageUrl+'" />').appendTo('body');
			
			// Do calculations
			image.load(function() {
				var image = $(this),
					topOffset = LightboxLoader.defaults.topOffset,
					modalMinHeight = LightboxLoader.defaults.height,
					windowHeight = $(window).height(),
					modalHeight = windowHeight - topOffset*2,  
					currentModalHeight = Lightbox.openModal.height();

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
					
					var newOffset = (extraHeight / 2);
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
					imageContainerHeight -= 190;
					if(imageHeight > imageContainerHeight ) {
						imageHeight = imageContainerHeight;
					}
				}
				
				var dimensions = {
					modalHeight: modalHeight,
					topOffset: topOffset,
					imageHeight: imageHeight,
					imageContainerHeight: imageContainerHeight
				};

				// remove preloader image
				image.remove();
				
				callback(dimensions);
			});
		}
	},
	video: {
		trackingTimeout: false,
		renderVideo: function(data) {
			// render mustache template		
			var renderedResult = Lightbox.openModal.videoTemplate.mustache(data);
			
			Lightbox.openModal.media
				.addClass('video-media')
				.html(renderedResult)
				.css('line-height','normal');

			if(data.playerScript) {
				$('body').append('<script>' + data.playerScript + '</script>');
			}

		},
		destroyVideo: function() {
			Lightbox.openModal.media.html('');
		},
		updateLightbox: function(data) {
			
			// Set lightbox css
			var css = {
				height: LightboxLoader.defaults.height
			}
			
			// don't change top offset if the screen is shorter than the min modal height
			if(!Lightbox.shortScreen) {
				css['top'] = Lightbox.getDefaultTopOffset();
			}

			// Resize modal
			Lightbox.openModal.css(css);
	
			Lightbox.video.renderVideo(data);
			
			Lightbox.updateArrows();

			Lightbox.renderHeader();

            Lightbox.updateMediaType();
			
			Lightbox.clearTrackingTimeouts();

			var trackingTitle = Lightbox.getTitleForTracking(); // prevent race conditions from timeout
			Lightbox.video.trackingTimeout = setTimeout(function() {
				Lightbox.openModal.aggregateViewCount++;
				LightboxLoader.track(WikiaTracker.ACTIONS.VIEW, 'video', Lightbox.openModal.aggregateViewCount, {title: trackingTitle, provider: data.providerName});		
			}, 1000);

		}
	},
	ads: {
		// should user see ads?
		showAds: function() {
			return $('#MODAL_INTERSTITIAL').length;
		},
		// show an ad after this number of unique images/videos are shown
		adMediaCount: 2, 
		// array of media titles shown for tracking unique views
		adMediaProgress: [], 
		 // has an ad already been shown?
		adWasShown: false,
		// are we showing an ad right now?
		adIsShowing: false, 
		
		// Determine if we should show an ad
		showAd: function(title, type) {
			// Already shown?
			if(!Lightbox.ads.showAds() || Lightbox.ads.adWasShown) {
				return false;
			}
			
			var count = Lightbox.ads.adMediaCount,
				progress = Lightbox.ads.adMediaProgress;
			
			if(progress.indexOf(title) < 0) {
				if(progress.length >= count && type != 'video') {
					Lightbox.ads.updateLightbox();
					return true;
				}
				progress.push(title);
			}
	
			// Not showing an ad. 
			return false;
		},
		// Display the ad
		updateLightbox: function() {
			Lightbox.openModal.media.html('').hide();
			
			// Show special header for ads
			Lightbox.renderAdHeader();
			
			Lightbox.openModal.progress.addClass('invisible');
			
			// Don't show active thumbnail
			Lightbox.openModal.carousel.find('.active').removeClass('active');

			// Set lightbox css
			var css = {
				height: LightboxLoader.defaults.height
			}
			
			// don't change top offset if the screen is shorter than the min modal height
			if(!Lightbox.shortScreen) {
				css['top'] = Lightbox.getDefaultTopOffset();
			}

			// Resize modal
			Lightbox.openModal.css(css);
	
			$('#MODAL_INTERSTITIAL').show();
			
			// Set flag to indicate we're showing an ad (for arrow click handler)
			Lightbox.ads.adIsShowing = true;
			
			// Ad's been shown, don't show it again. 
			Lightbox.ads.adWasShown = true;
		},
		// Remove showing ad flag
		reset: function() {
			Lightbox.ads.adIsShowing = false;
			$('#MODAL_INTERSTITIAL').hide();	
			Lightbox.openModal.media.show();
			Lightbox.openModal.progress.removeClass('invisible');
		}
	},
    updateMediaType: function() {

        if ( Lightbox.current.type == 'video' ) {
            Lightbox.openModal.addClass('video-lightbox');
            Lightbox.openModal.removeClass('image-lightbox');
        } else {
            Lightbox.openModal.removeClass('video-lightbox');
            Lightbox.openModal.addClass('image-lightbox');
        }
    },
	getDefaultTopOffset: function() {
		var modalHeight = LightboxLoader.defaults.height,
			windowHeight = $(window).height(),
			topOffset = (windowHeight - modalHeight - 10)/2;
		
		return topOffset + $(window).scrollTop();
		
	},
	renderHeader: function() {
		var headerTemplate = Lightbox.openModal.headerTemplate;
		LightboxLoader.getMediaDetail({fileTitle: Lightbox.current.title}, function(json) {
			var renderedResult = headerTemplate.mustache(json);
			Lightbox.openModal.header
				.html(renderedResult)
				.prepend($(Lightbox.openModal.closeButton).clone(true, true));	// clone close button into header
		});
	},
	// Render special Header for ads
	renderAdHeader: function() {
		var headerAdTemplate = Lightbox.openModal.headerAdTemplate.html();
		Lightbox.openModal.header
			.html(headerAdTemplate)
			.prepend($(Lightbox.openModal.closeButton).clone(true, true));	// clone close button into header
	},
	showOverlay: function() {
		clearTimeout(Lightbox.eventTimers.overlay);
		var overlay = Lightbox.openModal;
		if(overlay.hasClass('overlay-hidden') && overlay.data('overlayactive')) {
			overlay.removeClass('overlay-hidden');
		}
	},
	hideOverlay: function(delay) {
		var overlay = Lightbox.openModal;
		if(!overlay.hasClass('overlay-hidden') && overlay.data('overlayactive')) {
			clearTimeout(Lightbox.eventTimers.overlay);
			Lightbox.eventTimers.overlay = setTimeout(
				function() {
					overlay.addClass('overlay-hidden');
				}, (delay || 1200)
			);
		}
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
		Lightbox.openModal.media.html("").startThrobbing();
	
		var title = Lightbox.current.title;
		var type = Lightbox.current.type;
		
		// This is where ad UI may interrupt the flow
		if(Lightbox.ads.showAd(title, type)) {
			return;
		}
		
		LightboxLoader.getMediaDetail({
			fileTitle: title,
			type: type
		}, function(data) {
			// TODO: cache caption 
			/*var idx = Lightbox.current.index,
				caption = Lightbox.openModal.carousel.find('li').eq(idx).find('img').data('caption');
			data['caption'] = caption || false;*/
			Lightbox[type].updateLightbox(data);		
			//Lightbox.showOverlay();
			//Lightbox.hideOverlay();
		});
		
	},
	updateArrows: function() {		
		var mediaArr = Lightbox.current.thumbs,
			idx = Lightbox.current.index;
			
		var next = $('#LightboxNext'),
			previous = $('#LightboxPrevious');
			
		if(mediaArr.length < 2) {
			next.addClass('disabled');
			previous.addClass('disabled');
		} else if(idx == (mediaArr.length - 1)) {
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
	getShareCodes: function(mediaParams, callback) {
		var title = mediaParams['fileTitle'];
		if(LightboxLoader.cache.share[title]) {
			callback(LightboxLoader.cache.share[title]);
		} else {
			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'getShareCodes',
				type: 'GET',
				format: 'json',
				data: mediaParams,
				callback: function(json) {
					LightboxLoader.cache.share[title] = json;
					callback(json);
				}
			});
		}
	},
	setUpCarousel: function() {
		// cache carousel template
		Lightbox.openModal.carouselTemplate = $('#LightboxCarouselThumbs');
		Lightbox.openModal.carouselContainer = $('#LightboxCarouselContainer');
				
		// get thumbs and attach carousel
		Lightbox.getMediaThumbs[Lightbox.current.carouselType](false);

		// Set up placeholder thumb index but don't insert it till we have collected all thumbs
		Lightbox.current.placeholderIdx = Lightbox.current.thumbs.length;
		Lightbox.current.thumbs.push({});
		
		// Load backfill content from DOM
		var types = ['relatedVideos', 'articleMedia', 'latestPhotos'],
			i;
		
		for(i=0; i<types.length; i++) {
			var type = types[i];
			if(type != Lightbox.current.carouselType) {
				Lightbox.getMediaThumbs[type](true);
			}
		}
		
		// Add total wiki photos to backfill count
		var deferredList = [];
		if(Lightbox.backfillCountMessage == false) {
			var deferredInfo = $.Deferred();
			$.nirvana.sendRequest({
				controller:	'Lightbox',
				method: 	'getTotalWikiImages',
				type: 		'GET',
				format: 	'json',
				data: {
					count: Lightbox.backfillCount,
					inclusive: Lightbox.includeLatestPhotos
				},
				callback: function(json) {
					Lightbox.to = LightboxLoader.cache.to = json.to;
					Lightbox.backfillCount += json.totalWikiImages;
					Lightbox.backfillCountMessage = json.msg;
					deferredInfo.resolve();
				}
			});
			
			deferredList.push( deferredInfo );
		}

		// Set current carousel index
		var readableTitle = Lightbox.current.title.split('_').join(" ");
		for(var i = 0; i < Lightbox.current.thumbs.length; i++) {
			if(Lightbox.current.thumbs[i].title == readableTitle) {
				Lightbox.current.index = i;
				break;
			}
		}

		// Cache progress template
		Lightbox.openModal.progress = $('#LightboxCarouselProgress');
		Lightbox.openModal.data('overlayactive', true);

		$(document).off('keydown.Lightbox')
			.on('keydown.Lightbox', function(e) {
				if(e.keyCode == 37) {
					$('#LightboxPrevious').click();
				} else if(e.keyCode == 39) {
					$('#LightboxNext').click();
				}
			});
		
		// Clicking on an image should advance you to the next one
		Lightbox.openModal.media.on('click', 'img', function() {
			var next = $('#LightboxNext');
			if(next.hasClass('disabled')) {
				Lightbox.openModal.carousel.find('li:first').click();
			} else {
				next.click();
			}
		});
	
		// Pass control functions to jquery.wikia.carousel.js
		var itemClick = function(e) {
			var $this = $(this);
			// If the clicked item is disabled, treat it as the next item in the batch
			if($this.hasClass('disabled')) {
				$this.next().click();
				return false;
			}
			
			var idx = $this.index(),
				mediaArr = Lightbox.current.thumbs;
			
			if(Lightbox.ads.adIsShowing) { 
				Lightbox.ads.reset();
			}

			Lightbox.current.index = idx;
			if(idx > -1 && idx < mediaArr.length) {
				Lightbox.current.title = mediaArr[idx].title.toString(); // Added toString() for edge cases where titles are numbers
				Lightbox.current.type = mediaArr[idx].type;
			}
			
			Lightbox.updateMedia();
			
		}
		
		var trackProgressCallback = function(idx1, idx2, total) {
			
			var progress;
			
			// Track progress based on if we're in backfill content or original content
			var firstThumb = Lightbox.openModal.carousel.find('li').eq(idx1);
			if(firstThumb.hasClass('back-fill')) {
				progress = trackBackfillProgress(idx1, idx2);
			} else {
				progress = trackOriginalProgress(idx1, idx2);				
			}
			
			var template = Lightbox.openModal.progressTemplate,
				html = template.mustache(progress);
			
			Lightbox.openModal.progress.html(html);
		}
		
		var trackBackfillProgress = function(idx1, idx2) {
			var originalCount = LightboxLoader.cache[Lightbox.current.carouselType].length;

			idx1 = idx1 - originalCount - 1;
			// (BugId:38546) Don't count placeholder thumb when it is first in the row 
			if(idx1 == 0) {
				idx1 = 1;
			}
			idx2 = idx2 - originalCount - 1;
			total = Lightbox.backfillCount;
			
			return {
				idx1: idx1,
				idx2: idx2,
				total: Lightbox.backfillCountMessage
			}
		}
		
		var trackOriginalProgress = function(idx1, idx2) {
			var originalCount = LightboxLoader.cache[Lightbox.current.carouselType].length;
			
			idx2 = Math.min(idx2, originalCount);
			
			return {
				idx1: idx1,
				idx2: idx2,
				total: originalCount,
			}			
		}
		
		var beforeMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').hide();
		}
		
		var afterMove = function(idx) {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').show();
			// if we're close to the end, load more thumbnails
			if(Lightbox.current.thumbs.length - idx < Lightbox.thumbLoadCount) {
				Lightbox.getMediaThumbs.wikiPhotos();
			}
		}
		
		var itemsShown = Lightbox.ads.showAds() ? 6 : 9;

		// Make sure we have our i18n message before initializing the carousel plugin
		$.when.apply(this, deferredList).done(function() {
			// add more thumbs to carousel if we need them
			if(Lightbox.current.thumbs.length < Lightbox.thumbLoadCount) {
				// asynchronous 
				Lightbox.getMediaThumbs.wikiPhotos(); // uses Lightbox.to which is recieved in promise pattern  
			}
			
			// Do insert of placeholder thumb now that we know the number of backfill items 
			var placeholder = $('#LightboxCarouselMore').mustache({
				text: Lightbox.backfillCountMessage
			});
			Lightbox.openModal.carousel.find('li').eq(Lightbox.current.placeholderIdx-1).after(placeholder);
	

			Lightbox.openModal.carouselContainer.carousel({
				itemsShown: itemsShown,
				itemSpacing: 8,
				transitionSpeed: 700,
				itemClick: itemClick,
				activeIndex: Lightbox.current.index,
				trackProgress: trackProgressCallback,
				beforeMove: beforeMove,
				afterMove: afterMove
			});
		});
	},

	setupShareEmail: function() {
		var shareEmailForm = $('#shareEmailForm'),
			wikiaForm = new WikiaForm(shareEmailForm),
			inputGroups = shareEmailForm.find('.general-errors, .general-success');
		
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
					wikiaForm.clearGenericError(inputGroups);
					wikiaForm.clearGenericSuccess(inputGroups);
					
					var errorMsg = "",
						successMsg = "";

					if(data.errors.length) {
						$(data.errors).each(function() {
							errorMsg += this;
						})
					}
					if(data.sent.length) {
						successMsg += "Email sent to " + data.sent.join() + ". ";
					}
					
					if(errorMsg.length) {
						wikiaForm.showGenericError(errorMsg);
					}
					if(successMsg.length) {
						wikiaForm.showGenericSuccess(successMsg);
					}
					shareEmailForm.find('input[type=text]').val('');
					
					var trackingTitle = Lightbox.getTitleForTracking(); // prevent race conditions from timeout
					LightboxLoader.track(WikiaTracker.ACTIONS.SHARE, 'email', null, {title: trackingTitle, type: Lightbox.current.type});
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
	},
	handleErrorTemplate: function() {
		LightboxLoader.lightboxLoading = false;

		Lightbox.openModal.removeClass('LightboxModal');
		
		$.nirvana.sendRequest({
			controller:	'Lightbox',
			method:		'lightboxModalContentError',
			type:		'GET',
			format: 'html',
			callback: function(html) {
				var modalContent = Lightbox.openModal.find(".modalContent");
				modalContent.html(html);
				
				// Fix H1 styling
				modalContent.find('h1:first').insertBefore(modalContent);
				
				$('#close-lightbox').click(function() {
					$('#' + LightboxLoader.defaults.id).closeModal();
				});
			}
		});
	},
	getMediaThumbs: {
		backfilling: false,
		// Get article images/videos from DOM
		articleMedia: function(backfill) {
			var cached = LightboxLoader.cache.articleMedia,
				thumbArr = [];

			if(cached.length) {
				$().log("Loading articleMedia from cache", "Lightbox");
				thumbArr = cached;
			} else {
			
				var article = $('#WikiaArticle'),
					playButton = Lightbox.thumbPlayButton,
					titles = [], // array to check for title dupes
					thumbArr = [],
					infobox = article.find('.infobox');
					
				// Collect images from DOM
				var thumbs = article.find('.image, .lightbox').find('img');
				thumbs = thumbs.add(article.find('.thumbimage'));
	
				thumbs.each(function() {
					var $thisThumb = $(this),
						$thisParent = $thisThumb.parent(),
						type = ($thisThumb.hasClass('Wikia-video-thumb') || $thisParent.hasClass('video')) ? 'video' : 'image',
						title = (type == 'image') ? $thisParent.data('image-name') : $thisParent.data('video-name'),
						playButtonSpan = (type == 'video') ? playButton : '';
						
					// (BugId:38144) 
					title = title || $thisThumb.attr('alt');

					if(title) {
						// Check for dupes
						if($.inArray(title, titles) > -1) {
							return true;
						}
						titles.push(title);

						thumbArr.push({
							thumbUrl: Lightbox.thumbParams($thisThumb.data('src') || $thisThumb.attr('src'), type),
							title: title,
							type: type,
							playButtonSpan: playButtonSpan,
							//caption: caption
						});
					}
				});
				
				// Fill articleMedia cache
				LightboxLoader.cache.articleMedia = thumbArr;

				// Count backfill items for progress bar
				if(backfill) {
					Lightbox.backfillCount += thumbArr.length;			
				}
				
			}
			
			// Add thumbs to current lightbox cache
			Lightbox.current.thumbs = Lightbox.current.thumbs.concat(thumbArr);
			
			Lightbox.addThumbsToCarousel(thumbArr, backfill);
		},
		// Get related videos from DOM
		relatedVideos: function(backfill) {
			var cached = LightboxLoader.cache.relatedVideos,
				thumbArr = [];
				
			if(cached.length) {
				$().log("Loading relatedVideos from cache", "Lightbox");
				thumbArr = cached;
			} else {
			
				var thumbs = Lightbox.dom.relatedVideos,
					playButton = Lightbox.thumbPlayButton,
					titles = []; // array to check for title dupes
	
				thumbs.each(function() {
					var $thisThumb = $(this),
						thumbUrl = $thisThumb.data('src') || $thisThumb.attr('src'),
						title = $thisThumb.data('video');
	
					if(title) {
						// Check for dupes
						if($.inArray(title, titles) > -1) {
							return true;
						}
						titles.push(title);
							
						thumbArr.push({
							thumbUrl: Lightbox.thumbParams(thumbUrl, 'video'),
							title: title,
							type: 'video',
							playButtonSpan: playButton
						});
					}
				});
				
				// Fill relatedVideos cache
				LightboxLoader.cache.relatedVideos = thumbArr;

				// Count backfill items for progress bar
				if(backfill) {
					Lightbox.backfillCount += thumbArr.length;			
				}				
			}
			
			// Add thumbs to current lightbox cache
			Lightbox.current.thumbs = Lightbox.current.thumbs.concat(thumbArr);
			
			Lightbox.addThumbsToCarousel(thumbArr, backfill);
		},
		// Get latest photos from DOM
		latestPhotos: function(backfill) {
			var cached = LightboxLoader.cache.latestPhotos,
				thumbArr = [];
			if(cached.length) {
				$().log("Loading latestPhotos from cache", "Lightbox");
				thumbArr = cached;
			} else {
			
				var thumbs = $("#LatestPhotosModule .thumbimage"),
					titles = []; // array to check for title dupes
				
				thumbs.each(function() {
					var $thisThumb = $(this),
						thumbUrl = $thisThumb.data('src') || $thisThumb.attr('src'),
						title = $thisThumb.parent().data('ref').replace('File:', '');
						
					if(title) {
						// Check for dupes
						if($.inArray(title, titles) > -1) {
							return true;
						}
						titles.push(title);
							
						thumbArr.push({
							thumbUrl: Lightbox.thumbParams(thumbUrl, 'image'),
							title: title,
							type: 'image',
							playButtonSpan: ''
						})
					}
				});
				
				// Fill latestPhotos cache
				LightboxLoader.cache.latestPhotos = thumbArr;

				// Count backfill items for progress bar
				if(backfill) {
					Lightbox.backfillCount += thumbArr.length;			
				}
			}
			
			// Add thumbs to current lightbox cache
			Lightbox.current.thumbs = Lightbox.current.thumbs.concat(thumbArr);

			Lightbox.addThumbsToCarousel(thumbArr, backfill);
		},
		// Get the rest of the photos from the wiki
		wikiPhotos: function() {
			if(Lightbox.getMediaThumbs.backfilling || !Lightbox.to) {
				return;
			}
			Lightbox.getMediaThumbs.backfilling = true;
			
			$().log("Backfilling with wiki photos", "Lightbox");
			
			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'getThumbImages',
				type: 'POST',
				format: 'json',
				data: {
					to: Lightbox.to,
					count: 30,
					inclusive: Lightbox.includeLatestPhotos
				},
				callback: function(json) {
					Lightbox.to = json.to;
					if(!Lightbox.to) {
						return false;
					}
					
					var thumbArr = json.thumbs;

					// Add thumbs to wikiPhotos cache
					LightboxLoader.cache.wikiPhotos = LightboxLoader.cache.wikiPhotos.concat(thumbArr);
					
					// Add thumbs to current lightbox cache
					Lightbox.current.thumbs = Lightbox.current.thumbs.concat(thumbArr);

					// only need latest photos once
					Lightbox.includeLatestPhotos = false; 
					
					Lightbox.addThumbsToCarousel(thumbArr, true);
					
					Lightbox.getMediaThumbs.backfilling = false;
				}
			});
		}
	},
	addThumbsToCarousel: function(thumbs, backfill) {
		var liClass = false;
		
		if(backfill) {
			liClass = 'back-fill';
		}

		// render carousel
		var carouselThumbs = Lightbox.openModal.carouselTemplate.mustache({
			liClass: liClass,
			thumbs: thumbs
		});
		
		Lightbox.openModal.carousel.append(carouselThumbs);

		// if carousel is already instantiated, update settings with added thumbnails
		var container = Lightbox.openModal.carouselContainer;
		if(typeof container.updateCarouselItems == "function") {
			container.updateCarouselItems();
			container.updateCarouselWidth();
			container.updateCarouselArrows();
		}		
	},
	
	// get caption html for given target node
	/*getCaption: function(img) {
		// TODO: this is broken on Special:NewFiles page
		var caption = false;
		
		// gallery images
		var dataCaption = img.data('caption');
		
		if(dataCaption) {
			caption = dataCaption;
		} else if (img.parent().hasClass('image')) {
			// article images
			caption = img.parent().nextAll('.thumbcaption').find('.thumb-caption-text').text();
		}

		return caption;
	},*/
	thumbParams: function(url, type) {
		/*
			Get URL to a proper thumbnail
		 */
		return $.thumbUrl2ThumbUrl(url, type, 90, 55);

	},

	getTitleForTracking: function() {
		return LightboxLoader.cache.details[Lightbox.current.title].title; // get dbkey title for tracking (BugId:47644)	
	}

};

