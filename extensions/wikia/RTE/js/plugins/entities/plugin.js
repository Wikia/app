CKEDITOR.plugins.add('rte-entities',
{
	insideEntitySpan: false,

	init: function(editor) {
		var self = this;

		editor.on('selectionChange', function(ev) {
			var selection = ev.data.selection;
			var element = selection.getStartElement();

			// check for span with entity attribute
			if (element.hasAttribute('_rte_entity')) {
				var entity = element.getAttribute('_rte_entity');
				RTE.log('entity span: &' + entity + ';');

				self.insideEntitySpan = true;

				// TODO: leave span
			}
			else {
				if (self.insideEntitySpan) {
					RTE.log('entity span: leaving...');
				}

				self.insideEntitySpan = false;
			}
		});
	}
});
