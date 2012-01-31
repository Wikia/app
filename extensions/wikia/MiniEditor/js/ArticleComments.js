// Attach MiniEditor functionality to ArticleComments
jQuery(function($) {

	// Show/initialize MiniEditor when the textarea is clicked
	$('.MiniEditorWrapper .editarea textarea').bind('click.MiniEditor', function() {
		$(this).miniEditor();
	});
	
	$('#article-comments').undelegate('.article-comm-edit', 'click.ArticleComments').delegate('.article-comm-edit', 'click.MiniEditor', function(e) {
		e.preventDefault();
		var id = $(this).data('id'),
			element = $("#msg-body-"+id);
		console.log(element)
		// hide edited-by div while editor is open
		element.closest('.MiniEditorWrapper').next().hide();
		element.miniEditor();
	});
	
});