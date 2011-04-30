CKEDITOR.plugins.add('rte-edit-buttons',
{
	init: function(editor) {
		// enable edit buttons and add tracking code
		editor.on('instanceReady', function() {
			var buttons = $('#wpSave,#wpPreview,#wpDiff');

			buttons.attr('disabled', false);

			buttons.bind('click', function() {
				var id = $(this).attr('id');
				id = id.substring(2).toLowerCase();

				RTE.track(id, editor.mode + 'Mode');
			});
		});
	}
});
