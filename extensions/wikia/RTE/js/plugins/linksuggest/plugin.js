CKEDITOR.plugins.add('rte-linksuggest',
{
	dataSource: false,

	init: function(editor) {
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

		window.LS_PrepareTextarea('RTEtextarea', this.dataSource);
	}
});
