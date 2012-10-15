var WikiActivity = {
	feedType: false,
	wrapper: false,

	init: function() {
		WikiActivity.wrapper = $('#wikiactivity-main');

		// activity / watchlist
		WikiActivity.feedType = WikiActivity.wrapper.attr('data-type');

		// handle clicks on "more"
		$('.activity-feed-more').children('a').click(WikiActivity.fetchMore);

		// handle click on default view switch
		$('#wikiactivity-default-view-switch').
			removeAttr('disabled').
			click(WikiActivity.setDefaultView);
	},

	ajax: function(method, params, callback) {
		$.getJSON(wgScript + '?action=ajax&rs=MyHomeAjax&method=' + method, params, callback);
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

	// load next x entries when "more" is clicked
	fetchMore: function(ev) {
		ev.preventDefault();

		var node = $(ev.target);

		var feedContent = WikiActivity.wrapper.children('ul').last();
		var fetchSince = node.attr('data-since');

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

$(function() {
	WikiActivity.init();
});