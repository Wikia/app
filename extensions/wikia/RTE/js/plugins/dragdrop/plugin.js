CKEDITOR.plugins.add('rte-dragdrop',
{
	onDrop: function(ev) {
		setTimeout(function() {
			RTE.log(ev);

			// get dragged element
			var draggedElement = RTE.getEditor().find('[_rte_dragged]');

			RTE.log('drag&drop: dropped');
			RTE.log(draggedElement);

			// get coordinates from "dragdrop" event and send it with "dropped" event
			// @see http://www.quirksmode.org/js/events_properties.html#position
			var extra = {
				pageX: (ev.pageX ? ev.pageX : ev.clientX),
				pageY: (ev.pageY ? ev.pageY : ev.clientY)
			};

			// remove "marking" attribute and trigger event handler
			RTE.log('drag&drop: triggering "dropped" event...');
			draggedElement.removeAttr('_rte_dragged').trigger('dropped', extra);
		}, 500);
	},

	init: function(editor) {
		var self = this;

		// setup drag&drop support
		editor.on('wysiwygModeReady', function() {
			// fire "dropped" custom event when element is drag&drop-ed
			// mark dragged element with _rte_dragged attribute
			RTE.getEditor().
				unbind('.dnd').
				bind('dragdrop.dnd', self.onDrop).
				bind('mousedown.dnd', function(ev) {
					var target = $(ev.target);

					// "mark" dragged element
					target.attr('_rte_dragged', true);
				}).
				bind('mouseup.dnd', function(ev) {
					var target = $(ev.target);

					// remove "marking" attribute
					target.removeAttr('_rte_dragged');
				});
		});
	}
});
