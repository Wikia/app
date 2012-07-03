var Lightbox = {
	log: function(content) {
		$().log(content, "Lightbox");
	},
	// cached thumbnail arrays and detailed info 
	cache:{
		share: {}
	},
	eventTimers: {
		lastMouseUpdated: 0
	},
	current: {
		type: '', // image or video
		title: '', // currently displayed file name
		carouselType: '', // articleMedia, relatedVideos, or latestPhotos
		index: -1 // ex: LightboxLoader.cache[Lightbox.current.carouselType][Lightbox.current.index]		
	},
	openModal: false, // gets replaced with dom object of open modal
	shortScreen: false, // flag if the screen is shorter than LightboxLoader.defaults.height
	
	makeLightbox: function(params) {	
		Lightbox.openModal = params.modal;
		Lightbox.current.title = params.title;
		
		var id = params.parent ? params.parent.attr('id') : '';

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
		
		// setup tracking
		Lightbox.openModal.tracking = {
			aggregateViewCount: 0,
			uniqueViewCount: 0,
			visitedFiles: {}	// contains title history of visited files as key.  value will just default to true
		};
		
			
		// Check screen height for future interactions
		Lightbox.shortScreen = $(window).height() < LightboxLoader.defaults.height + LightboxLoader.defaults.topOffset ? true : false;
		
		// Set ads class if we're showing ads
		if(Lightbox.ads.showAds) {
			Lightbox.openModal.addClass('show-ads');
		}
		
		// Add template to modal
		Lightbox.openModal.find(".modalContent").html(LightboxLoader.templateHtml);
		
		if(!Lightbox.initialFileDetail['exists']) {
			// We're showing an error template
			Lightbox.handleErrorTemplate();
			return;
		}
		
		LightboxLoader.cache[Lightbox.current.carouselType] = Lightbox.getMediaThumbs[Lightbox.current.carouselType]();
		
		// Set up carousel
		var carouselTemplate = $('#LightboxCarouselTemplate');	// TODO: template cache
		var moreInfoTemplate = $('#LightboxMoreInfoTemplate');	// TODO: template cache
		var shareTemplate = $('#LightboxShareTemplate');	// TODO: template cache
		
		var readableTitle = Lightbox.current.title.split('_').join(" ");
		
		for(var i = 0; i < Lightbox.mediaThumbs.length; i++) {
			if(Lightbox.mediaThumbs[i].title == readableTitle) {
				Lightbox.current.index = i;
				break;
			}
		}
		
		// render carousel
		var carousel = $(carouselTemplate).mustache({
			thumbs: Lightbox.mediaThumbs,
			progress: ""
		});
		
		// pre-cache known doms
		Lightbox.openModal.carousel = $('#LightboxCarouselInner');
		Lightbox.openModal.header = Lightbox.openModal.find('.LightboxHeader');
		Lightbox.openModal.lightbox = Lightbox.openModal.find('.WikiaLightbox');
		Lightbox.openModal.moreInfo = Lightbox.openModal.find('.more-info');
		Lightbox.openModal.share = Lightbox.openModal.find('.share');
		Lightbox.openModal.media = Lightbox.openModal.find('.media');
		Lightbox.openModal.arrows = Lightbox.openModal.find('.lightbox-arrows');
		Lightbox.openModal.closeButton = Lightbox.openModal.find('.close');
		Lightbox.current.type = Lightbox.initialFileDetail.mediaType;
		
		// attach carousel
		Lightbox.openModal.carousel.append(carousel);
		Lightbox.openModal.progress = $('#LightboxCarouselProgress');
		Lightbox.openModal.data('overlayactive', true);
		Lightbox.setUpCarousel();
		
		// callback to finish lighbox loading
		var updateCallback = function(json) {
			LightboxLoader.cache.details[Lightbox.current.title] = json;
			Lightbox.updateMedia();
			Lightbox.showOverlay();
			Lightbox.hideOverlay(3000);
			
			LightboxLoader.lightboxLoading = false;
			Lightbox.log("Lightbox modal loaded");
			/* lightbox loading ends here */
			
			/* tracking after lightbox has fully loaded */
			LightboxLoader.track(WikiaTracker.ACTIONS.IMPRESSION, '', Lightbox.mediaThumbs.length);
			Lightbox.openModal.data('onClose', function() {
				LightboxLoader.track(
					WikiaTracker.ACTIONS.CLICK, 
					'close-modal', 
					Math.round(100 * Lightbox.openModal.tracking.uniqueViewCount/Lightbox.mediaThumbs.length)
				);
			});
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
				if(!(target.closest('.arrow, .LightboxHeader, .LightboxCarousel')).exists()) {
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
			LightboxLoader.getMediaDetail({title: Lightbox.current.title}, function(json) {
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
				LightboxLoader.getMediaDetail({'title': Lightbox.current.title}, Lightbox.video.renderVideo);
			}
			Lightbox.openModal.removeClass('share-mode').removeClass('more-info-mode');
			Lightbox.openModal.share.html('');
			Lightbox.openModal.moreInfo.html('');
		// Pin the toolbar on icon click
		}).on('click.Lightbox', '.LightboxCarousel .toolbar .pin', function(evt) {
			var target = $(evt.target);
			var overlayActive = Lightbox.openModal.data('overlayactive');
			if(overlayActive) {
				var pinnedTitle = target.data('pinned-title')
				target.addClass('active').attr('title', pinnedTitle);	// add active state to button when carousel overlay is active
				Lightbox.openModal.addClass('pinned-mode');
			} else {
				var pinTitle = target.data('pin-title')
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
				} else {
					Lightbox.current.index--;
				}						
			}

			Lightbox.openModal.find('.carousel li').eq(Lightbox.current.index).trigger('click');
		});
	},
	image: {
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
				
				Lightbox.updateArrows();
				
				Lightbox.renderHeader();
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
					imageContainerHeight -= 220;
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
				$(this).remove();
				
				callback(dimensions);
			});
		}
	},
    updateMediaType: function() {

        if ( Lightbox.current.type == 'video' ) {
            $('a.see-full-size-link').hide();
        } else {
            $('a.see-full-size-link').show();
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
		}
	},
	ads: {
		// should user see ads?
		showAds: false, // !window.wgUserName || window.wgUserShowAds,
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
			if(!Lightbox.ads.showAds || Lightbox.ads.adWasShown) {
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
	
			$('#MODAL_INTERSTITIAL').show(); // TODO: check with ad ops to make sure hiding/showing ad will work
			
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
	getDefaultTopOffset: function() {
		var modalHeight = LightboxLoader.defaults.height,
			windowHeight = $(window).height(),
			topOffset = (windowHeight - modalHeight - 10)/2;
		
		return topOffset + $(window).scrollTop();
		
	},
	renderHeader: function() {
		var headerTemplate = Lightbox.openModal.find("#LightboxHeaderTemplate");	//TODO: replace with cache
		LightboxLoader.getMediaDetail({title: Lightbox.current.title}, function(json) {
			var renderedResult = headerTemplate.mustache(json)
			Lightbox.openModal.header
				.html(renderedResult)
				.prepend($(Lightbox.openModal.closeButton).clone(true, true));	// clone close button into header
		});
	},
	// Render special Header for ads
	renderAdHeader: function() {
		var headerTemplate = Lightbox.openModal.find("#LightboxHeaderAdTemplate").html();	//TODO: replace with cache
		Lightbox.openModal.header
			.html(headerTemplate)
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
			title: title,
			type: type
		}, function(data) {
			Lightbox[type].updateLightbox(data);		
			Lightbox.showOverlay();
			Lightbox.hideOverlay();
		});
		
		// update tracking paramenter
		var tracking = Lightbox.openModal.tracking;
		tracking.aggregateViewCount++;
		if(!(title in tracking.visitedFiles)) {
			tracking.visitedFiles[title] = true;
			tracking.uniqueViewCount++;
		}
		LightboxLoader.track(WikiaTracker.ACTIONS.VIEW, type, tracking.aggregateViewCount);
	},
	updateArrows: function() {		
		var carouselType = Lightbox.current.carouselType,
			mediaArr = LightboxLoader.cache[carouselType],
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
				type: 'POST',	/* TODO (hyun) - might change to get */
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
		$(window).on('keydown.Lightbox', function(e) {
			if(e.keyCode == 37) {
				$('#LightboxPrevious').click();
			} else if(e.keyCode == 39) {
				$('#LightboxNext').click();
			}
		});
	
		// Pass control functions to jquery.wikia.carousel.js
		var itemClick = function(e) {
			var idx = $(this).index(),
				carouselType = Lightbox.current.carouselType,
				mediaArr = LightboxLoader.cache[carouselType];
			
			if(Lightbox.ads.adIsShowing) { 
				Lightbox.ads.reset();
			}

			Lightbox.current.index = idx;
			if(idx > -1 && idx < mediaArr.length) {
				Lightbox.current.title = mediaArr[idx].title;
				Lightbox.current.type = mediaArr[idx].type;
			}
			
			Lightbox.updateMedia();	
		}
		
		var trackProgressCallback = function(idx1, idx2, total) {
			var template = $('#LightboxCarouselProgressTemplate');
			
			var html = template.mustache({
				idx1: idx1,
				idx2: idx2,
				total: total
			});
			
			Lightbox.openModal.progress.html(html);
		}
		
		var beforeMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').hide();
		}
		
		var afterMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').show();
		}
		
		var itemsShown = Lightbox.ads.showAds ? 6 : 9;

		$('#LightboxCarouselContainer').carousel({
			itemsShown: itemsShown,
			itemSpacing: 8,
			transitionSpeed: 1000,
			itemClick: itemClick,
			activeIndex: Lightbox.current.index,
			trackProgress: trackProgressCallback,
			beforeMove: beforeMove,
			afterMove: afterMove
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
				Lightbox.openModal.find(".modalContent").html(html);
				$('#close-lightbox').click(function() {
					$('#' + LightboxLoader.modal.initial.id).closeModal();
				});
			}
		});
		
		/*
		// Fix H1 styling
		modalContent.find('h1:first').insertBefore(modalContent);
		*/
	},
	getMediaThumbs: {
		articleMedia: function() {
			var article = $('#WikiaArticle'),
				playButton = '<span class="Wikia-video-play-button min" style="width: 90px; height: 55px;"></span>',
				titles = [], // array to check for title dupes
				thumbArr = [],
				infobox = article.find('.infobox');
				
			// Collect images from DOM
			var thumbs = article.find('.image, .lightbox, .activityfeed-video-thumbnail').find('img');
			thumbs = thumbs.add(article.find('.thumbimage'));

			thumbs.each(function() {
				var type = ($(this).hasClass('Wikia-video-thumb')) ? 'video' : 'image',
					title = (type == 'image') ? $(this).parent().data('image-name') : $(this).parent().data('video-name'),
					playButtonSpan = (type == 'video') ? playButton : '';
				
				// Check for dupes
				if(title) {
					if($.inArray(title, titles) > -1) {
						return true;
					}
					titles.push(title);
				}
					
				thumbArr.push({
					thumbUrl: $(this).data('src') || $(this).attr('src'), // TODO - turn this into a 90x55 thumbnail
					title: title,
					type: type,
					playButtonSpan: playButtonSpan
				});
			});
			
			Lightbox.mediaThumbs = thumbArr;
			
			return thumbArr;
		},
		relatedVideo: function() {
			var thumbs = $('#RelatedVideosRL').find('.Wikia-video-thumb'),
				playButton = '<span class="Wikia-video-play-button min" style="width: 90px; height: 55px;"></span>',
				titles = [], // array to check for title dupes
				thumbArr = [];

			thumbs.each(function() {
				var thumbUrl = $(this).data('src') || $(this).attr('src'),
					title = $(this).data('video');

				// Check for dupes
				if($.inArray(title, titles) > -1) {
					return true;
				}
				titles.push(title);
					
				thumbArr.push({
					thumbUrl: thumbUrl, // TODO - turn this into a 90x55 thumbnail
					title: title,
					type: 'video',
					playButtonSpan: playButton
				})
			});

			Lightbox.mediaThumbs = thumbArr;
			
			return thumbArr;
		},
		latestPhotos: function() {
			var thumbs = $("#LatestPhotosModule .thumbimage"),
				titles = [], // array to check for title dupes
				thumbArr = [];
			
			thumbs.each(function() {
				var thumbUrl = $(this).data('src') || $(this).attr('src'),
					title = $(this).parent().data('ref').replace('File:', '');
					
				// Check for dupes
				if($.inArray(title, titles) > -1) {
					return true;
				}
				titles.push(title);
					
				thumbArr.push({
					thumbUrl: thumbUrl, // TODO - turn this into a 90x55 thumbnail
					title: title,
					type: 'image',
					playButtonSpan: ''
				})
				
			});

			Lightbox.mediaThumbs = thumbArr;
			
			return thumbArr;
		},
		other: function() {
			// Stuff like category pages
		}
	}
};

