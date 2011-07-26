CKEDITOR.plugins.add('rte-accesskey',
{
	init: function(editor) {
		if (CKEDITOR.env.ie) {
			var accessibleElements = [];
			$('*[accesskey]').each(function(ev) {
				accessibleElements[$(this).attr('accesskey').toUpperCase()] = $(this);
			});
			RTE.getEditor().bind('keydown', function(e) {
				var key = String.fromCharCode(e.keyCode).toUpperCase();
				if (e.altKey && accessibleElements[key]) {
					accessibleElements[key].click();
				}
			});
		}
	}
});
