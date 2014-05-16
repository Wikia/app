/* global CKEDITOR, RTE, WikiaEditor */
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

		// register "Add Image" command
		editor.addCommand('addimage', {
			exec: function(editor) {
				WikiaEditor.load( 'WikiaMiniUpload' ).done(function() {
					RTE.tools.callFunction(window.WMU_show);
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
				exec: function(editor) {
					WikiaEditor.load( 'VideoEmbedTool' ).done(function() {
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
		}
		else {
			RTE.log('VET is not enabled here - disabling "Video" button');
		}

		// set reference to plugin object
		RTE.mediaEditor.plugin = self;
	},

	// setup both images and videos (including placeholders)
	setupMedia: function(media) {
		var self = this,
			editor = RTE.getInstance();

		// no media to setup - leave
		if (!media.exists()) {
			return;
		}

		// keep consistent value of RTE instance ID
		media.attr('data-rte-instance', RTE.instanceId);

		// setup overlay
		var msgs = RTE.getInstance().lang.media;

		var getTrackingCategory = function( node ) {
			var type;

			switch( node.attr( 'type' ) ) {
				case 'image':
				case 'image-placeholder': {
					type = node.hasClass( 'video' ) ? 'vet' : 'photo-tool';
					break;
				}
				case 'image-gallery': {
					type = ( node.hasClass( 'image-slideshow' ) ?
							'slideshow' : node.hasClass( 'image-gallery-slider' ) ?
							'slider' : 'gallery' ) + '-tool';
					break;
				}
			}

			return type;
		};

		var standardButtons = [
			{
				label: msgs['edit'],
				'class': 'RTEMediaOverlayEdit',
				callback: function(node) {
					var category = getTrackingCategory( node );

					if ( category ) {
						WikiaEditor.track({
							category: category,
							label: 'modify'
						});
					}

					node.trigger('edit');
				}
			},
			{
				label: msgs['delete'],
				'class': 'RTEMediaOverlayDelete',
				callback: function(node) {
					var msgMediaType = self.getMediaTypeForMsg(node);
					var category = getTrackingCategory( node );

					if ( category ) {
						WikiaEditor.track({
							category: category,
							label: 'remove'
						});
					}

					// show modal version of confirm()
					var title = RTE.getInstance().lang[msgMediaType].confirmDeleteTitle;
					var msg = RTE.getInstance().lang[msgMediaType].confirmDelete;

					RTE.tools.confirm(title, msg, function() {
						RTE.tools.removeElement(node);

						var wikiaEditor = RTE.getInstanceEditor();

						// Resize editor area
						wikiaEditor.fire('editorResize');
						wikiaEditor.editorFocus();

					}).data( 'tracking', {
						category: category
					});
				}
			}
		];

		RTE.overlay.add(media, standardButtons);


		// unbind previous events
		media.unbind('.media');

		// make media not selecteable
		RTE.tools.unselectable(media);

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.media').bind('dropped.media', function(ev, extra) {
			var target = $(ev.target);

			// handle images and videos only
			if (!target.hasClass('image') && !target.hasClass('video') && !target.hasClass('media-placeholder')) {
				return;
			}

			// don't allow images to be drag&dropped into headers (RT #67987)
			var parentNode = target.parent();
			if ((/h\d/i).test(parentNode.attr('nodeName'))) {
				// move image outside the header
				parentNode.after(target);

				RTE.log('image moved outside the header');
			}

			// calculate relative positon
			var editorX = parseInt(extra.pageX - $(this).offset().left);
			var editorWidth = parseInt($(this).width());

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

			// update image meta data and wikitext
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
		});

		// update position of image caption ("..." icon)
		var mediaWithCaption = media.filter('.withCaption');
		mediaWithCaption.each(function() {
			$(this).css('backgroundPosition', '5px ' + parseInt($(this).attr('height') + 10)  + 'px');
		});

		// images / videos / poll specific setup
		var image = media.filter('img.image');
		self.setupImage(image);

		var video = media.filter('img.video');
		self.setupVideo(video);

		var poll = media.filter('img.placeholder-poll');
		self.setupPoll(poll);

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(media);
		}

		// Modifications to the DOM will register as content changes. Reset the dirty state.
		editor.resetDirty();
	},

	// image specific setup
	setupImage: function(image) {
		image.bind('edit.media', function(ev) {
			RTE.log('image clicked');

			// call WikiaMiniUpload and provide WMU with image clicked
			if (!UserLogin.isForceLogIn()) {
				var self = this;
				WikiaEditor.load( 'WikiaMiniUpload' ).done(function() {
					RTE.tools.callFunction(window.WMU_show,$(self));
				});
			}
		});
	},

	addWikiText: function(wikiText, editedElement) {
		if ( typeof editedElement  != "undefined" && editedElement !== false ) {
			RTE.mediaEditor.update(editedElement, wikiText);
		} else {
			RTE.mediaEditor.addVideo(wikiText, {});
		}
	},

	// video specific setup
	setupVideo: function(video) {
		var self = this;
		video.bind('edit.media', function(ev) {
			RTE.log('video clicked');

			// call VideoEmbedTool and provide VET with video clicked
			if (!UserLogin.isForceLogIn()) {
				var self = this;
				WikiaEditor.load( 'VideoEmbedTool' ).done(function() {
					RTE.tools.callFunction(window.vetWikiaEditor, $(self));
				});
			}
		});
	},

	// poll specific setup
	setupPoll: function(poll) {
		poll.bind('edit.media', function(ev) {
			RTE.log('poll clicked');

			CreateWikiaPoll.showEditor(ev);
		});
	},

	setupPlaceholder: function(placeholder) {
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
		images = placeholder.filter('.image-placeholder');
		images.attr('title', RTE.getInstance().lang.imagePlaceholder.tooltip);
		images.bind('click.placeholder edit.placeholder', function(ev) {
			// call WikiaMiniUpload and provide WMU with image clicked + inform it's placeholder
			var self = this;
			WikiaEditor.load( 'WikiaMiniUpload' ).done(function() {
				RTE.tools.callFunction(window.WMU_show,$(self), {isPlaceholder: true});
			});
		});

		videos = placeholder.filter('.video-placeholder');
		videos.attr('title', RTE.getInstance().lang.videoPlaceholder.tooltip);
		videos.bind('click.placeholder edit.placeholder', function() {
			WikiaEditor.track({
				category: 'vet',
				trackingMethod: 'both',
				action: Wikia.Tracker.ACTIONS.CLICK,
				label: 'create-page-add-video'
			});
			// call VideoEmbedTool and provide VET with video clicked + inform it's placeholder
			var self = this;
			WikiaEditor.load( 'VideoEmbedTool' ).done(function() {
				RTE.tools.callFunction(window.vetWikiaEditor, $(self), {isPlaceholder: true});
			});
		});

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(placeholder);
		}
	},

	// maps media type to messages' group name
	getMediaTypeForMsg: function(media) {
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

			case 'poll':
				type = 'poll';
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
			var editor = RTE.getInstance();

			//RT#52431 - proper context
			var newMedia = $(html, editor.document.$).children('img');

			//fix for IE7, the above line of code is returning an empty element
			//since $(html) strips the enclosing <p> tag out for some reason
			if(!newMedia.exists()){
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
	update: function(media, wikitext, params) {
		var self = this;

		// render an image and replace old one
		RTE.tools.parseRTE(wikitext, function(html) {
			var editor = RTE.getInstance();

			var newMedia = $(html).children('img');

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
