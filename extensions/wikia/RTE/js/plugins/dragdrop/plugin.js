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
			var droppedElement = RTE.getEditor().find('[_rte_dragged]').removeAttr('_rte_dragged');

			RTE.log('dropped element:');
			RTE.log(droppedElement);
/*
			// get coordinates from "dragdrop" event and send it with "dropped" event
			// @see http://www.quirksmode.org/js/events_properties.html#position
			var extra = {
				pageX: (ev.pageX ? ev.pageX : ev.clientX),
				pageY: (ev.pageY ? ev.pageY : ev.clientY)
			};

			// trigger custom event handler
			droppedElement.trigger('dropped');
*/

		}, this.timeout);
	},

	init: function(editor) {
		var self = this;

		// setup drag&drop support
		editor.on('wysiwygModeReady', function() {
			// fire "dropped" custom event when element is drag&drop-ed
			// mark dragged element with _rte_dragged attribute
			//
			// @see https://developer.mozilla.org/en/DragDrop/Drag_and_Drop (new version - Fx3.5+)
			// @see https://developer.mozilla.org/en/Drag_and_Drop (old version - Fx3.0)
			//
			$(editor.document.$).
				unbind('.dnd').

				// for new Fx (3.5+)
				//
				bind('dragstart.dnd', function(ev) {
					// "mark" dragged element
					var target = $(ev.target);
					target.attr('_rte_dragged', true);

					// trigger custom event
					target.trigger('dragged');
				}).

				bind('drop', self.onDrop).

				// for old Fx (3.0-)
				//
				bind('dragdrop.dnd', self.onDrop).

				// user clicked on placeholder / image
				// this can be beginning of drag&drop
				bind('mousedown.dnd', function(ev) {
					// "mark" dragged element
					var target = $(ev.target);
					target.attr('_rte_dragged', true);

					// trigger custom event
					target.trigger('dragged');
				}).

				// ok, so this wasn't drag&drop, just a click on placeholder / image
				bind('mouseup.dnd', function(ev) {
					var target = $(ev.target);

					// remove "marking" attribute
					target.removeAttr('_rte_dragged');

					// remove selection box
					ev.preventDefault();
				}).

				// stop double click events (prevent resize box)
				bind('dblclick.dnd', function(ev) {
					RTE.log(ev);
					ev.preventDefault();
				});

			// for IE
			//
			RTE.getEditor()[0].ondrop = self.onDrop;
		});
	}
});
