/* global CKEDITOR, RTE, WikiaEditor, UserLogin */
CKEDITOR.plugins.add('rte-media', {
	init: function (editor) {
		'use strict';

		var self = this;

		editor.on('wysiwygModeReady', function () {
			var media, placeholders;

			// get all media (images / videos) - don't include placeholders
			media = RTE.tools.getMedia();

			// regenerate media menu
			self.setupMedia(media);

			// get all image / video placeholders
			placeholders = RTE.getEditor().find('.media-placeholder');
			self.setupPlaceholder(placeholders);
		});

		// register "Add Image" command
		editor.addCommand('addimage', {
			exec: function () {
				WikiaEditor.load('WikiaMiniUpload').done(function () {
					RTE.tools.callFunction(window.WMU_show); // jshint ignore:line
				});
			}
		});

		// register "Image" toolbar button
		editor.ui.addButton('Image', {
			label: editor.lang.image.photo,
			title: editor.lang.image.add,
			className: 'RTEImageButton',
			command: 'addimage'
		});

		// check for existance of VideoEmbedTool
		if (window.wgEnableVideoToolExt) {
			// register "Add Video" command
			editor.addCommand('addvideo', {
				exec: function () {
					WikiaEditor.load('VideoEmbedTool').done(function () {
						RTE.tools.callFunction(window.vetWikiaEditor);
					});
				}
			});

			// register "Video" toolbar button
			editor.ui.addButton('Video', {
				label: editor.lang.video.video,
				title: editor.lang.video.add,
				className: 'RTEVideoButton',
				command: 'addvideo'
			});
		} else {
			RTE.log('VET is not enabled here - disabling "Video" button');
		}

		// set reference to plugin object
		RTE.mediaEditor.plugin = self;
	},

	// setup both images and videos (including placeholders)
	setupMedia: function (media) {
		'use strict';

		var self = this,
			editor = RTE.getInstance(),
			msgs,
			getTrackingCategory,
			standardButtons,
			mediaWithCaption,
			image,
			video;

		// no media to setup - leave
		if (!media.exists()) {
			return;
		}

		// keep consistent value of RTE instance ID
		media.attr('data-rte-instance', RTE.instanceId);

		// setup overlay
		msgs = RTE.getInstance().lang.media;

		getTrackingCategory = function (node) {
			var type;

			switch (node.attr('type')) {
			case 'image':
			case 'image-placeholder':
				{
					type = node.hasClass('video') ? 'vet' : 'photo-tool';
					break;
				}
			case 'image-gallery':
				{
					type = (node.hasClass('image-slideshow') ?
						'slideshow' : node.hasClass('image-gallery-slider') ?
						'slider' : 'gallery') + '-tool';
					break;
				}
			}

			return type;
		};

		standardButtons = [{
			label: msgs.edit,
			'class': 'RTEMediaOverlayEdit',
			callback: function (node) {
				var category = getTrackingCategory(node);

				if (category) {
					WikiaEditor.track({
						category: category,
						label: 'modify'
					});
				}

				node.trigger('edit');
			}
		}, {
			label: msgs.delete,
			'class': 'RTEMediaOverlayDelete',
			callback: function (node) {
				var msgMediaType, category, title, msg;

				msgMediaType = self.getMediaTypeForMsg(node);
				category = getTrackingCategory(node);

				if (category) {
					WikiaEditor.track({
						category: category,
						label: 'remove'
					});
				}

				// show modal version of confirm()
				title = RTE.getInstance().lang[msgMediaType].confirmDeleteTitle;
				msg = RTE.getInstance().lang[msgMediaType].confirmDelete;

				RTE.tools.confirm(title, msg, function () {
					var wikiaEditor = RTE.getInstanceEditor();

					RTE.tools.removeElement(node);

					// Resize editor area
					wikiaEditor.fire('editorResize');
					wikiaEditor.editorFocus();

				}).data('tracking', {
					category: category
				});
			}
		}];

		// Do not show 'modify' link to gallery editor if new galleries are enabled. Once we have a new gallery
		// editor to go along with the new galleries we can turn this back on. See VID-1990 and VID-1855.
		// When removing this, also remove check in app/extensions/wikia/RTE/js/plugins/gallery/plugin.js
		if (window.wgEnableMediaGalleryExt && $(media).attr('type') === 'image-gallery'){
			standardButtons.shift();
		}

		RTE.overlay.add(media, standardButtons);

		// unbind previous events
		media.unbind('.media');

		// make media not selecteable
		RTE.tools.unselectable(media);

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.media').bind('dropped.media', function (ev, extra) {
			var target = $(ev.target),
				parentNode,
				editorX,
				editorWidth,
				data,
				newAlign,
				oldAlign,
				wikitext,
				re;

			// handle images and videos only
			if (!target.hasClass('image') && !target.hasClass('video') && !target.hasClass('media-placeholder')) {
				return;
			}

			// don't allow images to be drag&dropped into headers (RT #67987)
			parentNode = target.parent();
			if ((/h\d/i).test(parentNode.attr('nodeName'))) {
				// move image outside the header
				parentNode.after(target);

				RTE.log('image moved outside the header');
			}

			// calculate relative positon
			editorX = parseInt(extra.pageX - $(this).offset().left);
			editorWidth = parseInt($(this).width());

			// choose new image alignment
			data = target.getData();
			newAlign = false;

			oldAlign = data.params.align;
			if (!oldAlign) {
				// get default alignment if none is specified in wikitext
				oldAlign = (target.hasClass('thumb') || target.hasClass('frame')) ? 'right' : 'left';

				// small fix for media placeholders
				if (target.hasClass('alignNone')) {
					oldAlign = 'left';
				}
			}

			switch (oldAlign) {
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

			// update image meta data and wikitext
			wikitext = data.wikitext;
			re = new RegExp('\\|' + oldAlign + '(\\||])');

			if (re.test(wikitext)) {
				// switch alignment which is already in wikitext
				// example: [[File:Spiderpig.jpg|thumb|left|left something]]
				wikitext = wikitext.replace(re, '|' + newAlign + '$1');
			} else {
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
			target.removeClass('alignNone alignLeft alignRight')
				.addClass(newAlign === 'left' ? 'alignLeft' : 'alignRight');
		});

		// update position of image caption ("..." icon)
		mediaWithCaption = media.filter('.withCaption');
		mediaWithCaption.each(function () {
			$(this).css('backgroundPosition', '5px ' + parseInt($(this).attr('height') + 10) + 'px');
		});

		// images / videos specific setup
		image = media.filter('img.image');
		self.setupImage(image);

		video = media.filter('img.video');
		self.setupVideo(video);

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(media);
		}

		// Modifications to the DOM will register as content changes. Reset the dirty state.
		editor.resetDirty();
	},

	// image specific setup
	setupImage: function (image) {
		'use strict';

		image.bind('edit.media', function () {
			RTE.log('image clicked');

			// call WikiaMiniUpload and provide WMU with image clicked
			if (!UserLogin.isForceLogIn()) {
				var self = this;
				WikiaEditor.load('WikiaMiniUpload').done(function () {
					RTE.tools.callFunction(window.WMU_show, $(self)); // jshint ignore:line
				});
			}
		});
	},

	addWikiText: function (wikiText, editedElement) {
		'use strict';

		if (typeof editedElement !== 'undefined' && editedElement !== false) {
			RTE.mediaEditor.update(editedElement, wikiText);
		} else {
			RTE.mediaEditor.addVideo(wikiText, {});
		}
	},

	// video specific setup
	setupVideo: function (video) {
		'use strict';

		video.bind('edit.media', function () {
			RTE.log('video clicked');

			// call VideoEmbedTool and provide VET with video clicked
			if (!UserLogin.isForceLogIn()) {
				var self = this;
				WikiaEditor.load('VideoEmbedTool').done(function () {
					RTE.tools.callFunction(window.vetWikiaEditor, $(self));
				});
			}
		});
	},

	setupPlaceholder: function (placeholder) {
		'use strict';

		var images, videos,
			self = this;

		// no image placeholders to setup - leave
		if (!placeholder.exists()) {
			return;
		}

		// add [edit] / [delete] menu
		this.setupMedia(placeholder);

		// unbind previous events
		placeholder.unbind('.placeholder');

		// setup events
		placeholder.bind('contextmenu.placeholder', function (ev) {
			// don't show CK context menu
			ev.stopPropagation();
		});

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.placeholder').bind('dropped.placeholder', function (ev) {
			var target = $(ev.target);

			// keep image/video placeholders
			target = target.filter('.media-placeholder');

			self.setupPlaceholder(target);
		});

		// setup image / video placeholder separatelly
		images = placeholder.filter('.image-placeholder');
		images.attr('title', RTE.getInstance().lang.imagePlaceholder.tooltip);
		images.bind('click.placeholder edit.placeholder', function () {
			// call WikiaMiniUpload and provide WMU with image clicked + inform it's placeholder
			var self = this;
			WikiaEditor.load('WikiaMiniUpload').done(function () {
				RTE.tools.callFunction(window.WMU_show, $(self), { // jshint ignore:line
					isPlaceholder: true,
					track: {
						action: Wikia.Tracker.ACTIONS.CLICK,
						category: 'image-placeholder',
						label: 'edit-mode',
						method: 'analytics'
					}
				});
			});
		});

		videos = placeholder.filter('.video-placeholder');
		videos.attr('title', RTE.getInstance().lang.videoPlaceholder.tooltip);
		videos.bind('click.placeholder edit.placeholder', function () {
			// call VideoEmbedTool and provide VET with video clicked + inform it's placeholder
			var self = this;
			WikiaEditor.load('VideoEmbedTool').done(function () {
				RTE.tools.callFunction(window.vetWikiaEditor, $(self), {
					isPlaceholder: true,
					track: {
						action: Wikia.Tracker.ACTIONS.CLICK,
						category: 'video-placeholder',
						label: 'edit-mode',
						method: 'analytics'
					}
				});
			});
		});

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(placeholder);
		}
	},

	// maps media type to messages' group name
	getMediaTypeForMsg: function (media) {
		'use strict';

		var type;

		switch ($(media).attr('type')) {
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
	addImage: function (wikitext, params) {
		'use strict';

		var wikitextParams, data;

		RTE.log('adding an image');

		// parse wikitext: get image name
		wikitextParams = wikitext.substring(2, wikitext.length - 2).split('|');

		// set wikitext and metadata
		data = {
			type: 'image',
			title: wikitextParams.shift().replace(/^[^:]+:/, ''), // get image name (without namespace prefix)
			params: params,
			wikitext: wikitext
		};

		this._add(wikitext, data);
	},

	// add a video (wikitext will parser to HTML, params stored in metadata)
	addVideo: function (wikitext, params) {
		'use strict';

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
	_add: function (wikitext, data) {
		'use strict';

		var self = this;

		// render an image and replace old one
		RTE.tools.parseRTE(wikitext, function (html) {
			var editor = RTE.getInstance(),
				newMedia;

			//RT#52431 - proper context
			newMedia = $(html, editor.document.$).children('img');

			//fix for IE7, the above line of code is returning an empty element
			//since $(html) strips the enclosing <p> tag out for some reason
			if (!newMedia.exists()) {
				newMedia = $(html, editor.document.$);
			}

			// set meta-data
			newMedia.setData(data);

			// insert new media (don't reinitialize all placeholders)
			RTE.tools.insertElement(newMedia, true);

			// setup added media
			self.plugin.setupMedia(newMedia);

			RTE.getInstanceEditor().fire('editorAddMedia');

			editor.focus();
		});
	},

	// update given media (wikitext will parser to HTML, params stored in metadata)
	update: function (media, wikitext) {
		'use strict';

		var self = this;

		// render an image and replace old one
		RTE.tools.parseRTE(wikitext, function (html) {
			var editor = RTE.getInstance(),
				newMedia = $(html).children('img');

			// replace old one with new one
			newMedia.insertAfter(media);
			newMedia.setData('wikitext', wikitext);
			media.remove();

			// setup added media
			self.plugin.setupMedia(newMedia);

			editor.focus();
		});
	}
};
