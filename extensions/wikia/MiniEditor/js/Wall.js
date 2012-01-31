// Attach MiniEditor functionality to Wall
jQuery(function($) {
	var wall = $('#Wall');

	// Get rid of the Wall's autoResize stuff
	// (internally, the plugin uses the 'dynSiz' namespace)
	wall.unbind('.dynSiz');

	// Show/initialize MiniEditor
	$('#WallMessageBody, .new-reply textarea')
		// FIXME: I think this should be using live() and die() instead of bind() and unbind() because .new-reply is ajaxed
		.unbind('focus.Wall blur.Wall').bind('focus.MiniEditor', function() {
			$(this).miniEditor();
		});

	// Post new message
	$('#WallMessageSubmit')
		.unbind('click.Wall').bind('click.MiniEditor', function() {
			var editor = WikiaEditor.getInstance('WallMessageBody');

			this.postNewMessageRequest({
				body: editor.getContent(),
				messagetitle: $('#WallMessageTitle').val(),
				username: this.username

			}, function(data) {
				editor.fire('editorClear');
				editor.fire('editorDeactivated');
			});
		});
});