CKEDITOR.plugins.add('rte-media',
{
	init: function(editor) {
		var self = this;

		editor.on('wysiwygModeReady', function() {
			// get all media (images / videos) - don't include placeholders
			var media = RTE.tools.getMedia();

			// regenerate media menu
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

	// setup both images and videos (including placeholders)
	setupMedia: function(media) {
		var self = this;

		// no media to setup - leave
		if (!media.exists()) {
			return;
		}

		// keep constant value of _rte_instance
		media.attr('_rte_instance', RTE.instanceId);

		// setup overlay
		var msgs = RTE.instance.lang.media;

		RTE.overlay.add(media, [
			{
				label: msgs['edit'],
				class: 'RTEMediaOverlayEdit',
				callback: function(node) {
					var type = self.getTrackingType(node);

					node.trigger('edit');

					// tracking
					RTE.track(type, 'menu', 'edit');
				}
			},
			{
				label: msgs['delete'],
				class: 'RTEMediaOverlayDelete',
				callback: function(node) {
					var type = self.getTrackingType(node);

					// show modal version of confirm()
					var title = RTE.instance.lang[type].confirmDeleteTitle;
					var msg = RTE.instance.lang[type].confirmDelete;

					RTE.tools.confirm(title, msg, function() {
						RTE.tools.removeElement(image);
					});

					// tracking
					RTE.track(type, 'menu', 'delete');
				}
			}
		]);

		// unbind previous events
		media.unbind('.media');

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

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(media);
		}
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

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(placeholder);
		}
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
			//RT#52431 - proper context
			var newMedia = $(html, RTE.instance.document.$).children('img');

			//fix for IE7, the above line of code is returning an empty element
			//since $(html) strips the enclosing <p> tag out for some reason
			if(!newMedia.exists()){
				newMedia = $(html, RTE.instance.document.$);
			}

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
