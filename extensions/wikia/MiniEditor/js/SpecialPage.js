jQuery(function($) {
	$('.TextareaToReplace').bind('click.MiniEditor', function(e) {
		$(this).miniEditor();
	})
	$('#MiniEditorEditButton').bind('click.MiniEditor', function(e) {
		$('#MiniEditorTwo').miniEditor();
		$(this).slideUp();
	})
});