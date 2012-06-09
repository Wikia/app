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
	modal: {
		defaults: {
			videoHeight: 360,
			topOffset: 25,
			height: 628
		}
	},
	openModal: false, // gets replaced with dom object of open modal
	shortScreen: false, // flag if the screen is shorter than modal.defaults.height
	showAds: true, // when we enable adds, set this to actually check if use should see ads
	templates: {},
	
	makeLightbox: function(params) {
		Lightbox.openModal = params.modal;
		Lightbox.current.title = params.title;
		Lightbox.current.carouselType = params.carouselType;
		
		// setup tracking
		Lightbox.openModal.tracking = {
			aggregateViewCount: 0,
			uniqueViewCount: 0,
			visitedFiles: {}	// contains title history of visited files as key.  value will just default to true
		};
		
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
				// Check screen height for future interactions
				Lightbox.shortScreen = $(window).height() < Lightbox.modal.defaults.height + Lightbox.modal.defaults.topOffset ? true : false;
				
				// Set ads class if we're showing ads
				if(Lightbox.showAds) {
					Lightbox.openModal.addClass('show-ads');
				}
				
				// Add template to modal
				Lightbox.openModal.find(".modalContent").html(html); // adds initialFileDetail js to DOM
				
				if(typeof Lightbox.initialFileDetail == 'undefined') {
					// We're showing an error template
					Lightbox.handleErrorTemplate();
					return;
				}
				
				LightboxLoader.cache[Lightbox.current.carouselType] = Lightbox.mediaThumbs.thumbs;
				
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
				
				// render carousel
				var carousel = $(carouselTemplate).mustache({
					thumbs: Lightbox.mediaThumbs.thumbs,
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
					LightboxLoader.track(WikiaTracker.ACTIONS.IMPRESSION, '', Lightbox.mediaThumbs.thumbs.length);
					Lightbox.openModal.data('onClose', function() {
						LightboxLoader.track(
							WikiaTracker.ACTIONS.CLICK, 
							'close-modal', 
							Math.round(100 * Lightbox.openModal.tracking.uniqueViewCount/Lightbox.mediaThumbs.thumbs.length)
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
					if(imageHeight > imageContainerHeight ) {
						imageHeight = imageContainerHeight;
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

			if(data.playerScript) {
				$('body').append('<script>' + data.playerScript + '</script>');
			}

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
				height: Lightbox.modal.defaults.height
			});
	
			Lightbox.video.renderVideo(data);
			
			Lightbox.updateArrows();

			Lightbox.renderHeader();
		},
		getDimensions: function() {
			// Videos should always load at the same height
			var modalHeight = Lightbox.modal.defaults.height,
				windowHeight = $(window).height(),
				topOffset = (windowHeight - modalHeight - 10)/2;
			
				topOffset = topOffset + $(window).scrollTop();

				var dimensions = {
					topOffset: topOffset
				}
				
				return dimensions;
		}	
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
			
			$('#LightboxCarouselProgress').html(html);
		}
		
		var beforeMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').hide();
		}
		
		var afterMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button').show();
		}
		
		var itemsShown = Lightbox.showAds ? 6 : 9;

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
		
		var modalContent = Lightbox.openModal.find('.modalContent');
		
		// Fix H1 styling
		modalContent.find('h1:first').insertBefore(modalContent);
		
		$('#close-lightbox').click(function() {
			$('#' + LightboxLoader.modal.initial.id).closeModal();
		});
	}
};