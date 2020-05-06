/*global LightboxLoader:true, LightboxTracker, Geo, WikiaForm, wgTitle*/

(function (window, $) {
	'use strict';

	var Lightbox = {
		eventTimers: {
			lastMouseUpdated: 0
		},
		current: {
			type: '', // image or video
			title: '', // currently displayed file name
			carouselType: '', // articleMedia or videosModule
			index: -1, // ex: LightboxLoader.cache[Lightbox.current.carouselType][Lightbox.current.index]
			thumbs: [], // master list of thumbnails inside carousel; purged after closing the lightbox
			placeholderIdx: -1
		},
		carouselThumbWidth: 90,
		carouselThumbHeight: 55,
		// Modal vars
		openModal: false, // gets replaced with dom object of open modal
		shortScreen: false, // flag if the screen is shorter than LightboxLoader.lightboxSettings.height

		// Carousel vars
		// overlay for thumb images
		thumbPlayButton: '<span class="thumbnail-play-icon-container">' +
			'<svg class="thumbnail-play-icon" viewBox="0 0 180 180" width="100%" height="100%">' +
				'<g fill="none" fill-rule="evenodd">' +
					'<g opacity=".9" transform="rotate(90 75 90)">' +
						'<g fill="#000" filter="url(#a)"><rect id="b" width="150" height="150" rx="75"></rect></g>' +
						'<g fill="#FFF"><rect id="b" width="150" height="150" rx="75"></rect></g>' +
					'</g>' +
					'<path fill="#00D6D6" fill-rule="nonzero" d="M80.87 58.006l34.32 25.523c3.052 2.27 3.722 6.633 1.496 9.746a6.91 6.91 0 0 1-1.497 1.527l-34.32 25.523c-3.053 2.27-7.33 1.586-9.558-1.527A7.07 7.07 0 0 1 70 114.69V63.643c0-3.854 3.063-6.977 6.84-6.977 1.45 0 2.86.47 4.03 1.34z"></path>' +
				'</g>' +
			'</svg>' +
		'</span>',
		videoWrapperClass: 'video-thumbnail xxsmall',

		// Number of thumbs to load at a time.  Must be at least 9 (i.e. number of items in carousel)
		thumbLoadCount: 20,
		backfillCount: 0,
		backfillCountMessage: '',

		// timestamp for getting wiki images
		to: 0,

		makeLightbox: function (params) {
			var trackingObj, clickSource, trackingTitle;

			// Clear the statically-added blackout
			$('.lightbox-beforejs-blackout').remove();

			// Allow other extensions to react when a Lightbox is opened.  Used in FilePage
			$(window).trigger('lightboxOpened');

			// if we don't have latest photos in the DOM, request them from back end
			Lightbox.includeLatestPhotos = true;
			Lightbox.openModal = params.modal;

			// If file doesn't exist, show the error modal
			if (!Lightbox.initialFileDetail.exists) {
				Lightbox.showErrorModal();
				return;
			}

			trackingObj = this.getClickSource(params);

			Lightbox.current.key = params.key.toString(); // Added toString() for edge cases where titles are numbers

			Lightbox.current.carouselType = trackingObj.carouselType;

			// Set up tracking
			clickSource = trackingObj.clickSource;

			Lightbox.current.trackingCarouselType = trackingObj.trackingCarouselType;

			Lightbox.openModal.aggregateViewCount = 0;
			Lightbox.openModal.clickSource = clickSource;
			// This clicksource value will be sent to VideoBootstrap as opposed to Lightbox clicksource
			Lightbox.openModal.vbClickSource = clickSource;

			// Check screen height for future interactions
			Lightbox.shortScreen = ($(window).height() <
				LightboxLoader.lightboxSettings.height + LightboxLoader.lightboxSettings.topOffset + 20); // buffer by 20px

			// Add template to modal
			Lightbox.openModal.find('.modalContent').html(LightboxLoader.templateHtml);

			// cache re-used DOM elements and templates for this modal instance
			Lightbox.cacheDOM();

			// Set up carousel
			Lightbox.setUpCarousel();

			LightboxLoader.cache.details[Lightbox.current.title] = Lightbox.initialFileDetail;
			Lightbox.updateMedia();
			Lightbox.showOverlay();

			Lightbox.hideOverlay(3000);

			LightboxLoader.lightboxLoading = false;

			// tracking after lightbox has fully loaded
			trackingTitle = Lightbox.current.key;
			LightboxTracker.track(
				Wikia.Tracker.ACTIONS.IMPRESSION,
				'',
				Lightbox.current.placeholderIdx, {
					title: trackingTitle,
					'carousel-type': Lightbox.current.trackingCarouselType
				}
			);

			// attach event handlers
			Lightbox.bindEvents();

			if (Wikia.isTouchScreen()) {
				Lightbox.openModal.pin
					.click()
					.hide();
			}
		},
		cacheDOM: function () {
			// Template cache
			Lightbox.openModal.moreInfoTemplate = $('#LightboxMoreInfoTemplate');
			Lightbox.openModal.shareTemplate = $('#LightboxShareTemplate');
			Lightbox.openModal.progressTemplate = $('#LightboxCarouselProgressTemplate');
			Lightbox.openModal.headerTemplate = $('#LightboxHeaderTemplate');
			Lightbox.openModal.headerAdTemplate = $('#LightboxHeaderAdTemplate');
			Lightbox.openModal.pin = $('.LightboxCarousel .toolbar .pin');

			// Cache error message
			Lightbox.openModal.errorMessage = $('#LightboxErrorMessage').html();

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
		bindEvents: function () {
			Lightbox.openModal.on('mousemove.Lightbox', function (evt) {
				var time = new Date().getTime(),
					$target;
				if ((time - Lightbox.eventTimers.lastMouseUpdated) > 100) {
					Lightbox.eventTimers.lastMouseUpdated = time;
					$target = $(evt.target);
					Lightbox.showOverlay();
					if (!($target.closest('.LightboxHeader, .LightboxCarousel')).exists()) {
						Lightbox.hideOverlay();
					}
				}
			}).on('mouseleave.Lightbox', function () {
				// Hide Lightbox header and footer on mouse leave.
				Lightbox.hideOverlay(10);
			}).on('click.Lightbox', '.LightboxHeader .share-button', function (e) {
				e.preventDefault();

				// Show share screen on button click
				if (Lightbox.current.type === 'video') {
					Lightbox.video.destroyVideo();
				}
				Lightbox.openModal.addClass('share-mode');
				Lightbox.getShareCodes({
					fileTitle: Lightbox.current.key,
					articleTitle: wgTitle
				}, function (json) {
					Lightbox.openModal.share.append(Lightbox.openModal.shareTemplate.mustache(json))
						.find('input[type=text]').click(function () {
							$(this).select();
						})
						.filter('.share-input')
						.click();

					var trackingTitle = Lightbox.current.key;
					LightboxTracker.track(
						Wikia.Tracker.ACTIONS.CLICK,
						'lightboxShare',
						null, {
							title: trackingTitle,
							type: Lightbox.current.type
						}
					);

					Lightbox.setupShareEmail();

					Lightbox.openModal.share.find('.social-links').on('click', 'a', function () {
						var shareType = $(this).attr('class');
						LightboxTracker.track(
							Wikia.Tracker.ACTIONS.SHARE,
							shareType,
							null, {
								title: trackingTitle,
								type: Lightbox.current.type
							}
						);
					});

				});
			}).on('click.Lightbox', '.more-info-close', function () {
				// Close more info and share screens on button click
				if (Lightbox.current.type === 'video') {
					LightboxLoader.getMediaDetail({
						fileTitle: Lightbox.current.key
					}, Lightbox.video.renderVideo);
				}
				Lightbox.openModal.removeClass('share-mode').removeClass('more-info-mode');
				Lightbox.openModal.share.html('');
				Lightbox.openModal.moreInfo.html('');
			}).on('click.Lightbox', Lightbox.openModal.pin.selector, function (evt) {
				// Pin the toolbar on icon click
				var target = $(evt.target),
					overlayActive = Lightbox.openModal.data('overlayactive'),
					pinTitle;

				if (overlayActive) {
					pinTitle = target.data('pinned-title');
					// add active state to button when carousel overlay is active
					target.addClass('active').attr('title', pinTitle);
					Lightbox.openModal.addClass('pinned-mode');
				} else {
					pinTitle = target.data('pin-title');
					target.removeClass('active').attr('title', pinTitle);
					Lightbox.openModal.removeClass('pinned-mode');
				}
				Lightbox.openModal.data('overlayactive', !overlayActive); // flip overlayactive state

				// update image if image
				if (Lightbox.current.type === 'image') {
					Lightbox.updateMedia();
				}
			}).on('click.Lightbox', '#LightboxNext, #LightboxPrevious', function (e) {
				var target = $(e.target);

				if (target.is('.disabled')) {
					return;
				}

				if (target.is('#LightboxNext')) {
					Lightbox.current.index++;
					// Don't stop on placeholder
					if (Lightbox.current.index === Lightbox.current.placeholderIdx) {
						Lightbox.current.index++;
					}
				} else {
					Lightbox.current.index--;
					// Don't stop on placeholder
					if (Lightbox.current.index === Lightbox.current.placeholderIdx) {
						Lightbox.current.index--;
					}
				}

				Lightbox.openModal.find('.carousel li').eq(Lightbox.current.index).trigger('click');
			}).on('click.Lightbox', '.article-add-button', function () {
				Lightbox.doAutocomplete($(this));
			});
		},
		doAutocomplete: function (elem) {
			$.when(
				$.loadJQueryAutocomplete()
			).then($.proxy(function () {
				var input = elem.hide().next('input').show();

				input.autocomplete({
					serviceUrl: window.wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
					onSelect: function (value, data, event) {
						var valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
							// slashes can't be urlencoded because they break routing
							location = window.wgArticlePath
								.replace(/\$1/, valueEncoded)
								.replace(encodeURIComponent('/'), '/');

						location = location + '?action=edit&addFile=' + Lightbox.current.key;

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
					// BugId:4625 - always send the request even if previous one returned no suggestions
					skipBadQueries: true
				});
			}, this));

		},
		clearTrackingTimeouts: function () {
			// Clear video tracking timeout
			clearTimeout(Lightbox.video.trackingTimeout);
			// Clear image tracking
			clearTimeout(Lightbox.image.trackingTimeout);
		},
		//  method for removing class and inline styles applied to the lightbox by Lightbox.error.updateLightbox
		clearErrorMessageStyling: function () {
			this.openModal.media.removeClass('error-lightbox').attr('style', 'line-height: normal;');
		},
		image: {
			trackingTimeout: false,
			updateLightbox: function (data) {
				Lightbox.image.getDimensions(data.imageUrl, function (dimensions) {

					// render media
					data.imageHeight = dimensions.imageHeight;

					var css = {
							height: dimensions.modalHeight
						},
						// extract mustache templates
						photoTemplate = Lightbox.openModal.find('#LightboxPhotoTemplate'),
						renderedResult = photoTemplate.mustache(data),
						// prevent race conditions from timeout
						trackingTitle = Lightbox.current.key;

					// don't change top offset if the screen is shorter than the min modal height
					if (!Lightbox.shortScreen) {
						css.top = dimensions.topOffset;
					}

					Lightbox.openModal.css(css);

					// Hack to vertically align the image in the lightbox
					Lightbox.openModal.media
						.removeClass('video-media')
						.css({
							'margin-top': '',
							// -3 hack to remove white line in chrome
							'line-height': (dimensions.imageContainerHeight - 3) + 'px'
						}).html(renderedResult);

					Lightbox.openModal.media.find('img').first().load(function () {
						// firefox image loading hack (BugId:32477)
						$(window).trigger('resize');
					});

					Lightbox.updateArrows();

					Lightbox.updateUrlState();

					Lightbox.renderHeader();

					Lightbox.updateMediaType();

					Lightbox.clearTrackingTimeouts();

					Lightbox.image.trackingTimeout = setTimeout(function () {
						Lightbox.openModal.aggregateViewCount++;
						LightboxTracker.track(
							Wikia.Tracker.ACTIONS.VIEW,
							'image',
							Lightbox.openModal.aggregateViewCount, {
								title: trackingTitle,
								clickSource: Lightbox.openModal.clickSource,
								'carousel-type': Lightbox.current.trackingCarouselType
							}
						);

						// Set all future click sources to Lightbox rather than DOM element
						Lightbox.openModal.clickSource = LightboxTracker.clickSource.LB;
						Lightbox.openModal.vbClickSource = LightboxTracker.clickSource.LB;
					}, 500);

				});

			},
			getDimensions: function (imageUrl, callback) {
				// Get image url from json - preload image
				// TODO: cache image dimensions so we don't have to preload the image again
				var image = $('<img id="LightboxPreload" src="' + imageUrl + '" />').appendTo('body');

				// Do calculations
				image
					.error(function () {
						Lightbox.error.updateLightbox();
					})
					.load(function () {
						var image = $(this),
							topOffset = LightboxLoader.lightboxSettings.topOffset,
							modalMinHeight = LightboxLoader.lightboxSettings.height,
							windowHeight = $(window).height(),
							modalHeight = windowHeight - topOffset * 2,
							currentModalHeight = Lightbox.openModal.height(),
							imageHeight = image.height(),
							imageContainerHeight,
							extraHeight,
							newOffset,
							dimensions;

						modalHeight = modalHeight < modalMinHeight ? modalMinHeight : modalHeight;

						// Just in case image is wider than 1000px
						if (image.width() > 1000) {
							image.width(1000);
						}

						if (imageHeight < modalHeight) {
							// Image is shorter than screen, adjust modal height
							modalHeight = imageHeight;

							// Modal has a min height
							if (modalHeight < modalMinHeight) {
								modalHeight = modalMinHeight;
							}

							// Calculate modal's top offset
							extraHeight = windowHeight - modalHeight - 10; // 5px modal border
							newOffset = (extraHeight / 2);
							if (newOffset < topOffset) {
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

						imageContainerHeight = modalHeight;
						if (Lightbox.openModal.hasClass('pinned-mode')) {
							imageContainerHeight -= 190;
							if (imageHeight > imageContainerHeight) {
								imageHeight = imageContainerHeight;
							}
						}

						dimensions = {
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
			renderVideo: function (data) {
				Lightbox.openModal.media
					.addClass('video-media')
					.css('line-height', 'normal');

				require(['wikia.videoBootstrap'], function (VideoBootstrap) {
					LightboxLoader.videoInstance = new VideoBootstrap(
						Lightbox.openModal.media[0],
						data.videoEmbedCode,
						Lightbox.openModal.vbClickSource
					);
					Lightbox.openModal.vbClickSource = LightboxTracker.clickSource.LB;
				});
			},
			destroyVideo: function () {
				Lightbox.openModal.media.html('');
			},
			updateLightbox: function (data) {
				var height = LightboxLoader.lightboxSettings.height;
				if (data.extraHeight) {
					height += data.extraHeight;
				}

				// Set lightbox css
				var css = {
						height: height
					},
					// prevent race conditions from timeout
					trackingTitle = Lightbox.current.key;

				// don't change top offset if the screen is shorter than the min modal height
				if (!Lightbox.shortScreen) {
					css.top = Lightbox.getDefaultTopOffset();
				}

				// Resize modal
				Lightbox.openModal.css(css);

				Lightbox.video.renderVideo(data);

				Lightbox.updateArrows();

				Lightbox.updateUrlState();

				Lightbox.renderHeader();

				Lightbox.updateMediaType();

				Lightbox.clearTrackingTimeouts();

				/* Since we don't have an 'onload' event for video views,
				 * we're setting a timeout before counting a video as viewed.
				 * Below are the dates this timeout has been in effect.
				 *
				 * 7/27/12 - 8/21/12: 5000ms (5s)
				 * 8/21/12 - 2/13/13: 1000ms (1s)
				 * 2/13/13 - present: 3000ms (3s)
				 */
				Lightbox.video.trackingTimeout = setTimeout(function () {
					Lightbox.openModal.aggregateViewCount++;
					LightboxTracker.track(
						Wikia.Tracker.ACTIONS.VIEW,
						'video',
						Lightbox.openModal.aggregateViewCount, {
							title: trackingTitle,
							provider: data.providerName,
							clickSource: Lightbox.openModal.clickSource,
							'carousel-type': Lightbox.current.trackingCarouselType
						}
					);

					// Set all future click sources to Lightbox rather than DOM element
					Lightbox.openModal.clickSource = LightboxTracker.clickSource.LB;
				}, 3000);

			}
		},
		error: {
			updateLightbox: function () {
				// Set lightbox css
				var css = {
					height: LightboxLoader.lightboxSettings.height
				};

				// don't change top offset if the screen is shorter than the min modal height
				if (!Lightbox.shortScreen) {
					css.top = Lightbox.getDefaultTopOffset();
				}

				// Resize modal
				Lightbox.openModal.css(css);

				// Empty header html
				Lightbox.openModal.header
					.html('')
					.prepend($(Lightbox.openModal.closeButton).clone(true, true)); // clone close button into header

				// Display error message
				Lightbox.openModal.media
					.css({
						'margin-top': (LightboxLoader.lightboxSettings.height / 2) - 14,
						'line-height': 'normal'
					})
					.addClass('error-lightbox')
					.html(Lightbox.openModal.errorMessage);

				// remove '?file=' from URL
				Lightbox.updateUrlState(true);
			}
		},
		updateMediaType: function () {

			if (Lightbox.current.type === 'video') {
				Lightbox.openModal.addClass('video-lightbox');
				Lightbox.openModal.removeClass('image-lightbox');
			} else {
				Lightbox.openModal.removeClass('video-lightbox');
				Lightbox.openModal.addClass('image-lightbox');
			}
		},
		getDefaultTopOffset: function () {
			var modalHeight = LightboxLoader.lightboxSettings.height,
				windowHeight = $(window).height(),
				topOffset = (windowHeight - modalHeight - 10) / 2;

			return topOffset + $(window).scrollTop();

		},
		restyleImageInfo: function() {
			$('.more-info-container .banner img').each(function (index) {
				$(this).removeAttr('class');
				$(this).removeAttr('style');
				$(this).removeAttr('id');
				$(this).addClass('more-info-image')
			});
			$('.more-info-container').each(function (index) {
				$(this).find('*').not('.more-info-image').each(function (index) {
					if ($(this).css('display') === 'none') {
						$(this).remove();
					} else {
						$(this).removeAttr('class');
						$(this).removeAttr('style');
						$(this).removeAttr('id');
					}
				});
			});
		},
		renderHeader: function () {
			var headerTemplate = Lightbox.openModal.headerTemplate;
			LightboxLoader.getMediaDetail({
				fileTitle: Lightbox.current.key
			}, function (json) {
				var renderedResult = headerTemplate.mustache(json);
				Lightbox.openModal.header
					.html(renderedResult)
					.prepend($(Lightbox.openModal.closeButton).clone(true, true)); // clone close button into header
				Lightbox.restyleImageInfo();
			});
		},
		showOverlay: function () {
			clearTimeout(Lightbox.eventTimers.overlay);
			var overlay = Lightbox.openModal;
			if (overlay.hasClass('overlay-hidden') && overlay.data('overlayactive')) {
				overlay.removeClass('overlay-hidden');
			}
		},
		hideOverlay: function (delay) {
			var overlay = Lightbox.openModal;

			// Don't enable hover show/hide for touch screens
			if (Wikia.isTouchScreen()) {
				return;
			}

			if (!overlay.hasClass('overlay-hidden') && overlay.data('overlayactive')) {
				clearTimeout(Lightbox.eventTimers.overlay);
				Lightbox.eventTimers.overlay = setTimeout(
					function () {
						overlay.addClass('overlay-hidden');
					}, (delay || 1200)
				);
			}
		},
		updateMedia: function () {
			var key = Lightbox.current.key,
				type = Lightbox.current.type;

			Lightbox.openModal.media.html('').startThrobbing();

			// If a video uses a timeout for tracking, clear it
			if (LightboxLoader.videoInstance) {
				LightboxLoader.videoInstance.clearTimeoutTrack();
			}

			LightboxLoader.getMediaDetail({
				fileTitle: key,
				type: type
			}, function (data) {
				if (data.exists === false) {
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
		updateArrows: function () {
			var mediaArr = Lightbox.current.thumbs,
				idx = Lightbox.current.index,
				next = $('#LightboxNext'),
				previous = $('#LightboxPrevious');

			if (mediaArr.length < 2) {
				next.addClass('disabled');
				previous.addClass('disabled');
			} else if (idx === (mediaArr.length - 1)) {
				next.addClass('disabled');
				previous.removeClass('disabled');
			} else if (idx === 0) {
				previous.addClass('disabled');
				next.removeClass('disabled');
			} else {
				previous.removeClass('disabled');
				next.removeClass('disabled');
			}
		},

		// Handle history API
		updateUrlState: function (clear) {
			var self = this;
			require(['wikia.history'], function (history) {
				var queryString = window.Wikia.Querystring();

				if (clear) {
					queryString.removeVal('file');
				} else {
					queryString.setVal('file', self.current.key, true);
				}
				history.replaceState(null, null, queryString);
			});
		},

		getShareCodes: function (mediaParams, callback) {
			var title = mediaParams.fileTitle;
			if (LightboxLoader.cache.share[title]) {
				callback(LightboxLoader.cache.share[title]);
			} else {
				$.nirvana.sendRequest({
					controller: 'Lightbox',
					method: 'getShareCodes',
					type: 'GET',
					format: 'json',
					data: mediaParams,
					callback: function (json) {
						LightboxLoader.cache.share[title] = json;
						callback(json);
					}
				});
			}
		},
		// order by priority position in carousel backfill
		carouselTypes: [
			'videosModule',
			'articleMedia'
		],
		setUpCarousel: function () {
			// Load backfill content from DOM
			var types = Lightbox.carouselTypes,
				deferredList = [],
				itemsShown = 9,
				i,
				type,
				deferredInfo,
				itemClick,
				trackBackfillProgress,
				trackOriginalProgress,
				trackProgressCallback,
				beforeMove,
				afterMove;

			// cache carousel template
			Lightbox.openModal.carouselTemplate = $('#LightboxCarouselThumbs');
			Lightbox.openModal.carouselContainer = $('#LightboxCarouselContainer');

			// get thumbs and attach carousel
			Lightbox.getMediaThumbs[Lightbox.current.carouselType](false);

			// Set up placeholder thumb index but don't insert it till we have collected all thumbs
			Lightbox.current.placeholderIdx = Lightbox.current.thumbs.length;
			Lightbox.current.thumbs.push({});

			for (i = 0; i < types.length; i++) {
				type = types[i];
				if (type !== Lightbox.current.carouselType) {
					Lightbox.getMediaThumbs[type](true);
				}
			}

			// Add total wiki photos to backfill count
			if (Lightbox.backfillCountMessage === '') {
				deferredInfo = $.Deferred();
				$.nirvana.sendRequest({
					controller: 'Lightbox',
					method: 'getTotalWikiImages',
					type: 'GET',
					format: 'json',
					data: {
						count: Lightbox.backfillCount,
						inclusive: Lightbox.includeLatestPhotos
					},
					callback: function (json) {
						Lightbox.to = LightboxLoader.cache.to = json.to;
						Lightbox.backfillCount += json.totalWikiImages;
						Lightbox.backfillCountMessage = json.msg;
						deferredInfo.resolve();
					}
				});

				deferredList.push(deferredInfo);
			}

			// Set current carousel index
			Lightbox.setCarouselIndex();

			// Cache progress template
			Lightbox.openModal.progress = $('#LightboxCarouselProgress');
			Lightbox.openModal.data('overlayactive', true);

			$(document).off('keydown.Lightbox')
				.on('keydown.Lightbox', function (e) {
					if (e.keyCode === 37) {
						e.preventDefault();
						$('#LightboxPrevious').click();
					} else if (e.keyCode === 39) {
						e.preventDefault();
						$('#LightboxNext').click();
					}
				});

			// Pass control functions to jquery.wikia.carousel.js
			itemClick = function () {
				var $this = $(this),
					idx,
					mediaArr,
					key;

				// If the clicked item is disabled, treat it as the next item in the batch
				if ($this.hasClass('disabled')) {
					$this.next().click();
					return;
				}

				idx = $this.index();
				mediaArr = Lightbox.current.thumbs;

				Lightbox.current.index = idx;
				if (idx > -1 && idx < mediaArr.length) {
					key = mediaArr[idx].key;
					if (!key) {
						key = mediaArr[idx].title.replace(/ /g, '_');
					}
					Lightbox.current.key = key.toString(); // Added toString() for edge cases where titles are numbers
					Lightbox.current.type = mediaArr[idx].type;
				}

				Lightbox.updateMedia();
			};

			trackBackfillProgress = function (idx1, idx2) {
				var originalCount = LightboxLoader.cache[Lightbox.current.carouselType].length;

				idx1 = idx1 - originalCount - 1;
				// (BugId:38546) Don't count placeholder thumb when it is first in the row
				if (idx1 === 0) {
					idx1 = 1;
				}
				idx2 = idx2 - originalCount - 1;

				return {
					idx1: idx1,
					idx2: idx2,
					total: Lightbox.backfillCountMessage
				};
			};

			trackOriginalProgress = function (idx1, idx2) {
				var originalCount = LightboxLoader.cache[Lightbox.current.carouselType].length;

				idx2 = Math.min(idx2, originalCount);

				return {
					idx1: idx1,
					idx2: idx2,
					total: originalCount
				};
			};

			trackProgressCallback = function (idx1, idx2) {
				var template = Lightbox.openModal.progressTemplate,
					progress,
					html,
					$firstThumb = Lightbox.openModal.carousel.find('li').eq(idx1);

				// Track progress based on if we're in backfill content or original content
				if ($firstThumb.data('backfill') === 'true') {
					progress = trackBackfillProgress(idx1, idx2);
				} else {
					progress = trackOriginalProgress(idx1, idx2);
				}

				html = template.mustache(progress);
				Lightbox.openModal.progress.html(html);
			};

			afterMove = function (idx) {
				// if we're close to the end, load more thumbnails
				if (Lightbox.current.thumbs.length - idx < Lightbox.thumbLoadCount) {
					Lightbox.getMediaThumbs.wikiPhotos();
				}
			};

			// Make sure we have our i18n message before initializing the carousel plugin
			$.when.apply(this, deferredList).done(function () {
				var placeholder;

				// add more thumbs to carousel if we need them
				if (Lightbox.current.thumbs.length < Lightbox.thumbLoadCount) {
					// asynchronous
					Lightbox.getMediaThumbs.wikiPhotos(); // uses Lightbox.to which is recieved in promise pattern
				}

				// Do insert of placeholder thumb now that we know the number of backfill items
				placeholder = $('#LightboxCarouselMore').mustache({
					text: Lightbox.backfillCountMessage
				});
				Lightbox.openModal.carousel
					.find('li')
					.eq(Lightbox.current.placeholderIdx - 1)
					.after(placeholder);

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

		setCarouselIndex: function () {
			for (var i = 0; i < Lightbox.current.thumbs.length; i++) {
				if (Lightbox.current.thumbs[i].key === Lightbox.current.key) {
					Lightbox.current.index = i;
					break;
				}
			}
		},

		setupShareEmail: function () {
			var shareEmailForm = $('#shareEmailForm'),
				wikiaForm = new WikiaForm(shareEmailForm),
				inputGroups = shareEmailForm.find('.general-errors, .general-success');

			function doShareEmail(address) {
				// Only main namespace or category pages can be shared; otherwise, share the file
				var namespace = mw.config.get('wgNamespaceNumber'),
					isArticleValidShareTarget = namespace === 0 || namespace === 14,
					shareTarget = isArticleValidShareTarget ? mw.config.get('wgTitle') : Lightbox.current.key,
					shareNamespace = isArticleValidShareTarget ? namespace : 6; // NS_FILE

				$.nirvana.sendRequest({
					controller: 'Lightbox',
					method: 'shareFileMail',
					type: 'POST',
					data: {
						type: Lightbox.current.type,
						fileName: Lightbox.current.key,
						address: address,
						shareTarget: shareTarget,
						shareNamespace: shareNamespace,
					},
					callback: function (data) {
						var errorMsg = '',
							successMsg = '',
							// prevent race conditions from timeout
							trackingTitle = Lightbox.current.key;

						wikiaForm.clearGenericError(inputGroups);
						wikiaForm.clearGenericSuccess(inputGroups);

						if (data.errors.length) {
							$(data.errors).each(function () {
								errorMsg += this.toString();
							});
						}
						if (data.sent.length) {
							successMsg += 'Email sent to ' + data.sent.join() + '. ';
						}

						if (errorMsg.length) {
							wikiaForm.showGenericError(errorMsg);
						}
						if (successMsg.length) {
							wikiaForm.showGenericSuccess(successMsg);
						}
						shareEmailForm.find('input[type=text]').val('');

						LightboxTracker.track(
							Wikia.Tracker.ACTIONS.SHARE,
							'email',
							null,
							{
								title: trackingTitle,
								type: Lightbox.current.type
							}
						);
					}
				});
			}

			shareEmailForm.submit(function (e) {
				var address = $(this).find('input').first().val();

				e.preventDefault();

				// make sure user is logged in
				if (window.wgUserName) {
					doShareEmail(address);
				} else {
					window.wikiaAuthModal.load({
						forceLogin: true,
						origin: 'image-lightbox',
						onAuthSuccess: function () {
							doShareEmail(address);
							// see VID-473 - Reload page on lightbox close
							LightboxLoader.reloadOnClose = true;
						}
					});
				}
			});
		},
		// Show this modal when ?file=xyz and xyz doesn't exist - mainly used for sharing and direct links
		showErrorModal: function () {
			LightboxLoader.lightboxLoading = false;

			Lightbox.openModal.closeModal();

			$.nirvana.sendRequest({
				controller: 'Lightbox',
				method: 'lightboxModalContentError',
				type: 'GET',
				format: 'html',
				data: {
					lightboxVersion: window.wgStyleVersion,
					userLang: window.wgUserLanguage // just in case user changes language prefs
				},
				callback: function (html) {
					$(html).makeModal({
						width: 600
					});
				}
			});
		},
		getMediaThumbs: {
			backfilling: false,
			// Get article images/videos from DOM
			articleMedia: function (backfill) {
				var cached = LightboxLoader.cache.articleMedia,
					thumbArr = [],
					article,
					keys,
					thumbs;

				if (cached.length) {
					thumbArr = cached;
				} else {
					article = $('#WikiaArticle, #WikiaArticleComments');
					// array to check for title dupes
					keys = [];
					// Collect images from DOM
					thumbs = article.find('img[data-image-name], img[data-video-name]');

					if (!thumbs.length) {
						thumbs = article.find('.image, .lightbox').find('img').add(article.find('.thumbimage'));
					}

					// cache keys for dupe checking later
					$.each(thumbArr, function () {
						keys.push(this.key);
					});

					thumbs.each(function () {
						var $thisThumb = $(this),
							type,
							title,
							key,
							playButtonSpan,
							videoName;

						if ($thisThumb.closest('.ogg_player').length) {
							return;
						}

						videoName = $thisThumb.attr('data-video-name') || $thisThumb.parent().attr('data-video-name');

						if (videoName) {
							type = 'video';
							title = videoName;
							key = $thisThumb.attr('data-video-key');
							playButtonSpan = Lightbox.thumbPlayButton;
						} else {
							type = 'image';
							title = $thisThumb.attr('data-image-name') || $thisThumb.parent().attr('data-image-name');
							key = $thisThumb.attr('data-image-key');
							playButtonSpan = '';
						}

						if (!key) {
							key = title && title.replace(/ /g, '_');
						}

						if (key) {
							// Check for dupes
							if ($.inArray(key, keys) > -1) {
								return true;
							}
							keys.push(key);

							thumbArr.push({
								thumbUrl: Lightbox.thumbParams($thisThumb.data('src') || $thisThumb.attr('src'), type),
								title: title,
								key: key,
								type: type,
								playButtonSpan: playButtonSpan,
								thumbWrapperClass: (type === 'video') ? Lightbox.videoWrapperClass : ''
							});
						}
					});

					// Fill articleMedia cache
					LightboxLoader.cache.articleMedia = thumbArr;

					// Count backfill items for progress bar
					if (backfill) {
						Lightbox.backfillCount += thumbArr.length;
					}

				}

				// Add thumbs to current lightbox cache
				Lightbox.current.thumbs = Lightbox.current.thumbs.concat(thumbArr);

				Lightbox.addThumbsToCarousel(thumbArr, backfill);
			},
			// Get the rest of the photos from the wiki
			wikiPhotos: function () {
				if (Lightbox.getMediaThumbs.backfilling || !Lightbox.to) {
					return;
				}
				Lightbox.getMediaThumbs.backfilling = true;

				$.nirvana.sendRequest({
					controller: 'Lightbox',
					method: 'getThumbImages',
					type: 'GET',
					format: 'json',
					data: {
						to: Lightbox.to,
						count: 30,
						inclusive: Lightbox.includeLatestPhotos
					},
					callback: function (json) {
						Lightbox.to = json.to;
						if (!Lightbox.to) {
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
			},
			videosModule: function (backfill) {
				var cached = LightboxLoader.cache.videosModule,
					thumbArr = [],
					videosModule,
					// array to check for title dupes
					keys = [],
					thumbs;

				if (cached.length) {
					thumbArr = cached;
				} else {
					videosModule = $('#videosModule');
					// Collect images from DOM
					thumbs = videosModule.find('img[data-video-name]');

					thumbs.each(function () {
						var $thisThumb = $(this),
							type = 'video',
							title = $thisThumb.attr('data-video-name'),
							key = $thisThumb.attr('data-video-key');

						if (key) {
							// Check for dupes
							if ($.inArray(key, keys) > -1) {
								return;
							}
							keys.push(key);

							thumbArr.push({
								thumbUrl: Lightbox.thumbParams($thisThumb.data('src') || $thisThumb.attr('src'), type),
								title: title,
								key: key,
								type: type,
								playButtonSpan: Lightbox.thumbPlayButton,
								thumbWrapperClass: Lightbox.videoWrapperClass
							});
						}
					});

					// Fill articleMedia cache
					LightboxLoader.cache.videosModule = thumbArr;

					// Count backfill items for progress bar
					if (backfill) {
						Lightbox.backfillCount += thumbArr.length;
					}

				}

				// Add thumbs to current lightbox cache
				Lightbox.current.thumbs = Lightbox.current.thumbs.concat(thumbArr);
				Lightbox.addThumbsToCarousel(thumbArr, backfill);
			}
		},
		addThumbsToCarousel: function (thumbs, backfill) {
			var carouselThumbs,
				container = Lightbox.openModal.carouselContainer;

			// render carousel
			carouselThumbs = Lightbox.openModal.carouselTemplate.mustache({
				backfill: backfill,
				thumbs: thumbs
			});

			Lightbox.openModal.carousel.append(carouselThumbs);

			// if carousel is already instantiated, update settings with added thumbnails
			if (typeof container.updateCarouselItems === 'function') {
				container.updateCarouselItems();
				container.updateCarouselWidth();
				container.updateCarouselArrows();
			}
		},

		thumbParams: function (url, type) {
			//Get URL to a proper thumbnail
			return Wikia.Thumbnailer.getThumbURL(url, type, Lightbox.carouselThumbWidth, Lightbox.carouselThumbHeight);
		},

		/**
		 * @param {Object} params Object containing any combination of 'parent' (required),
		 * 'target' (optional), or 'clickSource' (optional)
		 */
		getClickSource: function (params) {
			var parent = params.parent,
				target = params.target,
				clickSource = params.clickSource,
				id = parent.attr('id'),
				VPS = LightboxTracker.clickSource,

				// Two vars that basically mean the same thing but are here for legacy purposes
				carouselType = '',
				trackingCarouselType = '';

			switch (id) {
				// Embeded in Article Comments
				case 'WikiaArticleComments':
					clickSource = clickSource || VPS.EMBED;

					carouselType = 'articleMedia';
					trackingCarouselType = 'article';
					break;

				case 'videosModule':
					clickSource = clickSource || VPS.VIDEOS_MODULE_RAIL;

					carouselType = 'videosModule';
					trackingCarouselType = 'videos-module';
					break;

				// Video Home Page
				case 'latest-videos-wrapper':
					clickSource = VPS.VIDEO_HOME_PAGE;
					carouselType = 'articleMedia';
					trackingCarouselType = 'article';
					break;

				case 'WikiaArticle':
					// Lightbox doesn't care what kind of article page, but clickSource tracking does
					carouselType = 'articleMedia';
					trackingCarouselType = 'article';

					if (typeof clickSource !== 'undefined') {
						// Click source is already set so we don't have to look for it.
						break;
					}

					// Hubs
					if (window.wgWikiaHubType) {
						clickSource = VPS.HUBS;
						break;
					}

					// Search
					if (target.closest('.Search').length) {
						clickSource = VPS.SEARCH;
						break;
					}

					// Special:Videos
					if (target.closest('.VideoGrid').length) {
						clickSource = VPS.SV;
						break;
					}

					// WikiActivity
					if (target.closest('#wikiactivity-main').length) {
						clickSource = VPS.OTHER;
						break;
					}

					// Embeded in an article
					clickSource = VPS.EMBED;
					break;

				default:
					clickSource = VPS.OTHER;

					carouselType = 'articleMedia';
					trackingCarouselType = 'article';
			}

			return {
				clickSource: clickSource,
				carouselType: carouselType,
				trackingCarouselType: trackingCarouselType
			};
		}
	};

	window.Lightbox = Lightbox;

})(window, jQuery);
