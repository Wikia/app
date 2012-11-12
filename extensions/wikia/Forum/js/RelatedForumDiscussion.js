(function($, window){

	var section = $('#RelatedForumDiscussion');
	section.find('.button.forum-new-post').tooltip();
	
	// if user is not logged in, check for cache, and replace if needed
	if(!window.wgUserName) {
		$.nirvana.sendRequest({
			controller: 'RelatedForumDiscussionController',
			method: 'checkData',
			format: 'json',
			data: {
				articleTitle: 'Kermit'
			},
			callback: function(json) {
				section.removeClass('forum-invisible');
				if(json && json.replace) {
					section.replaceWith(json.html);
				}
			}
		});
	}
	
})(jQuery, window);