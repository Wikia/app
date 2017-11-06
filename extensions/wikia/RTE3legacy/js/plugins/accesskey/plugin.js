CKEDITOR.plugins.add('rte-accesskey',
{
	init: function(editor) {
		if (CKEDITOR.env.ie) {
			var accessibleElements = [];
			$('*[accesskey]').each(function(ev) {
				accessibleElements[$(this).attr('accesskey').toUpperCase()] = $(this);
			});
			editor.on('wysiwygModeReady', function() {
				RTE.getEditor().unbind('.accesskey').bind('keydown.accesskey', function(e) {
					var key = String.fromCharCode(e.keyCode).toUpperCase();
					if (e.altKey && accessibleElements[key]) {
						accessibleElements[key].click();
					}
				});
			});
		}
	}
});
