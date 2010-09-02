$(function() {
	WikiActivity.init();
});

var WikiActivity = {

	init: function() {
		WikiActivity.track('view');

		// handle clicks on "more"
		$('.activity-feed-more').children('a').click(WikiActivity.fetchMore);

		// track clicks within activity feed
		$('#myhome-activityfeed').click(WikiActivity.trackClick);

		// track clicks on link to Special:RecentChanges (Oasis specific)
		$('#WikiaPageHeader').find('a').trackClick('wikiactivity/recentchanges');
	},

	ajax: function(method, params, callback) {
		$.getJSON(wgScript + '?action=ajax&rs=MyHomeAjax&method=' + method, params, callback);
	},

	track: function(fakeUrl) {
		$.tracker.byStr('wikiactivity/' + fakeUrl);
	},

	trackClick: function(ev) {
		var node = $(ev.target);

		// fix for images inside links
		if (node.is('img') || node.is('span') /* video play icon */) {
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
	},

	// load next x entries when "more" is clicked
	fetchMore: function(ev) {
		ev.preventDefault();

		var node = $(ev.target);

		var feedContent = $('#myhome-activityfeed');
		var fetchSince = node.attr('data-since');

		$().log('fetching feed since ' + fetchSince, 'WikiActivity');
		WikiActivity.track('more');

		// get the data
		WikiActivity.ajax('getFeed', {
			'type': 'activity',
			'since': fetchSince
		}, function(data) {
			if (data.html) {
				// add rows
				$(data.html).insertAfter(feedContent);

				// show more?
				if (data.fetchSince) {
					// store new timestamp to fetch from
					node.attr('data-since', data.fetchSince);
				}
				else {
					// remove "more" link
					node.parent().remove();
				}
			}
		});
	}
};
