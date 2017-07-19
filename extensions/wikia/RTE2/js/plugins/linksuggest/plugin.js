CKEDITOR.plugins.add('rte-linksuggest', {
	init: function(editor) {
		if (typeof jQuery.fn.linksuggest === 'function') {
			editor.on('mode', function(ev) {
				if (editor.mode === 'source') {
					$(editor.textarea.$).linksuggest();
				}
			});
		}
	}
});
