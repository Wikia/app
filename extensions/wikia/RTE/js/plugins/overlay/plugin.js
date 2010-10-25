CKEDITOR.plugins.add('rte-overlay',
{
	// overlays container
	overlays: false,

	init: function(editor) {
		var self = this;

		// add plugin reference to RTE.overlay object
		RTE.overlay.plugin = this;

		// add node in which overlays will be stored
		editor.on('instanceReady', function() {
			self.overlays = $('<div>', {id : 'RTEMediaOverlays'}).
				appendTo($('#RTEStuff'));
		});

		// clean overlays when switching from source to wysiwyg mode
		editor.on('wysiwygModeReady', function() {
			if (typeof self.overlays == 'object') {
				self.overlays.html('');
			}
		});
	},

	showOverlay: function(node) {
		//$().log(node, 'showOverlay');

		var overlay = this.getOverlay(node);
		var position = this.getOverlayPositon(node);

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

		// show overlay + caption wrapper
		overlay.show();

		// clear timeout used to hide preview with small delay
		if (timeoutId = node.data('hideTimeout')) {
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
			},
			'mouseout': function() {
				// hide this menu
				self.hideOverlay(node);
			}
		});

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

		// image with thumb of frame
		var isFramed = node.hasClass('thumb') || node.hasClass('frame');

		// render image caption
		var captionContent = (typeof data.params != 'undefined') && (data.params.captionParsed || data.params.caption);
		if (captionContent && isFramed) {
			var captionTop = parseInt(node.attr('height') + 7);
			var captionWidth = node.attr('width');

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
		else {
			// take image margins into consideration
			if ( node.hasClass('thumb') || node.hasClass('frame') ) {
				position.top += 6;

				if (!node.hasClass('alignLeft')) {
					position.left += 18;
				}
			}
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

		// store items
		node.data('items', items);

		// assign overlay to given node
		node.each(function(i,el){
			el = $(el)
				.removeData('overlay')
				// remove previously added event handlers
				.unbind('.overlay')
				.bind({
					'mouseover.overlay': function(ev) {
						self.showOverlay(el);
					},
					'mouseout.overlay': function(ev) {
						self.hideOverlay(el);
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
