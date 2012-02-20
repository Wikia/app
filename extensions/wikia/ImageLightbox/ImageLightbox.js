var ImageLightbox = {
	// store element which was clicked to trigger lightbox - custom event will be fired when lightbox will be shown
	target: false,
	afterLoadOpened : false,
	videoThumbWidthThreshold: 320,
	log: function(msg) {
		$().log(msg, 'ImageLightbox');
	},

	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('lightbox' + fakeUrl);
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


		// move to parent of an image -> anchor
		if (target.is('img')) {
			if ( target.hasClass('Wikia-video-thumb') ) {
				target = target.parent();
				target.addClass('image');
			} else {
				target = target.parent();
			}	
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
			}
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
		if ( imageName == false ) {
			
			var isVideoThumb = false;
			var targetChildImg = target.find('img').eq(0);

			if ( target.attr('data-video-name') ) {
				
				imageName = 'File:' + target.attr('data-video-name');
				isVideoThumb = true;
				
			} else if ( targetChildImg.length > 0 && targetChildImg.attr('data-video') ) {
				
				imageName = 'File:' + targetChildImg.attr('data-video');
				isVideoThumb = true;
			}
			
			
			if (imageName && isVideoThumb && targetChildImg.width() >= this.videoThumbWidthThreshold) {
				this.displayInlineVideo(targetChildImg, imageName);
				ev.preventDefault();
				return false;
			}
		}
		
		//imageName = "File:acat.jpg";
		if (imageName != false) {
			// RT #44281
			imageName = decodeURIComponent(imageName);

			// find caption node and use it in lightbox popup
			var showShareTools = target.hasParent('#WikiaArticle') ? 1 : 0;
			this.fetchLightbox(imageName, caption, showShareTools);

			// don't follow href
			ev.preventDefault();
		}
	},
	
	displayInlineVideo: function(targetImage, imageName) {
		
		var parentTag = targetImage.parent();
		if (!parentTag.is('a')) {
			return;
		}		
		
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
			if (res && ( res.html || res.jsonData ) ) {
				if (res.asset) {
					$.getScript(res.asset, function() {
						jQuery( '<div id="'+res.jsonData.id+'" style="width:'+imageWidth+'px; height:'+imageHeight+'px; display: inline-block;"></div>' ).replaceAll( parentTag );
						jwplayer( res.jsonData.id ).setup( res.jsonData );
					});					
				} else {
					jQuery( '<div>'+res.html+'</div>' ).replaceAll( parentTag );
				}	
			} 
		});
		
		
	},

	// fetch data and show lightbox
	fetchLightbox: function(imageName, caption, showShareTools) {
		var self = this;
		this.log(imageName);

		// locking to prevent double clicks
		if (this.lock) {
			this.log('lock detected: another lightbox is loading');
			return;
		}

		this.lock = true;
		this.imageName = imageName;

		// tracking
		this.track('/init');

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
			'title': imageName
		}, function(res) {
			if (res && ( res.html || res.jsonData ) ) {
				if (res.asset) {
					$.getScript(res.asset, function() {
						self.showLightbox(res.title, '<div id="'+res.jsonData.id+'"></div>'+res.html, caption, res.width, function(){
							jwplayer( res.jsonData.id ).setup( res.jsonData );
						});
					});					
				} else {
					self.showLightbox(res.title, res.html, caption, res.width);
				}	
			} else {
				// remove lock
				delete self.lock;
			}
		});
	},

	// create modal popup
	showLightbox: function(title, content, caption, width, secondCallBack) {
		var self = this;

		// fix caption when not provided
		caption = caption || '';

		$.showModal(title, content, {
			'id': 'lightbox',
			'width': width || 'auto',

			// track when popup is closed
			'onClose': function() {
				self.track('/close');
			},

			// setup tracking
			'callback': function() {
				var lightbox = $('#lightbox');

				$('#lightbox-link').click(function() {
					self.track('/details');
				});
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
					self.track('/share/' + source);
				});

				$('#lightbox-share-email-button').click(function() {
					self.track('/share/email/send');
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

				$('#lightbox-share').find('.share-links').find('a').click(function() {
					var source = $(this).attr('data-func');
					self.track('/share/www/' + source);
				});

				$('#lightbox-share').find('.share-code').find('input').click(function() {
					var source = $(this).select().attr('data-func');
					self.track('/share/embed/' + source);
				});

				$('#lightbox-caption-content').html(caption);

				// resize lightbox (used mostly for external images)
				lightbox.resizeModal(lightbox.width());

				// init FB like button
				if (typeof FB != 'undefined') {
					 FB.XFBML.parse(lightbox.get(0));
				}

				// RT #69824
				if (window.skin == 'oasis') {
					lightbox.css('top', lightbox.getModalTopOffset());
				}

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
	}
};

if ( (typeof window.skin != 'undefined') && (window.skin == 'monaco' || window.skin == 'oasis') ) {
	$(function() {
		ImageLightbox.init.call(ImageLightbox);
		var image = $('#' + $.getUrlVar('image'));
		if (image.exists()) {
			$(window).scrollTop(image.offset().top + image.height()/2 - $(window).height()/2);
			image.find('img').click();
		}
	});
}
