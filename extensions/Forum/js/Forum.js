$(function() {
	$('#Wall').on('WallInit', function(event, wall) {

		// Get rid of default newPosted event handler
		delete wall.model.events.newPosted;

		// Bind our own
		wall.model.on('newPosted', function(newmsg) {

			// Redirect on successful post
			window.location = newmsg.find('.msg-title a').attr('href');
		});
	});

	// Hack for reply count
	var $replyCount = $('<span class="replyCount"></span>');
	$('#Forum .Board .comments > .message').each(function(i, thread) {
		var	$thread = $(thread),
			replyCount = $thread.find('.replies').children().length;

		$thread.find('.timestamp .permalink').append(
			$replyCount.clone().text(replyCount + ' ' + (replyCount > 1 ? 'replies' : 'reply')));
	});
});