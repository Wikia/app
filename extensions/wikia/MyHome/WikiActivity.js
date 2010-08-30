$(function() {
	WikiActivity.init();
});

var WikiActivity = {

	init: function() {
		WikiActivity.track('view');

		// track clicks within activity feed
		$('#myhome-activityfeed').click(WikiActivity.trackClick);

		// track clicks on link to Special:RecentChanges (Oasis specific)
		$('#WikiaPageHeader').find('a').trackClick('wikiactivity/recentchanges');
	},

	track: function(fakeUrl) {
		$.tracker.byStr('wikiactivity/' + fakeUrl);
	},

	trackClick: function(ev) {
		var node = $(ev.target);

		// fix for images inside links
		if (node.is('img')) {
			node = node.parent();
		}

		// track clicks on links only
		if (!node.is('a')) {
			return;
		}

		// page title
		if (node.hasClass('title')) {
			WikiActivity.track('item');
		}
		// diff link
		else if (node.hasClass('activityfeed-diff')) {
			WikiActivity.track('diff');
		}
		// user name
		else if (node.parent().is('cite')) {
			WikiActivity.track('user');
		}
		// detail links (categories, images, videos)
		else if (node.hasParent('tr[data-type]')) {
			var type = node.closest('tr').attr('data-type');

			switch (type) {
				case 'inserted-category':
					WikiActivity.track('category');
					break;

				case 'inserted-image':
					WikiActivity.track('image');
					break;

				case 'inserted-video':
					WikiActivity.track('video');
					break;
			}
		}
	}
};
