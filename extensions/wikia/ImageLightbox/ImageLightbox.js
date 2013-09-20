/* global RelatedVideos */
var ImageLightbox = {
	// store element which was clicked to trigger lightbox - custom event will be fired when lightbox will be shown
	target: false,
	afterLoadOpened : false,
	videoThumbWidthThreshold: 320,
    wikiAddress: false,
    showEmbedCodeInstantly: true,

	log: function(msg) {
		$().log(msg, 'ImageLightbox');
	},

	// setup click handler on article content
	init: function() {
		var self = this,
			article;

		// is ImageLightbox extension enabled? (RT #47665)
		if (!window.wgEnableImageLightboxExt) {
			this.log('disabled');
			return;
		}

		if (window.skin == 'oasis') {
			article = $('#WikiaArticle, .LatestPhotosModule, #article-comments');
		}
		else {
			article = $('#bodyContent');
		}

		this.log('init');

		article.
			unbind('.lightbox').
			bind('click.lightbox', function(ev) {
				self.onClick.call(self, ev);
			});

        // also bind to right rail RelatedVideos module
        $('#RelatedVideosRL').
            unbind('.lightbox').
            bind('click.lightbox', function(ev) {
                self.onClick.call(self, ev);
            });
	},

	// get caption html for given target node
	getCaption: function(target) {
		var caption = false;

		if (target.hasClass('slideshow')) {
			// <gallery type="slideshow"> lightboxes
			caption = target.prev('label').html();
		}
		else if (target.hasClass('lightbox')) {
			// <gallery> lightboxes
			caption = target.closest('.thumb').next('.lightbox-caption').html();
		}
		else if (target.hasClass('image')) {
			// image thumbs
			caption = target.nextAll('.thumbcaption').html();
		}

		return caption;
	},

	// handle clicks on article content and handle clicks on links only
	onClick: function(ev) {
		var target = $(ev.target);
        this.wikiAddress = false;

		// move to parent of an image -> anchor
		if ( target.is('span') || target.is('img') ) {
			if ( target.hasClass('play') || target.hasClass('Wikia-video-thumb') ) {
				target = target.parent();
				target.addClass('image');
			} else {
				target = target.parent();
			}
		}

        // move to parent of a play button
        if (target.is('div') && (target.hasClass('playButton') || target.hasClass('Wikia-video-play-button'))) {
            target = target.parent();
        }

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

		// store clicked element
		this.target = target;

		// get image's caption
		var caption = this.getCaption(target);

		// handle shared help images (as external images)
		if (target.attr('data-shared-help')) {
			var self = this,
				imageSrc = target.attr('href'),
				img = new Image();

			this.log('loading shared help image: ' + imageSrc);

			// preload an image so we know its size before lightbox is rendered
			img.onload = function() {
				var html = '<div id="lightbox-image" style="text-align: center"><img src="' + imageSrc + '" alt="" /></div>' +
					'<div id="lightbox-caption-content"></div>';
				self.showLightbox(target.attr('data-image-name'), html, caption);
			};
			img.src = imageSrc;

			// don't follow the link
			ev.preventDefault();
			return;
		}

		// handle lightboxes for external images
		if (target.hasClass('link-external')) {
			var image = target.children('img'),
				html = '<div id="lightbox-image" style="text-align: center"><img src="' + image.attr('src') + '" alt="" /></div>' +
				'<div id="lightbox-caption-content"></div>';

			this.showLightbox(target.closest('.wikia-gallery').attr('data-feed-title'), html, caption);

			// don't follow the link
			ev.preventDefault();
			return;
		}

		// get name of an image
		var imageName = false;

		// data-image-name="Foo.jpg"
		if (target.attr('data-image-name')) {
			imageName = 'File:' + target.attr('data-image-name');
		}
		// ref="File:Foo.jpg"
		else if (target.attr('ref')) {
			imageName = target.attr('ref');
		}
		// href="/wiki/File:Foo.jpg"
		else {
			var re = wgArticlePath.replace(/\$1/, '(.*)');
			var matches = target.attr('href').match(re);

			if (matches) {
				imageName = matches.pop();
			}

		}

		// for Video Thubnails:
		var targetChildImg = target.find('img').eq(0);
		if ( targetChildImg.length > 0 && targetChildImg.hasClass('Wikia-video-thumb') ) {
			if ( target.attr('data-video-name') ) {

				imageName = 'File:' + target.attr('data-video-name');

			} else if ( targetChildImg.length > 0 && targetChildImg.attr('data-video') ) {

				imageName = 'File:' + targetChildImg.attr('data-video');
			}

			if (imageName && targetChildImg.width() >= this.videoThumbWidthThreshold) {

				this.displayInlineVideo(targetChildImg, imageName);
				ev.preventDefault();
				return false;
			}
		}

        if (target.hasClass('video-hubs-video')) {
			var wikiData = target.data('wiki');
            if(wikiData) {
				this.wikiAddress = wikiData;
				this.showEmbedCodeInstantly = true;
            }
        }

		//imageName = "File:acat.jpg";
		if (imageName != false) {
			// RT #44281
			imageName = decodeURIComponent(imageName);
			var timestamp = target.attr("data-timestamp");
			// find caption node and use it in lightbox popup
			var showShareTools = target.hasParent('#WikiaArticle') ? 1 : 0;
			this.fetchLightbox(imageName, caption, showShareTools, timestamp);

			// don't follow href
			ev.preventDefault();

			// click tracking
			var eventValue = 0;
			// Related Videos module - Not used in hubs because $('.RelatedVideosModule') doesn't exist
			var rvModule = target.closest('.RelatedVideosModule');
			if (rvModule && rvModule.length) {
				var localItem = target.closest('.item');
				var localGroup = localItem.closest('.group');
				var container = localGroup.closest('.container');
				var allGroups = container.children();
				var localAllItems = localGroup.children();
				var localItemIndex = localAllItems.index(localItem);
				var localGroupIndex = allGroups.index(localGroup);
				var clickedIndex = (localGroupIndex * RelatedVideos.videosPerPage) + localItemIndex;
				eventValue = clickedIndex+1;	// tracked values must be one-indexed

				Wikia.Tracker.track({
					action: Wikia.Tracker.ACTIONS.PLAY_VIDEO,
					browserEvent: ev,
					category: RelatedVideos.gaCat,
					label: (target.hasClass('video') ? 'thumbnail' : 'title'),
					trackingMethod: 'both',
					value: eventValue,
					video_title: imageName
				});
			}

		}
	},

	displayInlineVideo: function(targetImage, imageName) {
		var parentTag = targetImage.parent();
		if (!parentTag.is('a')) {
			return;
		}
		parentTag.wrap('<span class="wikiaVideoPlaceholder" />');
        var wrapperTag = parentTag.parent('span.wikiaVideoPlaceholder');

		var imageWidth = targetImage.width();
		var imageHeight = targetImage.height();

		// get resized image from server or fetch video data for lightbox
		$.getJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
			'maxheight': imageHeight,
			'maxwidth': imageWidth,
			'method': 'ajax',
			'pageName': wgPageName,
			'share': 0,
			'title': imageName,
			'videoInline': 1
		}, function(res) {
			jQuery(parentTag).siblings('span.Wikia-video-title-bar').eq(0).remove();
			if (res.embedCode) {
				wrapperTag.find('a').hide();

				var element = $('<div  class="Wikia-video-enabledEmbedCode"></div>').append(wrapperTag);

				require(['wikia.videoBootstrap'], function (VideoBootstrap) {
					new VideoBootstrap(element[0], res.embedCode, 'imageLightbox');
				});

				ImageLightbox.doViewTracking(res.titleKey, res.type, res.provider);
			}
		});


	},

    restoreInlineThumbnails: function() {
        jQuery(".Wikia-video-enabledEmbedCode").remove();
        jQuery('span.wikiaVideoPlaceholder a').show();
    },

	setTopPosition: function() {
		var lightbox = $('#lightbox');
		if (window.skin == 'oasis') {
			lightbox.css('top', lightbox.getModalTopOffset());
		}
	},

	// fetch data and show lightbox
	fetchLightbox: function(imageName, caption, showShareTools, timestamp) {

		var self = this;
		this.log(imageName);

		// locking to prevent double clicks
		if (this.lock) {
			this.log('lock detected: another lightbox is loading');
			return;
		}

		this.lock = true;
		this.imageName = imageName;

		// calculate maximum dimensions for image
		var maxWidth = $(window).width();
		var maxHeight = $(window).height();

		if (window.skin == 'oasis') {
			maxHeight -= 75;
			maxWidth = 850;
		}

		// get resized image from server or fetch video data for lightbox
		$.getJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
			'maxheight': maxHeight,
			'maxwidth': maxWidth,
			'method': 'ajax',
			'pageName': wgPageName,
			'share': showShareTools,
			'title': imageName,
			't': timestamp,
            'showEmbedCodeInstantly' : this.showEmbedCodeInstantly,
            'wikiAddress' : this.wikiAddress
        }, function(res) {
			if (res) {
				if (res.embedCode) {

						// Handle video lightbox
						self.showLightbox(res.title, '<div id="ImageLightboxVideoEmbed"></div>'+res.html, caption, res.width, res.titleKey, res.type, res.provider, function(){
							require(['wikia.videoBootstrap'], function (VideoBootstrap) {
								new VideoBootstrap(document.getElementById('ImageLightboxVideoEmbed'), res.embedCode, 'imageLightbox');
							});
						});

				} else {
					self.showLightbox(res.title, res.html, caption, res.width, res.titleKey, res.type, res.provider);
					self.setTopPosition();
				}
			} else {
				// remove lock
				delete self.lock;
			}
		});
	},

	// create modal popup
	showLightbox: function(title, content, caption, width, titleKey, type, provider, secondCallBack) {
		var self = this;

		// fix caption when not provided
		caption = caption || '';

		$.showModal(title, content, {
			'id': 'lightbox',
			'width': width || 'auto',
			'callback': function() {
				var lightbox = $('#lightbox');

				self.doViewTracking(titleKey, type, provider);

				$('#lightbox-share-buttons').find('a').click(function() {
					var source = $(this).attr('data-func');
					if (source == "email") {
						if ( window.wgUserName === null ) {
							if ( window.wgComboAjaxLogin ) {
								showComboAjaxForPlaceHolder(false, "", function(){
									AjaxLogin.doSuccess = function() {
										window.location = $('#lightbox-image-link').val();
									}
								});
							}
							else {
								UserLoginModal.show({
									callback: function() {
										window.location = $('#lightbox-image-link').val();
									}
								});
							}
							return false;
						}
					}

					$(this).closest('#lightbox-share').find('.lightbox-share-area').each(function() {
						if (source == $(this).attr('data-func')) {
							$(this).slideDown();
						} else {
							$(this).slideUp();
						}
					});
					if (source == 'embed') {
						$('#lightbox-share-embed-standard').select();
					}
				});

				$('#lightbox-share-email-button').click(function() {
					var addresses = $('#lightbox-share-email-text').val();
					//TODO: add simple validation for e-mails
					var throbber = $(this).next('.throbber');
					throbber.show();
					//send e-mail via AJAX
					$.postJSON(wgScript + '?action=ajax&rs=ImageLightboxAjax', {
						'addresses': addresses,
						'method': 'sendMail',
						'pageName': wgPageName,
						'title': self.imageName
					}, function(res) {
						throbber.hide();
						$.showModal(res['info-caption'], res['info-content']);
					});
				});

				$('#lightbox-caption-content').html(caption);

				var lightboxSubtitle = $('#lightbox-subtitle');
                if(lightboxSubtitle.text() != '') {
					lightboxSubtitle.show();
                }

				// resize lightbox (used mostly for external images)
				lightbox.resizeModal(lightbox.width());

				// init FB like button
				if (typeof FB != 'undefined') {
					 FB.XFBML.parse(lightbox.get(0));
				}

				// RT #69824
				self.setTopPosition();

                //BugId:26628
                self.restoreInlineThumbnails();

				// fire custom event (RT #74852)
				if (self.target) {
					self.target.trigger('lightbox', [lightbox]);
					self.target = false;
				}

				if ( !self.afterLoadOpened && $.getUrlVar('open') == 'email') {
					self.afterLoadOpened = true;
					$('#lightbox-share-buttons').find('a[data-func$="email"]').click();
					$('#lightbox-share-email-text').focus();
				}

				if (typeof secondCallBack == 'function') {
					 $.proxy(secondCallBack, this)();
				}

				// remove lock
				delete self.lock;
			}
		});
	},
	doViewTracking: function(titleKey, type, provider) {
		// Video and Image view tracking
		clearTimeout(ImageLightbox.trackingTimeout);
		if(typeof titleKey != "undefined") {
			var trackingTitle = titleKey,
				timeout = (type == 'video') ? 1000 : 500;
			ImageLightbox.trackingTimeout = setTimeout(function() {
				ImageLightbox.track(Wikia.Tracker.ACTIONS.VIEW, type, 0, {title: trackingTitle, provider: provider, clickSource: 'hubs'});
			}, timeout);
		}
	},
	// @param data - any extra params we want to pass to internal tracking
	// Don't add willy nilly though... check with Jonathan.
	track: function(action, label, value, data) {
		Wikia.Tracker.track({
			action: action,
			category: 'lightbox',
			label: label || '',
			trackingMethod: 'internal',
			value: value || 0
		}, data);
	},
	trackingTimeout: false
};

if ( typeof window.skin != 'undefined' && window.skin == 'oasis' ) {
	$(function() {
		ImageLightbox.init.call(ImageLightbox);
		var image = $('#' + $.getUrlVar('image'));
		if (image.exists()) {
			$(window).scrollTop(image.offset().top + image.height()/2 - $(window).height()/2);
			image.find('img').click();
		}
	});
}
