(function($, window){

	var $section = $('#RelatedForumDiscussion'),
		$content = $section.find('.forum-content'),
		$window = $(window);
		
	if($section.exists()) {
		$section.find('.button.forum-new-post').tooltip();
		
		/* check if content is 3 windows above */
		function isBelowTheFold() {
			return $section.offset().top > ($window.scrollTop() + ($window.height() * 3) );
		};
		
		var timeAgo = function() {
			$section.find('.forum-timestamp').timeago();
		};
		
		// if user is not logged in, check for cache, and replace if needed
		if(!window.wgUserName) {
			function loadRelatedDiscussion() {
				$.nirvana.sendRequest({
					controller: 'RelatedForumDiscussionController',
					method: 'checkData',
					type: 'GET',
					data: {
						articleId: window.wgArticleId ? window.wgArticleId:0 
					},
					callback: function(json) {
						if(json && json.replace) {
							$content.html(json.html);
						} 
						$content.removeClass('forum-invisible');
						timeAgo();
					}
				});
			}
	
			if(!isBelowTheFold()) {
				loadRelatedDiscussion();
			} else {
				$window.on('scrollstop.RelatedForumDiscussion', function() {
					if(!isBelowTheFold()) {
						$window.off('scrollstop.RelatedForumDiscussion');
						loadRelatedDiscussion();
					}
				});
			}
	
		} else {
			timeAgo();
		}
	}
	
})(jQuery, window);