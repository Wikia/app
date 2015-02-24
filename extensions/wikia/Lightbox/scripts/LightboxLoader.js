/*global Lightbox:true */

(function (window, $) {
	'use strict';

	var LightboxLoader, LightboxTracker, bucky;

	LightboxLoader = {
		// cached thumbnail arrays and detailed info
		cache: {
			articleMedia: [], // Article Media
			wikiPhotos: [], // Back fill of photos from wiki
			videosModule: [],
			details: {}, // all media details
			share: {},
			to: 0
		},
		inlineVideoLinks: $(), // jquery array of inline video links
		lightboxLoading: false,
		inlineVideoLoading: [],
		videoInstance: null,
		pageAds: $('#TOP_RIGHT_BOXAD'), // if more ads start showing up over lightbox, add them here
		reloadOnClose: false, // Means to reload the page on closing the lightbox - see VID-473
		lightboxSettings: {
			// start with default modal options
			id: 'LightboxModal',
			className: 'LightboxModal',
			width: 970, // modal adds 40px of padding to width in case of oasis skin
			noHeadline: true,
			topOffset: 25,
			height: 628,
			videoHeight: 360,
			onClose: function () {
				// Reset lightbox
				$(window).off('.Lightbox');
				// bugid-64334 and bugid-69047
				Lightbox.openModal.find('.video-media').children().remove();
				LightboxLoader.lightboxLoading = false;
				// Update history api (remove '?file=' from URL)
				Lightbox.updateUrlState(true);
				// Reset carousel
				Lightbox.current.thumbs = [];
				Lightbox.current.thumbTypesAdded = [];
				Lightbox.to = LightboxLoader.cache.to;
				// Reset Ad Flags
				Lightbox.ads.adMediaProgress = [];
				Lightbox.ads.adMediaShown = 0;
				Lightbox.ads.adMediaShownSinceLastAd = 0;
				Lightbox.ads.adIsShowing = false;
				// Re-show box ad
				LightboxLoader.pageAds.css('visibility', 'visible');
				// Reset tracking
				Lightbox.clearTrackingTimeouts();
				// If a video uses a timeout for tracking, clear it
				if (LightboxLoader.videoInstance) {
					LightboxLoader.videoInstance.clearTimeoutTrack();
				}
				if (LightboxLoader.reloadOnClose) {
					window.location.reload();
				}
			}
		},
		videoThumbWidthThreshold: 400,
		init: function (customSettings) {
			var self = this,
				$article, $comments, $footer, $videosModule, $videoHomePage, $recommendations;

			// performance profiling
			bucky = window.Bucky('LightboxLoader');

			bucky.timer.start('init');

			$article = $('#WikiaArticle');
			$comments = $('#WikiaArticleComments'); // event handled with $footer
			$footer = $('#WikiaArticleFooter'); // bottom videos module
			$videosModule = $('.videos-module-rail'); // right rail videos module
			$videoHomePage = $('#latest-videos-wrapper');
			$recommendations = $('#recommendations');

			$.extend(self.lightboxSettings, customSettings);

			// Bind click event to initiate lightbox
			$article.add($footer).add($videosModule).add($recommendations)
				.off('.lightbox')
				.on('click.lightbox', '.lightbox, a.image', function (e) {
					var $this = $(this),
						$thumb = $this.find('img').first(),
						fileKey = $thumb.attr('data-image-key') || $thumb.attr('data-video-key'),
						$parent,
						isVideo,
						trackingInfo,
						$slideshowImg,
						clickSource;

					if (!LightboxLoader.hasLightbox($this, $thumb, e)) {
						return;
					}

					e.preventDefault();

					if ($this.closest($videoHomePage).length) {
						$parent = $videoHomePage;
					} else if ($this.closest($article).length) {
						$parent = $article;
					} else if ($this.closest($comments).length) {
						$parent = $comments;
					} else if ($this.closest($recommendations).length) {
						$parent = $recommendations;
					} else if ($this.closest('#videosModule').length) {
						// Don't use cached object because it may not have been in the DOM on init
						$parent = $('#videosModule');
					}

					trackingInfo = {
						target: $this,
						parent: $parent
					};

					// Handle edge cases

					// TODO: refactor wikia slideshow
					if ($this.hasClass('wikia-slideshow-popout')) {
						$slideshowImg = $this.parents('.wikia-slideshow-toolbar')
							.siblings('.wikia-slideshow-images-wrapper')
							.find('li:visible')
							.find('img')
							.first();
						fileKey = $slideshowImg.attr('data-image-name') || $slideshowImg.attr('data-video-name');
					}

					if (!fileKey) {
						// might be old/cached DOM.  TODO: delete this when cache is flushed
						fileKey = $this.attr('data-image-name') || $this.attr('data-video-name');
						fileKey = fileKey ? fileKey.replace(/ /g, '_') : fileKey;
					}

					if (!fileKey) {
						Wikia.log('No file key found on this image or video', 3, 'LightboxLoader');
						return;
					}

					// Display video inline, don't open lightbox
					isVideo = $this.children('.play-circle').length;
					if (
						isVideo &&
						$thumb.width() >= self.videoThumbWidthThreshold &&
						!$this.hasClass('force-lightbox')
					) {
						clickSource = window.wgWikiaHubType ?
							LightboxTracker.clickSource.HUBS :
							LightboxTracker.clickSource.EMBED;
						LightboxLoader.displayInlineVideo($this, $thumb, fileKey, clickSource);
						return;
					}

					self.loadLightbox(fileKey, trackingInfo);

				});

			// TODO: refactor wikia slideshow (BugId:43483)
			$article
				.off('.slideshowLightbox')
				.on(
					'click.slideshowLightbox',
					'.wikia-slideshow-images .thumbimage, .wikia-slideshow-images .wikia-slideshow-image',
					function (e) {
						var $this = $(this);
						if (LightboxLoader.hasLightbox($this, null, e)) {
							e.preventDefault();
							$this.closest('.wikia-slideshow-wrapper').find('.wikia-slideshow-popout').click();
						}
					}
				);
			bucky.timer.stop('init');

			// wait till end of execution stack to load lightbox
			setTimeout(LightboxLoader.loadFromURL, 0);
		},

		/**
		 * @param {String} mediaTitle The name of the file to be loaded in the Lightbox
		 * @param {Object} trackingInfo Any info we've already gathered for tracking purposes.
		 * Will be fed to Lightbox.getClickSource for processing
		 */
		loadLightbox: function (mediaTitle, trackingInfo) {
			var openModal, lightboxParams, deferredList, resources, deferredTemplate;

			bucky.timer.start('loadLightbox');

			// restore inline videos to default state, because flash players overlaps with modal
			LightboxLoader.removeInlineVideos();
			LightboxLoader.lightboxLoading = true;

			// Hide box ad so there's no z-index issues
			LightboxLoader.pageAds.css('visibility', 'hidden');

			// Display modal with default dimensions
			openModal = $('<div>').makeModal(LightboxLoader.lightboxSettings);
			openModal.find('.modalContent').startThrobbing();

			lightboxParams = {
				key: mediaTitle,
				modal: openModal
			};

			$.extend(lightboxParams, trackingInfo);

			deferredList = [];
			if (!LightboxLoader.assetsLoaded) {
				deferredList.push($.loadMustache());

				resources = [
					$.getSassCommonURL('/extensions/wikia/Lightbox/styles/Lightbox.scss'),
					window.wgExtensionsPath + '/wikia/Lightbox/scripts/Lightbox.js'
				];

				deferredList.push($.getResources(resources));

				deferredTemplate = $.Deferred();
				$.nirvana.sendRequest({
					controller: 'Lightbox',
					method: 'lightboxModalContent',
					type: 'GET',
					format: 'html',
					data: {
						lightboxVersion: window.wgStyleVersion,
						userLang: window.wgUserLanguage // just in case user changes language prefs
					},
					callback: function (html) {
						LightboxLoader.templateHtml = html;
						deferredTemplate.resolve();
					}
				});

				deferredList.push(deferredTemplate);
			}

			// NOTE: be careful with this, look below where it says LASTINDEX
			deferredList.push(LightboxLoader.getMediaDetailDeferred({
				fileTitle: mediaTitle
			}));

			$.when.apply(this, deferredList).done(function () {
				LightboxLoader.assetsLoaded = true;
				// LASTINDEX: index is last-index due to how deferred resolve works in mulitiple deferred objects
				Lightbox.initialFileDetail = arguments[arguments.length - 1];
				Lightbox.makeLightbox(lightboxParams);
				bucky.timer.stop('loadLightbox');
			});

		},
		displayInlineVideo: function (target, targetChildImg, mediaTitle, clickSource) {
			var self = this;

			if ($.inArray(mediaTitle, LightboxLoader.inlineVideoLoading) > -1) {
				return;
			}

			LightboxLoader.inlineVideoLoading.push(mediaTitle);

			LightboxLoader.getMediaDetail({
					fileTitle: mediaTitle,
					isInline: true,
					height: targetChildImg.height(),
					width: targetChildImg.width()
				}, function (json) {
					var embedCode = json.videoEmbedCode,
						inlineDiv = $('<div class="inline-video"></div>').insertAfter(target.hide()),
						videoIndex;

					target.closest('.article-thumb').addClass('inline-video-playing');

					require(['wikia.videoBootstrap'], function (VideoBootstrap) {
						self.videoInstance = new VideoBootstrap(inlineDiv[0], embedCode, clickSource);
					});

					// save references for inline video removal later
					LightboxLoader.inlineVideoLinks = target.add(LightboxLoader.inlineVideoLinks);
					LightboxTracker.inlineVideoTrackingTimeout = setTimeout(function () {
						LightboxTracker.track(
							Wikia.Tracker.ACTIONS.VIEW,
							'video-inline',
							null, {
								title: json.title,
								provider: json.providerName,
								clickSource: clickSource
							}
						);
					}, 1000);

					videoIndex = $.inArray(mediaTitle, LightboxLoader.inlineVideoLoading);
					LightboxLoader.inlineVideoLoading.splice(videoIndex, 1);
				},
				true); // Don't cache the media details
		},

		removeInlineVideos: function () {
			clearTimeout(LightboxTracker.inlineVideoTrackingTimeout);
			LightboxLoader.inlineVideoLinks
				.show()
				.parent().removeClass('inline-video-playing') // figure tag
				.end()
				.next().remove(); // video player container
		},

		getMediaDetail: function (mediaParams, callback, nocache) {
			var title = mediaParams.fileTitle;

			if (!nocache && LightboxLoader.cache.details[title]) {
				callback(LightboxLoader.cache.details[title]);
			} else {
				bucky.timer.start('getMediaDetail.request');
				$.nirvana.sendRequest({
					controller: 'Lightbox',
					method: 'getMediaDetail',
					type: 'get',
					format: 'json',
					data: mediaParams,
					callback: function (json) {
						bucky.timer.stop('getMediaDetail.request');
						// Don't cache videos played inline because width will be off for lightbox version bugid-42269
						if (!nocache) {
							LightboxLoader.cache.details[title] = json;
						}
						callback(json);
					}
				});
			}
		},

		getMediaDetailDeferred: function (mediaParams) {
			var deferred = $.Deferred();
			LightboxLoader.getMediaDetail(mediaParams, function (json) {
				deferred.resolve(json);
			});
			return deferred;
		},

		loadFromURL: function () {
			var fileTitle = window.Wikia.Querystring().getVal('file'),
				openModal = $('#LightboxModal'),
				trackingInfo;

			// Check if there's a file param in URL
			if (fileTitle) {
				// If Lightbox is already open, update it
				if (openModal.length) {
					LightboxLoader.getMediaDetail({
						fileTitle: fileTitle
					}, function (data) {
						Lightbox.current.key = data.title.replace(/ /g, '_');
						Lightbox.current.type = data.mediaType;

						Lightbox.setCarouselIndex();
						Lightbox.openModal.carousel.find('li').eq(Lightbox.current.index).click();
					});

					// Open new Lightbox
				} else {
					// set a fake parent for carouselType
					trackingInfo = {
						parent: $('#WikiaArticle'),
						clickSource: LightboxTracker.clickSource.SHARE
					};
					LightboxLoader.loadLightbox(fileTitle, trackingInfo);
				}
				// No file param, if there's an open modal, close it
			} else {
				if (openModal.length) {
					openModal.closeModal();
				}
			}
		},
		/**
		 *
		 * @param {jQuery} $link Anchor that was clicked
		 * @param {jQuery} [$thumb] Optional thumbnail image inside clicked anchor
		 * @param {jQuery} event jQuery click event
		 * @returns {boolean}
		 */
		hasLightbox: function ($link, $thumb, event) {
			var modalPadding = 40; // amount of padding that modal adds to the width specified

			// if any of the following conditions are true, don't open the lightbox
			return !(
				$(window).width() < LightboxLoader.lightboxSettings.width + modalPadding || // browser is too small, like tablet
				$link.hasClass('link-internal') ||
				$link.hasClass('link-external') ||
				$thumb && $thumb.attr('data-shared-help') ||
				$link.hasClass('no-lightbox') ||
				event.metaKey ||
				event.ctrlKey
			);
		}
	};

	LightboxTracker = {
		inlineVideoTrackingTimeout: 0,
		// @param data - any extra params we want to pass to internal tracking
		// Don't add willy nilly though... check with Jonathan.
		track: function (action, label, value, data, method) {
			Wikia.Tracker.track({
				action: action,
				category: 'lightbox',
				label: label || '',
				trackingMethod: method || 'internal',
				value: value || 0
			}, data);
		},

		// Constants for tracking the source of a click
		clickSource: {
			EMBED: 'embed',
			SEARCH: 'search',
			SV: 'specialVideos',
			LB: 'lightbox',
			SHARE: 'share',
			HUBS: 'hubs',
			OTHER: 'other',
			VIDEOS_MODULE_RAIL: 'railVideosModule',
			VIDEO_HOME_PAGE: 'videoHomePage'
		}
	};

	$(function () {
		if (window.wgEnableLightboxExt && window.skin !== 'venus' ) {
			LightboxLoader.init();
		}
	});

	window.LightboxLoader = LightboxLoader;
	window.LightboxTracker = LightboxTracker;

})(window, jQuery);
