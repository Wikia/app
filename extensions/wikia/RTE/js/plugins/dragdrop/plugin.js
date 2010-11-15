CKEDITOR.plugins.add('rte-dragdrop',
{
	// delay re-init of editor area when drag&drop is finished (in ms)
	timeout: 250,

	onDrop: function(ev) {
		RTE.log('drag&drop finished');

		// reinitialize wysiwyg mode
		setTimeout(function() {
			RTE.instance.fire('wysiwygModeReady');

			// get dropped element (and remove marking attribute)
			var droppedElement = RTE.getEditor().find('[data-rte-dragged]').removeAttr('data-rte-dragged');

			RTE.log('dropped element:');
			RTE.log(droppedElement);

			RTE.instance.fire('saveSnapshot');

			// extra check for RT #36064
			var content = RTE.instance.getData();
			if (content == '') {
				RTE.log('undoing drag&drop');
				RTE.instance.execCommand('undo');
			}

			// get coordinates from "dragdrop" event and send it with "dropped" event
			// @see http://www.quirksmode.org/js/events_properties.html#position
			var extra = {
				pageX: (ev.pageX ? ev.pageX : ev.clientX),
				pageY: (ev.pageY ? ev.pageY : ev.clientY)
			};

			// trigger custom event handler (IE freezes here)
			if (!CKEDITOR.env.ie) {
				droppedElement.trigger('dropped', [extra]);
			}

		}, this.timeout);
	},

	onDrag: function(ev) {
		// create undo point (RT #36064)
		RTE.instance.fire('saveSnapshot');
		RTE.log('drag&drop: undo point');

		// "mark" dragged element
		var target = $(ev.target);
		target.attr('data-rte-dragged', true);

		// trigger custom event
		target.trigger('dragged');

		// fix for Chrome
		RTE.instance.fire('wysiwygModeReady');
	},

	onDuringDragDrop: function(ev) {
		var scrollStep = 15;
		var scrollSpace = 50;

		var editorHeight = parseInt($('#cke_contents_wpTextbox1').height());
		var editorWindow = RTE.instance.window.$;

		// get position of vertical scroll
		var scrollY = (CKEDITOR.env.ie ? editorWindow.document.body.parentNode.scrollTop : editorWindow.scrollY);

		// get mouse cursor position (relative to the editor window)
		var cursorY = (ev.pageY ? ev.pageY : ev.clientY) - scrollY;

		// mouse is above the editor
		if (cursorY < scrollSpace) {
			editorWindow.scrollBy(0, -scrollStep);
		}
		// mouse is below the editor
		else if (cursorY >= editorHeight - scrollSpace) {
			editorWindow.scrollBy(0, scrollStep);
		}
	},

	init: function(editor) {
		var self = this;

		// setup drag&drop support
		editor.on('wysiwygModeReady', function() {
			// fire "dropped" custom event when element is drag&drop-ed
			// mark dragged element with data-rte-dragged attribute
			//
			// @see https://developer.mozilla.org/en/DragDrop/Drag_and_Drop (new version - Fx3.5+)
			// @see https://developer.mozilla.org/en/Drag_and_Drop (old version - Fx3.0)
			//
			$(editor.document.$).
				unbind('.dnd').

				// for new Fx (3.5+)
				//
				bind('dragstart.dnd', self.onDrag).

				bind('drop', self.onDrop).

				// for old Fx (3.0-)
				//
				bind('dragdrop.dnd', self.onDrop).

				// user clicked on placeholder / image
				// this can be beginning of drag&drop
				bind('mousedown.dnd', self.onDrag).

				// ok, so this wasn't drag&drop, just a click on placeholder / image
				bind('mouseup.dnd', function(ev) {
					var target = $(ev.target);

					// remove "marking" attribute
					target.removeAttr('data-rte-dragged');

					// remove selection box
					ev.preventDefault();
				}).

				// prevent resize box - RT #33853
				bind('dblclick.dnd', function(ev) {
					if (CKEDITOR.env.gecko) {
						var target = $(ev.target);

						// apply fix only for placeholders and images
						if ( !!target.filter('img').attr('type') ) {
							RTE.tools.removeResizeBox();
						}
					}
				}).

				// handle editor scrolling during drag&drop (RT #37709)
				bind('dragover.dnd', self.onDuringDragDrop);

			// for IE
			if (CKEDITOR.env.ie) {
				RTE.getEditor().
					bind('drop',self.onDrop).
					bind('dragover', self.onDuringDragDrop);
			}
		});
	}
});
