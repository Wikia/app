CKEDITOR.plugins.add('rte-overlay',
{
	// overlays container
	overlays: false,

	// currently shown overlay (RT #84138)
	currentOverlay: false,

	init: function(editor) {
		var self = this;

		// add plugin reference to RTE.overlay object
		RTE.overlay.plugin = this;

		// add node in which overlays will be stored
		editor.on('instanceReady', function() {
			self.overlays = $('<div>', {
				id : 'RTEMediaOverlays',
				'class' : 'rte-media-overlays'
			}).appendTo(RTE.overlayNode);
		});

		// clean overlays when switching from source to wysiwyg mode
		editor.on('wysiwygModeReady', function() {
			if (typeof self.overlays == 'object') {
				self.overlays.html('');
			}
		});

		// periodically check currently shown overlay (RT #84138)
		setInterval(function() {
			self.checkCurrentOverlay();
		}, 1000);
	},

	// periodically check currently shown overlay
	checkCurrentOverlay: function() {
		if (this.currentOverlay) {
			var node = this.currentOverlay.data('node');

			// node for currently shown overlay has been removed - remove overlay
			if (node && !node.hasParent('body')) {
				this.currentOverlay.remove();
				this.currentOverlay = false;
			}
		}
	},

	showOverlay: function(node) {
		//$().log(node, 'showOverlay');

		var overlay = this.getOverlay(node),
			position = this.getOverlayPositon(node);

		// try to keep overlay within editor's viewport (RT #139297):
		// 1. overlay goes beoynd editor's viewport - move it to the left
		var rightMargin = Math.max((position.left + overlay.width()) - RTE.getEditor().width(), 0);
		overlay.children('div'). css('right', rightMargin + 'px');

		// 2. overlay is above RTE toolbar - move it down
		var origTopPosition = position.top;
		position.top = Math.max(position.top, 0);

		// position overlay
		overlay.css({
			'left': position.left,
			'top': position.top
		});

		var menu = overlay.children().eq(0);
		menu.show();

		// don't show caption when it's going outside RTE window (RT #46409)
		var caption = overlay.children().eq(1),
			positionCaption = parseInt(position.top) + parseInt(caption.css('top')) + 16 /* caption height */;

		// reposition caption, because overlay isn't always aligned with top of image
		// eg. top part of the image is hidden above the viewport top (BugId: 43646|
		var captionMarginTop = Math.min(parseInt(origTopPosition),0);
		caption.css('margin-top',captionMarginTop+'px');

		if (positionCaption + captionMarginTop < RTE.tools.getEditorHeight()) {
			caption.show();
		}

		// show all overlays
		this.overlays.children().hide();

		// show overlay + caption wrapper
		this.currentOverlay = overlay.show();

		// clear timeout used to hide preview with small delay
		var timeoutId = node.data('hideTimeout');
		if (timeoutId) {
			clearTimeout(timeoutId);
		}
	},

	hideOverlay: function(node) {
		//$().log(node, 'hideOverlay');

		var overlay = this.getOverlay(node);

		// hide menu 100 ms after mouse is out (this prevents flickering)
		node.data('hideTimeout', setTimeout(function() {
			overlay.children().hide();
			overlay.hide();

			this.currentOverlay = false;

			node.removeData('hideTimeout');
		}, 100));
	},

	getOverlay: function(node, items) {
		var self = this;

		if (!this.overlays) {
			// we're not ready yet (function called before "instanceReady" event was fired)
			return false;
		}

		// was overlay created for given node?
		var overlay = node.data('overlay');
		if (overlay) {
			return overlay;
		}

		// create overlay
		overlay = $('<div>', {
			'class': 'RTEMediaOverlay',
			'type': node.attr('type'),
			'width': this.getImageWidth(node)
		});

		var overlayMenu = $('<div>').
			addClass('RTEMediaMenu color1').
			appendTo(overlay);

		// add overlay menu items
		var items = node.data('items');
		$(items).each(function() {
			var item = this;

			$('<span>').
				addClass(item['class']).
				html(item.label).
				bind('click', function(ev) {
					self.hideOverlay(node);
					item.callback(node);
				}).
				appendTo(overlayMenu);
		});

		// render caption (if applicable)
		var caption = this.getCaption(node);
		if (caption) {
			caption.appendTo(overlay);
		}

		// setup events
		overlay.bind({
			'mouseover': function() {
				// don't hide this menu when hovering over it
				self.showOverlay(node);
			}
			// bugid-51619: mouseout was removed to prevent overlay from being hidden when mousing into the media.
		});

		// store reference to node for which this overlay is rendered (RT #84138)
		overlay.data('node', node);

		// add overlay to the wrapper
		this.overlays.append(overlay);

		// store reference to overlay
		node.data('overlay', overlay);

		//RTE.log(overlay);
		return overlay;
	},

	getCaption: function(node) {
		// get RTE data
		var data = node.getData();

		// media with thumb of frame
		var isFramed = node.hasClass('thumb') || node.hasClass('frame');

		// render media caption
		var captionContent = (typeof data.params != 'undefined') && (data.params.captionParsed || data.params.caption);
		if (captionContent && isFramed) {

			var caption = $('<div>').
				addClass('RTEMediaCaption').
				html(captionContent).
				css({
					'top': node.outerHeight(false) - 23, // this is ghetto
					'width': node.width()
				}).
				click(function(ev) {
					// disable clicks on links inside caption
					ev.preventDefault();
				});

			if (node.hasClass('alignCenter')) {
				caption.css('left', '1px');
			}

			return caption;
		}
		else {
			return false;
		}
	},

	// get position of overlay over node
	getOverlayPositon: function(node) {
		var position = RTE.tools.getPlaceholderPosition(node);

		if (node.hasClass('media-placeholder')) {
			// image / video placeholder
			position.top += 2;
			position.left += 2;

		}
		return position;
	},

	// helper function
	getImageWidth: function(node) {
		// image with thumb of frame
		var isFramed = node.hasClass('thumb') || node.hasClass('frame');

		// image width (including paddings and borders)
		var width = node.is('img') ? parseInt(node.attr('width')) : node.innerWidth();
		if (isFramed) {
			if (CKEDITOR.env.ie && CKEDITOR.env.version <= 7) {
				// IE8-
				width += 2;
			}
			else {
				width += 8;
			}
		}

		return width + 'px';
	}
});

RTE.overlay = {
	plugin: false,

	// add overlay menu and block CKeditor context menu
	add: function(node, items) {
		var self = this.plugin;

		/*
		 * If admin-only video upload/edit is enabled for this wiki,
		 * then we don't show overlay for video items in the visual editor,
		 * preventing non-admins from editing video descriptions
		 *
		 * window.showAddVideoBtn comes from EditPageLayout/EditPageLayoutHooks.class.php
		 */
		if ( node.hasClass('video') && !window.showAddVideoBtn ) {
			return;
		}

		// store items
		node.data('items', items);

		// assign overlay to given node
		node.each(function() {
			var node = $(this)
				.removeData('overlay')
				// remove previously added event handlers
				.unbind('.overlay')
				.bind({
					'mouseover.overlay': function(ev) {
						self.showOverlay(node);
					},
					'mouseout.overlay': function(ev) {
						self.hideOverlay(node);
					},
					'contextmenu.overlay': function(ev) {
						// don't show browser's context menu
						ev.preventDefault();

						// don't show CKEditor's context menu
						ev.stopPropagation();
					}
				});
		});
	}
};
