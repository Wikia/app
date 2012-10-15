CKEDITOR.plugins.add('rte-linksuggest',
{
	dataSource: false,
	init: function(editor) {
		this.initWikiaLinkSuggest(editor);
		this.initMediaWikiLinkSuggest(editor);
	},

	initWikiaLinkSuggest: function(editor) {
		// check whether LinkSuggest extension is initialized
		if (typeof window.LS_PrepareTextarea != 'function') {
			return;
		}

		// setup data source for link suggest
		this.dataSource = new window.YAHOO.widget.DS_XHR(window.wgServer + window.wgScriptPath, ["\n"]);
		this.dataSource.responseType = window.YAHOO.widget.DS_XHR.TYPE_FLAT;
		this.dataSource.scriptQueryAppend = 'action=ajax&rs=getLinkSuggest';

		// setup events
		var self = this;

		editor.on('mode', function(ev) {
			// only run init when in source mode
			if (editor.mode != 'source') {
				return;
			}
			// get source mode textarea
			var textarea = $(editor.textarea.$);
			textarea.attr('id', 'RTEtextarea');
			window.LS_PrepareTextarea('RTEtextarea', self.dataSource);
		});
	},

	initMediaWikiLinkSuggest: function(editor) {
		if (typeof $.fn.linksuggest == 'function') {
			editor.on('mode', function(ev) {
				if (editor.mode == 'source') {
					var textarea = $(editor.textarea.$);
					textarea
						.attr('id', 'RTEtextarea')
						.css( 'font-family', 'monospace' )
						.linksuggest();
				}
			});
		}
	}
});
