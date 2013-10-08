/*global LightboxLoader:true, RelatedVideosIds, LightboxTracker*/

(function(window, $) {

var Lightbox = {
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
	thumbPlayButton: '<div class="Wikia-video-play-button" style="line-height:55px;width:90px;"><img class="sprite play small" src="' + window.wgBlankImgUrl + '"></div>', // overlay for thumb images
	thumbLoadCount: 20, // Number of thumbs to load at a time.  Must be at least 9 (i.e. number of items in carousel)
	backfillCount: 0,
	backfillCountMessage: false,
	to: 0, // timestamp for getting wiki images

	makeLightbox: function(params) {
		// Allow other extensions to react when a Lightbox is opened.  Used in FilePage and Touchstorm widget
		$(window).trigger('lightboxOpened');

		// if we don't have latest photos in the DOM, request them from back end
		Lightbox.includeLatestPhotos = !$('#LatestPhotosModule .carousel-container').length;
		Lightbox.openModal = params.modal;

		// If file doesn't exist, show the error modal
		if(!Lightbox.initialFileDetail['exists']) {
			Lightbox.showErrorModal();
			return;
		}

		var trackingObj = this.getClickSource(params);

		Lightbox.current.key = params.key.toString(); // Added toString() for edge cases where titles are numbers

		Lightbox.current.carouselType = trackingObj.carouselType;

		// Set up tracking
		var clickSource = trackingObj.clickSource,
			trackingCarouselType = trackingObj.trackingCarouselType;

		Lightbox.openModal.aggregateViewCount = 0;
		Lightbox.openModal.clickSource = clickSource;
		// This is a temporary duplication of clicksource tracking until we switch over to the video-player-stats version
		Lightbox.openModal.vbClickSource = clickSource;

		// Check screen height for future interactions
		Lightbox.shortScreen = $(window).height() < LightboxLoader.defaults.height + LightboxLoader.defaults.topOffset ? true : false;

		// Add template to modal
		Lightbox.openModal.find(".modalContent").html(LightboxLoader.templateHtml);

		// cache re-used DOM elements and templates for this modal instance
		Lightbox.cacheDOM();

		// Init ads in Lightbox
		if ($('#MODAL_RECTANGLE').length && window.wgShowAds) {
			Lightbox.openModal.lightbox.addClass('show-ads');
			window.adslots2.push(['MODAL_RECTANGLE']);
			Lightbox.ads.adModalRectangleShown = true;
		}

		// Set up carousel
		Lightbox.setUpCarousel();

		LightboxLoader.cache.details[Lightbox.current.title] = Lightbox.initialFileDetail;
		Lightbox.updateMedia();
		Lightbox.showOverlay();
		Lightbox.hideOverlay(3000);

		LightboxLoader.lightboxLoading = false;

		/* tracking after lightbox has fully loaded */
		var trackingTitle = Lightbox.current.key;
		LightboxTracker.track(Wikia.Tracker.ACTIONS.IMPRESSION, '', Lightbox.current.placeholderIdx, {title: trackingTitle, 'carousel-type': trackingCarouselType});

		// attach event handlers
		Lightbox.bindEvents();

	},
	cacheDOM: function() {
		// Template cache
		Lightbox.openModal.moreInfoTemplate = $('#LightboxMoreInfoTemplate');
		Lightbox.openModal.shareTemplate = $('#LightboxShareTemplate');
		Lightbox.openModal.progressTemplate = $('#LightboxCarouselProgressTemplate');
		Lightbox.openModal.headerTemplate = $("#LightboxHeaderTemplate");
		Lightbox.openModal.headerAdTemplate = $("#LightboxHeaderAdTemplate");

		// Cache error message
		Lightbox.openModal.errorMessage = $("#LightboxErrorMessage").html();

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

	},
	bindEvents: function() {
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
		// Show share screen on button click
		}).on('click.Lightbox', '.LightboxHeader .share-button', function(evt) {
			if(Lightbox.current.type === 'video') {
				Lightbox.video.destroyVideo();
			}
			Lightbox.openModal.addClass('share-mode');
			Lightbox.getShareCodes({fileTitle: Lightbox.current.key, articleTitle:wgTitle}, function(json) {
				Lightbox.openModal.share.append(Lightbox.openModal.shareTemplate.mustache(json))
					.find('input[type=text]').click(function() {
						$(this).select();
					})
					.filter('.share-input')
					.click();

				var trackingTitle = Lightbox.current.key;
				LightboxTracker.track(Wikia.Tracker.ACTIONS.CLICK, 'lightboxShare', null, {title: trackingTitle, type: Lightbox.current.type});

				Lightbox.openModal.share.shareUrl = json.shareUrl; // cache shareUrl for email share
				Lightbox.setupShareEmail();

				Lightbox.openModal.share.find('.social-links').on('click', 'a', function() {
					var shareType = $(this).attr('class');
					LightboxTracker.track(Wikia.Tracker.ACTIONS.SHARE, shareType, null, {title: trackingTitle, type: Lightbox.current.type});
				});

			});
		// Close more info and share screens on button click
		}).on('click.Lightbox', '.more-info-close', function(evt) {
			if(Lightbox.current.type === 'video') {
				LightboxLoader.getMediaDetail({fileTitle: Lightbox.current.key}, Lightbox.video.renderVideo);
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
		}).on('click.Lightbox', '.article-add-button', function() {
			Lightbox.doAutocomplete($(this));
		});
	},
	doAutocomplete: function (elem) {
		$.when(
			$.loadJQueryAutocomplete()
		).then($.proxy(function() {
			var input = elem.hide().next('input').show();

			input.autocomplete({
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
				onSelect: function(value, data, event) {
					var valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
						// slashes can't be urlencoded because they break routing
						location = wgArticlePath.
							replace(/\$1/, valueEncoded).
							replace(encodeURIComponent('/'), '/');

					location = location + "?action=edit&addFile=" + Lightbox.current.key;

					/*this.track({
						eventName: 'search_start_suggest',
						sterm: valueEncoded,
						rver: 0
					});*/

					// Respect modifier keys to allow opening in a new window (BugId:29401)
					if (event.button === 1 || event.metaKey || event.ctrlKey) {
						window.open(location);

						// Prevents hiding the container
						return false;
					} else {
						window.location.href = location;
					}
				},
				appendTo: '#lightbox-add-to-article',
				deferRequestBy: 400,
				minLength: 3,
				maxHeight: 800,
				selectedClass: 'selected',
				width: '270px',
				skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
			});
		}, this));

	},
	clearTrackingTimeouts: function() {
		// Clear video tracking timeout
		clearTimeout(Lightbox.video.trackingTimeout);
		// Clear image tracking
		clearTimeout(Lightbox.image.trackingTimeout);
	},
	//  method for removing class and inline styles applied to the lightbox by Lightbox.error.updateLightbox
	clearErrorMessageStyling: function() {
		this.openModal.media.removeClass('error-lightbox').attr('style', 'line-height: normal;');
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

				Lightbox.openModal.media.find('img').first().load(function() {
					$(window).trigger('resize'); // firefox image loading hack (BugId:32477)
				});

				Lightbox.updateArrows();

				Lightbox.updateUrlState();

				Lightbox.renderHeader();

				Lightbox.updateMediaType();

				Lightbox.clearTrackingTimeouts();

				var trackingTitle = Lightbox.current.key; // prevent race conditions from timeout
				Lightbox.image.trackingTimeout = setTimeout(function() {
					Lightbox.openModal.aggregateViewCount++;
					LightboxTracker.track(Wikia.Tracker.ACTIONS.VIEW, 'image', Lightbox.openModal.aggregateViewCount, {title: trackingTitle, clickSource: Lightbox.openModal.clickSource});

					// Set all future click sources to Lightbox rather than DOM element
					Lightbox.openModal.clickSource = LightboxTracker.clickSource.LB;
					Lightbox.openModal.vbClickSource = LightboxTracker.clickSource.LB;
				}, 500);

			});

		},
		getDimensions: function(imageUrl, callback) {
			// Get image url from json - preload image
			// TODO: cache image dimensions so we don't have to preload the image again
			var image = $('<img id="LightboxPreload" src="'+imageUrl+'" />').appendTo('body');

			// Do calculations
			image
				.error(function() {
					Lightbox.error.updateLightbox();
				})
				.load(function() {
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
			Lightbox.openModal.media
				.addClass('video-media')
				.css('line-height','normal');

			require(['wikia.videoBootstrap'], function (VideoBootstrap) {
				LightboxLoader.videoInstance = new VideoBootstrap(Lightbox.openModal.media[0], data.videoEmbedCode, Lightbox.openModal.vbClickSource);
				Lightbox.openModal.vbClickSource = LightboxTracker.clickSource.LB;
			});
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

			Lightbox.updateUrlState();

			Lightbox.renderHeader();

            Lightbox.updateMediaType();

			Lightbox.clearTrackingTimeouts();

			var trackingTitle = Lightbox.current.key; // prevent race conditions from timeout

			/* Since we don't have an 'onload' event for video views, we're setting a timeout before counting a video as viewed.
			 * Below are the dates this timeout has been in effect.
			 *
			 * 7/27/12 - 8/21/12: 5000ms (5s)
			 * 8/21/12 - 2/13/13: 1000ms (1s)
			 * 2/13/13 - present: 3000ms (3s)
			 */
			Lightbox.video.trackingTimeout = setTimeout(function() {
				Lightbox.openModal.aggregateViewCount++;
				LightboxTracker.track(Wikia.Tracker.ACTIONS.VIEW, 'video', Lightbox.openModal.aggregateViewCount, {title: trackingTitle, provider: data.providerName, clickSource: Lightbox.openModal.clickSource});

				// Set all future click sources to Lightbox rather than DOM element
				Lightbox.openModal.clickSource = LightboxTracker.clickSource.LB;
			}, 3000);

		}
	},
	ads: {
		// is MODAL_RECTANGLE ad shown?
		adModalRectangleShown: false,
		// preload ad after this number of unique images/videos are shown
		adMediaCountPreload: 2,
		// show an ad after this number of unique images/videos are shown
		adMediaCount: 2,
		// array of media titles shown for tracking unique views
		adMediaProgress: [],
		// how many items where shown since showing last ad
		adMediaShownSinceLastAd: 0,
		// is an ad already loaded?
		adWasPreloaded: false,
		// are we showing an ad right now?
		adIsShowing: false,
		// how many times an ad have already been shown?
		adWasShownTimes: 0,
		// how many times at maximum ad should be shown?
		adShowMaxTimes: window.wgShowAdModalInterstitialTimes,

		getSlotName: function() {
			if (this.adWasShownTimes) {
				return 'MODAL_INTERSTITIAL_' +  this.adWasShownTimes;
			}
			return 'MODAL_INTERSTITIAL';
		},
		// should user see ads?
		showAds: function() {
			return !!(window.wgShowAds
				&& (Geo.getCountryCode() === 'US' || Geo.getCountryCode() === 'GB')
				&& $('#' + this.getSlotName()).length);
		},
		preloadAds: function() {
			if (!this.adWasPreloaded) {
				this.adWasPreloaded = true;
				window.adslots2.push([this.getSlotName()]);
			}
		},
		// Determine if we should show an ad
		showAd: function(key, type) {
			// Already shown?
			if(!this.showAds() || this.adWasShownTimes >= this.adShowMaxTimes) {
				return false;
			}

			var countToShow = this.adMediaCount,
				countToLoad = this.adMediaCountPreload,
				progress = this.adMediaProgress;

			if(progress.indexOf(key) < 0) {
				if (type !== 'video') {
					// No ads for video content
					if(this.adMediaShownSinceLastAd >= countToLoad) {
						this.preloadAds();
					}
					if(this.adMediaShownSinceLastAd >= countToShow) {
						this.updateLightbox();
						return true;
					}
					this.adMediaShownSinceLastAd += 1;
				}
				progress.push(key);
			}

			// Not showing an ad.
			return false;
		},
		// Display the ad
		updateLightbox: function() {
			Lightbox.openModal.media.html('').hide();

			// Show special header for ads
			Lightbox.renderAdHeader();

			// For interstitial ads, always show the overlay
			Lightbox.showOverlay();

			// Show the ad
			$('#' + this.getSlotName()).show();

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

			// Set flag to indicate we're showing an ad (for arrow click handler)
			this.adIsShowing = true;

			// remove "?file=" from URL
			Lightbox.updateUrlState(true);
		},
		// Remove showing ad flag
		reset: function() {
			var $oldSlot = $('#' + this.getSlotName()).html('').hide();

			this.adIsShowing = false;
			this.adWasPreloaded = false;
			this.adWasShownTimes += 1;
			this.adMediaShownSinceLastAd = 0;

			$oldSlot.attr('id', this.getSlotName());

			Lightbox.openModal.media.show();
			Lightbox.openModal.progress.removeClass('invisible');
		}
	},
	error: {
		updateLightbox: function() {
			// Set lightbox css
			var css = {
				height: LightboxLoader.defaults.height
			};

			// don't change top offset if the screen is shorter than the min modal height
			if(!Lightbox.shortScreen) {
				css['top'] = Lightbox.getDefaultTopOffset();
			}

			// Resize modal
			Lightbox.openModal.css(css);

			// Empty header html
			Lightbox.openModal.header
				.html('')
				.prepend($(Lightbox.openModal.closeButton).clone(true, true));	// clone close button into header

			// Display error message
			Lightbox.openModal.media
				.css({
					'margin-top': (LightboxLoader.defaults.height/2)-14,
					'line-height': 'normal'
				})
				.addClass('error-lightbox')
				.html(Lightbox.openModal.errorMessage);

			// remove "?file=" from URL
			Lightbox.updateUrlState(true);
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
		LightboxLoader.getMediaDetail({fileTitle: Lightbox.current.key}, function(json) {
			var renderedResult = headerTemplate.mustache(json);
			Lightbox.openModal.header
				.html(renderedResult)
				.prepend($(Lightbox.openModal.closeButton).clone(true, true));	// clone close button into header
		});
	},
	// Render special header for ads
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

		// If an interstitial ad is being shown, do not hideOverlay
		if (Lightbox.ads.adIsShowing) {
			return;
		}

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

		// If a video uses a timeout for tracking, clear it
		if ( LightboxLoader.videoInstance ) {
			LightboxLoader.videoInstance.clearTimeoutTrack();
		}

		var key = Lightbox.current.key;
		var type = Lightbox.current.type;

		// This is where ad UI may interrupt the flow
		if(Lightbox.ads.showAd(key, type)) {
			return;
		}

		LightboxLoader.getMediaDetail({
			fileTitle: key,
			type: type
		}, function(data) {
			if(data.exists === false) {
				Lightbox.error.updateLightbox();
				return;
			}

			// remove error message style/class chagnes to lightbox
			if (Lightbox.openModal.media.hasClass('error-lightbox')) {
				Lightbox.clearErrorMessageStyling();
			}

			Lightbox[type].updateLightbox(data);
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

	// Handle history API
	updateUrlState: function(clear) {
		var qs = window.Wikia.Querystring();

		if(clear) {
			qs.removeVal('file').replaceState();
		} else {
			qs.setVal('file', this.current.key, true).replaceState();
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
	carouselTypes: [
		'relatedVideos',
		'articleMedia',
		'latestPhotos'
	],
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
		var types = Lightbox.carouselTypes,
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
		Lightbox.setCarouselIndex();

		// Cache progress template
		Lightbox.openModal.progress = $('#LightboxCarouselProgress');
		Lightbox.openModal.data('overlayactive', true);

		$(document).off('keydown.Lightbox')
			.on('keydown.Lightbox', function(e) {
				if(e.keyCode == 37) {
					e.preventDefault();
					$('#LightboxPrevious').click();
				} else if(e.keyCode == 39) {
					e.preventDefault();
					$('#LightboxNext').click();
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
				var key = mediaArr[idx].key;
				if(!key) {
					key = mediaArr[idx].title.replace(/ /g, '_');
					LightboxLoader.handleOldDom(1);
				}
				Lightbox.current.key = key.toString(); // Added toString() for edge cases where titles are numbers
				Lightbox.current.type = mediaArr[idx].type;
			}

			Lightbox.updateMedia();

		};

		var trackBackfillProgress = function(idx1, idx2) {
			var originalCount = LightboxLoader.cache[Lightbox.current.carouselType].length;

			idx1 = idx1 - originalCount - 1;
			// (BugId:38546) Don't count placeholder thumb when it is first in the row
			if(idx1 == 0) {
				idx1 = 1;
			}
			idx2 = idx2 - originalCount - 1;

			return {
				idx1: idx1,
				idx2: idx2,
				total: Lightbox.backfillCountMessage
			}
		};

		var trackOriginalProgress = function(idx1, idx2) {
			var originalCount = LightboxLoader.cache[Lightbox.current.carouselType].length;

			idx2 = Math.min(idx2, originalCount);

			return {
				idx1: idx1,
				idx2: idx2,
				total: originalCount
			};
		};

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
		};

		var beforeMove = function() {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button .play').hide();
		};

		var afterMove = function(idx) {
			Lightbox.openModal.carousel.find('.Wikia-video-play-button .play').show();
			// if we're close to the end, load more thumbnails
			if(Lightbox.current.thumbs.length - idx < Lightbox.thumbLoadCount) {
				Lightbox.getMediaThumbs.wikiPhotos();
			}
		};

		// show-ads class appears when there is going to be a MODAL_RECTANGLE ad
		var itemsShown = Lightbox.ads.adModalRectangleShown ? 6 : 9;

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

	setCarouselIndex: function() {
		for(var i = 0; i < Lightbox.current.thumbs.length; i++) {
			if(Lightbox.current.thumbs[i].key == Lightbox.current.key) {
				Lightbox.current.index = i;
				break;
			}
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
					type: Lightbox.current.type,
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

					var trackingTitle = Lightbox.current.key; // prevent race conditions from timeout
					LightboxTracker.track(Wikia.Tracker.ACTIONS.SHARE, 'email', null, {title: trackingTitle, type: Lightbox.current.type});
				}
			});
		}

		shareEmailForm.submit(function(e) {
			e.preventDefault();
			var addresses = $(this).find('input').first().val();

			// make sure user is logged in
			if (window.wgUserName) {
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
	// Show this modal when ?file=xyz and xyz doesn't exist - mainly used for sharing and direct links
	showErrorModal: function() {
		LightboxLoader.lightboxLoading = false;

		Lightbox.openModal.closeModal();

		$.nirvana.sendRequest({
			controller:	'Lightbox',
			method:		'lightboxModalContentError',
			type:		'GET',
			format: 'html',
			data: {
				lightboxVersion: window.wgStyleVersion,
				userLang: window.wgUserLanguage // just in case user changes language prefs
			},
			callback: function(html) {
				$(html).makeModal({
					width: 600
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
				thumbArr = cached;
			} else {
				var article = $('#WikiaArticle, #WikiaArticleComments'),
					playButton = Lightbox.thumbPlayButton,
					keys = [], // array to check for title dupes
					thumbArr = [],
					infobox = article.find('.infobox');
				// Collect images from DOM
				var thumbs = article.find('img[data-image-name], img[data-video-name]');

				if(!thumbs.length) {
					thumbs = article.find('.image, .lightbox').find('img').add(article.find('.thumbimage'));
					LightboxLoader.handleOldDom(2);
				}

				thumbs.each(function() {
					var $thisThumb = $(this),
						$thisParent = $thisThumb.parent(),
						type,
						title,
						key,
						playButton;

					if($thisThumb.closest('.ogg_player').length) {
						return;
					}

					var videoName = $thisThumb.attr('data-video-name') || $thisThumb.parent().attr('data-video-name');

					if(videoName) {
						type = 'video';
						title = videoName;
						key = $thisThumb.attr('data-video-key')
						playButtonSpan = Lightbox.thumbPlayButton;
					} else {
						type = 'image';
						title = $thisThumb.attr('data-image-name') || $thisThumb.parent().attr('data-image-name');
						key = $thisThumb.attr('data-image-key')
						playButtonSpan = '';
					}

					if(!key) {
						key = title && title.replace(/ /g, '_');
						LightboxLoader.handleOldDom(2);
					}

					if(key) {
						// Check for dupes
						if($.inArray(key, keys) > -1) {
							return true;
						}
						keys.push(key);

						thumbArr.push({
							thumbUrl: Lightbox.thumbParams($thisThumb.data('src') || $thisThumb.attr('src'), type),
							title: title,
							key: key,
							type: type,
							playButtonSpan: playButtonSpan
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
			if(!window.RelatedVideosIds) {
				return;
			}

			var cached = LightboxLoader.cache.relatedVideos,
				thumbArr = [];

			if(cached.length) {
				thumbArr = cached;
			} else {

				var playButton = Lightbox.thumbPlayButton,
					RVI = window.RelatedVideosIds,
					i,
					arrLength;


				for(i = 0, arrLength = RVI.length; i < arrLength; i++) {
					var key = RVI[i].key,
						title = RVI[i].title;

					if(!key) {
						key = title.replace(/ /g, '_');
						LightboxLoader.handleOldDom(3);
					}

					thumbArr.push({
						thumbUrl: Lightbox.thumbParams(RVI[i].thumb, 'video'),
						key: key,
						title: title,
						type: 'video',
						playButtonSpan: playButton
					});

				}

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
				thumbArr = cached;
			} else {
				var thumbs = $("#LatestPhotosModule .thumbimage"),
					keys = []; // array to check for title dupes

				thumbs.each(function() {
					var $thisThumb = $(this),
						thumbUrl = $thisThumb.data('src') || $thisThumb.attr('src'),
						title = $thisThumb.attr('data-image-name'),
						key = $thisThumb.attr('data-image-key');

					if(!key) {
						key = title && title.replace(/ /g, '_');
						LightboxLoader.handleOldDom(4);
					}

					if(key) {
						// Check for dupes
						if($.inArray(key, keys) > -1) {
							return true;
						}
						keys.push(key);

						thumbArr.push({
							thumbUrl: Lightbox.thumbParams(thumbUrl, 'image'),
							key: key,
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
		return Wikia.Thumbnailer.getThumbURL(url, type, 90, 55);

	},

	/**
	 * @param {Object} params Object containing any combination of "parent" (required) "target" (optional) or "clickSource" (optional)
	 */
	getClickSource: function(params) {
		var parent = params.parent,
			target = params.target,
			clickSource = params.clickSource,
			id = parent.attr('id'),
			VPS = LightboxTracker.clickSource,

			// Two vars that basically mean the same thing but are here for legacy purposes
			carouselType = "",
			trackingCarouselType = "";

		switch (id) {

			// Related Videos
			case 'RelatedVideosRL':
				clickSource = clickSource || VPS.RV;

				carouselType = "relatedVideos";
				trackingCarouselType = "related-videos";
				break;

			// Embeded in Article Comments
			case 'WikiaArticleComments':
				clickSource = clickSource || VPS.EMBED;

				carouselType = "articleMedia";
				trackingCarouselType = "article";
				break;

			case 'LatestPhotosModule':
				clickSource = clickSource || VPS.LP;

				carouselType = "latestPhotos";
				trackingCarouselType = "latest-photos";
				break;

			case 'TouchStormModule':
				clickSource = clickSource || VPS.TOUCHSTORM;

				carouselType = "touchStorm";
				trackingCarouselType = "touch-storm";
				break;

			case 'WikiaArticle':
				// Lightbox doesn't care what kind of article page, but clickSource tracking does
				carouselType = "articleMedia";
				trackingCarouselType = "article";

				if(typeof clickSource != 'undefined') {
					// Click source is already set so we don't have to look for it.
					break;
				}

				// Hubs
				if(window.wgWikiaHubType) {
					clickSource = VPS.HUBS;
					break;
				}

				// Search
				var searchParent = target.closest('.Search');
				if(searchParent.length) {
					clickSource = VPS.SEARCH;
					break;
				}

				// Special:Videos
				var svParent = target.closest('.VideoGrid');
				if(svParent.length) {
					clickSource = VPS.SV;
					break;
				}

				// WikiActivity
				waParent = target.closest('#wikiactivity-main');
				if(waParent.length) {
					clickSource = VPS.OTHER;
					break;
				}

				// Embeded in an article
				clickSource = VPS.EMBED;
				break;

			default:
				clickSource = VPS.OTHER;

				carouselType = "articleMedia";
				trackingCarouselType = "article";
		}

		return {
			clickSource: clickSource,
			carouselType: carouselType,
			trackingCarouselType: trackingCarouselType
		};
	}
};

window.Lightbox = Lightbox;

})(this, jQuery);
