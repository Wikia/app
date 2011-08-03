CKEDITOR.plugins.add('rte-linksuggest',
{
	init: function(editor) {
		// setup events
		var self = this;
		editor.on('instanceReady', function(ev) {
			self.setupLinkSuggest();
		});
		editor.on('mode', function(ev) {
			self.setupLinkSuggest();
		});
	},

	// get source mode textarea and setup link suggest
	setupLinkSuggest: function() {
		// only run init when in source mode
		if (RTE.instance.mode != 'source') {
			return;
		}
		// get source mode textarea
		var textarea = $(RTE.instance.textarea.$);
		textarea.attr('id', 'RTEtextarea');
		$(RTE.instance.textarea.$).css( 'font-family', 'monospace' ).linksuggest();
	}
});
