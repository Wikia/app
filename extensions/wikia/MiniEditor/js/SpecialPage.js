jQuery(function($) {

	// New Message and Reply
	$('textarea.body').bind('click.MiniEditor', function(e) {
		$(this).miniEditor();
	});

	// Edit
	var edit = $('#Edit'),
		editBody = edit.find('.body'),
		editButtons = edit.find('.buttons');

	// Edit button show/hide
	edit.bind('mouseover.MiniEditor', function(e) {
		editButtons.show();

	}).bind('mouseout.MiniEditor', function(e) {
		editButtons.hide();
	});

	// Edit initialization
	editButtons.find('button').bind('click.MiniEditor', function(e) {

		// Hide buttons and reset them to normal buttons
		editButtons.hide();
		$(this).removeClass('wikia-menu-button contribute secondary');

		// Get rid of hover events
		edit.unbind('mouseover.MiniEditor mouseout.MiniEditor');

		// Initialize
		editBody.miniEditor();
	});
});