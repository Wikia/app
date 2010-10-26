$(function() {
	WikiActivity.init();
});

var WikiActivity = {

	init: function() {
		WikiActivity.track('view');

		// handle clicks on "more"
		$('.activity-feed-more').children('a').click(WikiActivity.fetchMore);

		// handle click on default view switch
		$('#wikiactivity-default-view-switch').
			removeAttr('disabled').
			click(WikiActivity.setDefaultView);

		// track clicks within activity feed
		$('#myhome-main').click(WikiActivity.trackClick);

		// catch clicks on video thumbnails and load player
		$('.activityfeed-video-thumbnail').live('click', WikiActivity.loadVideoPlayer);

		// track clicks on link to Special:RecentChanges (Oasis specific)
		$('#myhome-main').find('.activity-nav').find('a').last().trackClick('wikiactivity/recentchanges');
	},

	log: function(msg) {
		$().log(msg, 'WikiActivity');
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
		// badge (r25110 refactored)
		else if (node.hasClass('badgeName')) {
			WikiActivity.track('achievement/link');
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

	setDefaultView: function() {
		var node = $(this);
		var defaultView = node.attr('data-type');

		WikiActivity.ajax('setDefaultView', {'defaultView': defaultView}, function (data) {
			if (data.msg) {
				var parent = node.parent();

				// show message and slooowly fade out
				parent.html(data.msg);

				setTimeout(function() {
					parent.slideUp();
				}, 2000);
			}
		});
	},

	// show popup with video player when clicked on video thumbnail
	loadVideoPlayer: function(ev) {
		ev.preventDefault();

		var node = $(ev.target);
		if (node.is('img') || node.is('span')) {
			node = node.parent();
		}

		// ignore different clicks
		if (!node.hasClass('activityfeed-video-thumbnail')) {
			return;
		}

		var title = node.attr('ref');
		WikiActivity.log('loading player for ' + title);

		// catch doubleclicks on video thumbnails
		if (WikiActivity.videoPlayerLock) {
			WikiActivity.log('lock detected: video player is loading', 'WikiActivity');
			return;
		}

		WikiActivity.videoPlayerLock = true;

		WikiActivity.ajax('getVideoPlayer', {'title': title}, function(res) {
			if (res.html) {
				$.showModal(res.title, res.html, {
					'id': 'activityfeed-video-player',
					'width': res.width
				});

				// remove lock
				delete WikiActivity.videoPlayerLock;
			}
		});
	},

	// load next x entries when "more" is clicked
	fetchMore: function(ev) {
		ev.preventDefault();

		var node = $(ev.target);

		var feedContent = $('#myhome-main').children('ul').last();
		var fetchSince = node.attr('data-since');

		WikiActivity.log('fetching feed since ' + fetchSince, 'WikiActivity');
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
