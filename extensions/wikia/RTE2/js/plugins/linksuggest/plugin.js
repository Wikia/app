CKEDITOR.plugins.add('rte-linksuggest', {
	init: function(editor) {
		if (typeof jQuery.fn.linksuggest === 'function') {
			editor.on('mode', function(ev) {
				if (editor.mode === 'source') {
					debugger;
					$(editor.textarea.$).linksuggest();
				}
			});
		}
	}
});
