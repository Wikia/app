CKEDITOR.plugins.add('rte-media',
{
	overlays: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function() {
			// add node in which image menus will be stored
			self.overlays = $('<div id="RTEMediaOverlays" />');
			$('#RTEStuff').append(self.overlays);
		});

		editor.on('wysiwygModeReady', function() {
			// clean media menus
			if (typeof self.overlays == 'object') {
				self.overlays.html('');
			}

			// get all media (images / videos) - don't include placeholders
			var media = RTE.tools.getMedia();

			// regenerate media menu
			media.removeData('overlay');
			self.setupMedia(media);

			// get all image / video placeholders
			var placeholders =  RTE.getEditor().find('.media-placeholder');
			self.setupPlaceholder(placeholders);
		});

		// handle clicks on WMU/VET buttons in source mode (RT #35276)
		editor.on('toolbarReady', function(toolbar) {
			$('#mw-toolbar').children('#mw-editbutton-wmu').click(function(ev) {
				window.WMU_show(ev);
			});

			$('#mw-toolbar').children('#mw-editbutton-vet').click(function(ev) {
				window.VET_show(ev);
			});
		});

		// register "Add Image" command
		editor.addCommand('addimage', {
			exec: function(editor) {
				// call WikiaMiniUpload
				RTE.tools.callFunction(window.WMU_show);
			}
		});

		// register "Image" toolbar button
		editor.ui.addButton('Image', {
			title: editor.lang.image.add,
			className: 'RTEImageButton',
			command: 'addimage'
		});

		// check for existance of VideoEmbedTool
		if (typeof window.VET_show == 'function') {

			// register "Add Video" command
			editor.addCommand('addvideo', {
				exec: function(editor) {
					// call VideoEmbedTool
					RTE.tools.callFunction(window.VET_show);
				}
			});

			// register "Video" toolbar button
			editor.ui.addButton('Video', {
				title: editor.lang.video.add,
				className: 'RTEVideoButton',
				command: 'addvideo'
			});
		}
		else {
			RTE.log('VET is not enabled here - disabling "Video" button');
			return;
		}

		// set reference to plugin object
		RTE.mediaEditor.plugin = self;
	},

	// generate HTML for media menu
	getOverlay: function(image) {
		var self = this;

		if (!this.overlays) {
			// we're not ready yet
			return;
		}

		// get node in which menu is / will be stored
		var overlay = image.data('overlay');

		// generate node where menu will be stored
		if (typeof overlay == 'undefined') {
			var data = image.getData();

			// image with thumb of frame
			var isFramed = image.hasClass('thumb') || image.hasClass('frame');

			// image width (including paddings and borders)
			var width = parseInt(image.attr('width'));
			if (isFramed) {
				if (CKEDITOR.env.ie && CKEDITOR.env.version <= 7) {
					// IE8-
					width += 2;
				}
				else {
					width += 8;
				}
			}

			// create menu node
			overlay = $('<div class="RTEMediaOverlay">');
			overlay.width(width + 'px').attr('type', image.attr('type'));
			overlay.html('<div class="RTEMediaMenu color1">' +
				'<span class="RTEMediaOverlayEdit">' + RTE.instance.lang.media.edit  + '</span> ' +
				'<span class="RTEMediaOverlayDelete">' + RTE.instance.lang.media['delete'] + '</span>' +
				'</div>');

			// render image caption
			var captionContent = data.params.captionParsed || data.params.caption;
			if (captionContent && isFramed) {
				var captionTop = parseInt(image.attr('height') + 7);
				var captionWidth = image.attr('width');

				// IE8-
				if (CKEDITOR.env.ie && CKEDITOR.env.version <= 7) {
					captionTop -= 25; /* padding-top (25px) */
					captionWidth -= 6; /* padding (3px) * 2 */
				}

				var caption = $('<div>').
					addClass('RTEMediaCaption').
					css('top',captionTop + 'px').
					width(captionWidth).
					html(captionContent);

				caption.appendTo(overlay);
			}

			// setup events
			overlay.bind('mouseover', function() {
				// don't hide this menu
				self.showOverlay(image);
			});

			overlay.bind('mouseout', function() {
				// hide this menu
				self.hideOverlay(image);
			});

			// add it and store it in image data
			this.overlays.append(overlay);
			image.data('overlay', overlay);

			// handle clicks on [edit] / [delete]
			overlay.find('.RTEMediaOverlayEdit').bind('click', function(ev) {
				// hide preview
				overlay.hide();

				// call editor for image
				$(image).trigger('edit');

				// tracking
				RTE.track(self.getTrackingType(image), 'menu', 'edit');
			});

			overlay.find('.RTEMediaOverlayDelete').bind('click', function(ev) {
				var type = self.getTrackingType(image);

				// tracking
				RTE.track(type, 'menu', 'delete');

				// show modal version of confirm()
				var title = RTE.instance.lang[type].confirmDeleteTitle;
				var msg = RTE.instance.lang[type].confirmDelete;

				RTE.tools.confirm(title, msg, function() {
					RTE.tools.removeElement(image);

					// remove menu
					overlay.remove();
				});
			});
		}

		return overlay;
	},

	// show media menu
	showOverlay: function(image) {
		var overlay = this.getOverlay(image);

		// position image menu over an image
		var position = RTE.tools.getPlaceholderPosition(image);

		if (image.hasClass('media-placeholder')) {
			// image / video placeholder
			position.top += 2;
			position.left += 2;
		}
		else {
			// take image margins into consideration
			if ( image.hasClass('thumb') || image.hasClass('frame') ) {
				position.top += 6;

				if (!image.hasClass('alignLeft')) {
					position.left += 18;
				}
			}
		}

		overlay.css({
			'left': position.left + 'px',
			'top': parseInt(position.top + 2) + 'px'
		});

		// don't show [modify] / [remove] menu above RTE toolbar
		var menu = overlay.children().eq(0);
		if (position.top > 0) {
			menu.show();
		}

		// don't show caption when it's going outside RTE window (RT #46409)
		var caption = overlay.children().eq(1);
		var positionCaption = parseInt(position.top) + parseInt(caption.css('top')) + 16 /* caption height */;

		if (positionCaption < RTE.tools.getEditorHeight()) {
			caption.show();
		}

		// show whole media overlay
		overlay.show();

		// clear timeout used to hide preview with small delay
		if (timeoutId = image.data('hideTimeout')) {
			clearTimeout(timeoutId);
		}
	},

	// hide media menu
	hideOverlay: function(image) {
		var overlay = this.getOverlay(image);

		// hide menu 100 ms after mouse is out (this prevents flickering)
		image.data('hideTimeout', setTimeout(function() {
			overlay.children().hide();
			overlay.hide().removeData('hideTimeout');
		}, 100));
	},

	// setup both images and videos (including placeholders)
	setupMedia: function(media) {
		var self = this;

		// no media to setup - leave
		if (!media.exists()) {
			return;
		}

		// keep constant value of _rte_instance
		media.attr('_rte_instance', RTE.instanceId);

		// unbind previous events
		media.unbind('.media');

		// setup events
		media.bind('mouseover.media', function() {
			self.showOverlay($(this));
		});

		media.bind('mouseout.media', function() {
			self.hideOverlay($(this));
		});

		media.bind('contextmenu.media', function(ev) {
			// don't show CK context menu
			ev.stopPropagation();
		});

		// track when drag&drop starts
		media.bind('dragged.media', function(ev) {
			 RTE.track(self.getTrackingType($(this)), 'event', 'move');
		});

		// make media not selecteable
		RTE.tools.unselectable(media);

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.media').bind('dropped.media', function(ev, extra) {
                        var target = $(ev.target);

			// handle images and videos only
			if (!target.hasClass('image') && !target.hasClass('video') && !target.hasClass('media-placeholder')) {
				return;
			}

			// calculate relative positon
			var editorX = parseInt(extra.pageX - $('#editform').offset().left);
			var editorWidth = parseInt($('#editform').width());

			// choose new image alignment
			var data = target.getData();
			var newAlign = false;

			var oldAlign = data.params.align;
			if (!oldAlign) {
				// get default alignment if none is specified in wikitext
				oldAlign = (target.hasClass('thumb') || target.hasClass('frame')) ? 'right' : 'left';

				// small fix for media placeholders
				if (target.hasClass('alignNone')) {
					oldAlign = 'left';
				}
			}

			switch(oldAlign) {
				case 'left':
					// switch to right if x > 66% of width
					if (editorX > parseInt(editorWidth * 0.66)) {
						newAlign = 'right';
					}
					break;

				case 'right':
					// switch to left if x < 33% of width
					if (editorX < parseInt(editorWidth * 0.33)) {
						newAlign = 'left';
					}
					break;
			}

			if (!newAlign) {
				RTE.log('media alignment detected: ' + oldAlign + ' (no change)');
				return;
			}

			RTE.log('media alignment: ' + oldAlign + ' -> ' + newAlign);

			// update image rte-data and wikitext
			var wikitext = data.wikitext;
			var re = new RegExp('\\|' + oldAlign + '(\\||])');

			if (re.test(wikitext)) {
				// switch alignment which is already in wikitext
				// example: [[File:Spiderpig.jpg|thumb|left|left something]]
				wikitext = wikitext.replace(re, "|" + newAlign + "$1");
			}
			else {
				// there's no alignment in wikitext - add left/right after the first pipe
				// example: [[File:Spiderpig.jpg|thumb|foo]] or [[File:Spiderpig.png]]
				wikitext = wikitext.replace(/(\||\])/, '|' + newAlign + '$1');
			}

			RTE.log('new wikitext: ' + wikitext);

			// update meta data
			data.params.align = newAlign;
			data.wikitext = wikitext;

			target.setData(data);

			// re-align image in editor
			target.removeClass('alignNone alignLeft alignRight').addClass(newAlign == 'left' ? 'alignLeft' : 'alignRight');

			// tracking
			var type = target.attr('type');

			if (type == 'image-placeholder') {
				type = 'imagePlaceholder';
			}

			if (type == 'video-placeholder') {
				type = 'videoPlaceholder';
			}

			RTE.track(
				type,
				'event',
				'switchSide',
				(newAlign == 'right') ? 'l2r' : 'r2l'
			);
		});

		// update position of image caption ("..." icon)
		var mediaWithCaption = media.filter('.withCaption');
		mediaWithCaption.each(function() {
			$(this).css('backgroundPosition', '5px ' + parseInt($(this).attr('height') + 10)  + 'px');
		});

		// images / videos specific setup
		var image = media.filter('img.image');
		self.setupImage(image);

		var video = media.filter('img.video');
		self.setupVideo(video);
	},

	// image specific setup
	setupImage: function(image) {
		image.bind('edit.media', function(ev) {
			RTE.log('Image clicked');
			RTE.log($(this).getData());

			// call WikiaMiniUpload and provide WMU with image clicked
			RTE.tools.callFunction(window.WMU_show,$(this));
		});
	},

	// video specific setup
	setupVideo: function(video) {
		video.bind('edit.media', function(ev) {
			RTE.log('Video clicked');
			RTE.log($(this).getData());

			// call VideoEmbedTool and provide VET with video clicked
			RTE.tools.callFunction(window.VET_show,$(this));
		});
	},

	setupPlaceholder: function(placeholder) {
		var self = this;

		// no image placeholders to setup - leave
		if (!placeholder.exists()) {
			return;
		}

		// add [edit] / [delete] menu
		this.setupMedia(placeholder);

		// unbind previous events
		placeholder.unbind('.placeholder');

		// setup events
		placeholder.bind('contextmenu.placeholder', function(ev) {
			// don't show CK context menu
			ev.stopPropagation();
		});

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.placeholder').bind('dropped.placeholder', function(ev, extra) {
                        var target = $(ev.target);

			// keep image/video placeholders
			target = target.filter('.media-placeholder');

			self.setupPlaceholder(target);
		});

		// setup image / video placeholder separatelly
		var images = placeholder.filter('.image-placeholder');
		images.attr('title', RTE.instance.lang.imagePlaceholder.tooltip);
		images.bind('edit.placeholder', function(ev) {
			// call WikiaMiniUpload and provide WMU with image clicked + inform it's placeholder
			RTE.tools.callFunction(window.WMU_show,$(this), {isPlaceholder: true});
		});

		var videos = placeholder.filter('.video-placeholder');
		videos.attr('title', RTE.instance.lang.videoPlaceholder.tooltip);
		videos.bind('edit.placeholder', function(ev) {
			// call VideoEmbedTool and provide VET with video clicked + inform it's placeholder
			RTE.tools.callFunction(window.VET_show,$(this), {isPlaceholder: true});
		});
	},

	// get type name for tracking code
	getTrackingType: function(media) {
		var type;

		switch($(media).attr('type')) {
			case 'image':
				type = 'image';
				break;

			case 'video':
				type = 'video';
				break;

			case 'image-placeholder':
				type = 'imagePlaceholder';
				break;

			case 'video-placeholder':
				type = 'videoPlaceholder';
				break;

			case 'image-gallery':
				type = 'photoGallery';
				break;
		}

		return type;
	}
});

// helper class for image and video editing
RTE.mediaEditor = {
	// reference to rte-media plugin
	plugin: false,

	// add an image (wikitext will parser to HTML, params stored in metadata)
	addImage: function(wikitext, params) {
		RTE.log('adding an image');

		// parse wikitext: get image name
		var wikitextParams = wikitext.substring(2, wikitext.length-2).split('|');

		// set wikitext and metadata
		var data = {
			type: 'image',
			title: wikitextParams.shift().replace(/^[^:]+:/, ''), // get image name (without namespace prefix)
			params: params,
			wikitext: wikitext
		};

		this._add(wikitext, data);
	},

	// add a video (wikitext will parser to HTML, params stored in metadata)
	addVideo: function(wikitext, params) {
		RTE.log('adding a video');

		// set wikitext and metadata
		var data = {
			type: 'video',
			params: params,
			wikitext: wikitext
		};

		this._add(wikitext, data);
	},

	// add given media
	_add: function(wikitext, data) {
		var self = this;

		// render an image and replace old one
		RTE.tools.parseRTE(wikitext, function(html) {
			var newMedia = $(html).children('img');

			// set meta-data
			newMedia.setData(data);

			// insert new media (don't reinitialize all placeholders)
			RTE.tools.insertElement(newMedia, true);

			// setup added media
			self.plugin.setupMedia(newMedia);

			// tracking
			RTE.track(self.plugin.getTrackingType(newMedia), 'event', 'add');
		});
	},

	// update given media (wikitext will parser to HTML, params stored in metadata)
	update: function(media, wikitext, params) {
		var self = this;

		// render an image and replace old one
		RTE.tools.parseRTE(wikitext, function(html) {
			var newMedia = $(html).children('img');


			// replace old one with new one
			newMedia.insertAfter(media);
			newMedia.setData('wikitext', wikitext);
			media.remove();

			// setup added media
			self.plugin.setupMedia(newMedia);

			// tracking
			RTE.track(self.plugin.getTrackingType(newMedia), 'event', 'modified');
		});
	}
};
