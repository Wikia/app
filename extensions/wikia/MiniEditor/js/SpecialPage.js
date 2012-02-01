jQuery(function($) {
	$('.ElementToReplace').bind('click.MiniEditor', function(e) {
		$(this).miniEditor();
	})
});