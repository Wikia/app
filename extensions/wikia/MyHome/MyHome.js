var MyHome = {};

// timestamps to fetch feeds since
MyHome.fetchSince = {};

// prefix used for tracking
MyHome.trackerRoot = 'MyHome';

// send AJAX request to MyHome Ajax dispatcher in MW
MyHome.ajax = function(method, params, callback) {
	$.getJSON(wgScript + '?action=ajax&rs=MyHomeAjax&method=' + method, params, callback);
}

// track events
MyHome.track = function(fakeUrl) {
	WET.byStr(MyHome.trackerRoot + fakeUrl);
}

// console logging
MyHome.log = function(msg) {
	$().log(msg, MyHome.trackerRoot);
}

// show popup with video player when clicked on video thumbnail
MyHome.loadVideoPlayer = function(ev) {
	ev.preventDefault();

	var url = $(this).attr('ref');
	var desc = $(this).attr('title');

	// catch doubleclicks on video thumbnails
	if (MyHome.videoPlayerLock) {
		MyHome.log('lock detected: video player is loading');
		return;
	}

	MyHome.videoPlayerLock = true;

	MyHome.ajax('getVideoPlayer', {'title': url}, function(res) {
		// replace thumbnail with video preview
		if (res.html) {
			// open modal
			desc = desc.replace(/_/g, ' ');
			$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
				var html = '<div id="myhome-video-player" title="' + desc  +'">' + res.html + '</div>';
				$("#positioned_elements").append(html);
				$('#myhome-video-player').makeModal({
					'id': 'myhome-video-player-popup',
					'width': res.width
				});
			});

			// remove lock
			delete MyHome.videoPlayerLock;
		}
	});
}

// show popup with full-size image when clicked on image thumbnail
MyHome.loadFullSizeImage = function(ev) {
	ev.preventDefault();

	var url = $(this).attr('ref');
	var desc = $(this).attr('title');
	var timestamp = $(this).attr('ref');

	timestamp = parseInt(timestamp) ? timestamp : 0;

	// catch doubleclicks on video thumbnails
	if (MyHome.imagePreviewLock) {
		MyHome.log('lock detected: full-size image is loading');
		return;
	}

	MyHome.imagePreviewLock = true;

	MyHome.ajax('getImagePreview', {
		'title': url,
		'timestamp': timestamp,
		'maxwidth': $.getViewportWidth(),
		'maxheight': $.getViewportHeight()
	}, function(res) {
		// replace thumbnail with video preview
		if (res.html) {
			// open modal
			desc = desc.replace(/_/g, ' ');
			$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
				var html = '<div id="myhome-image-preview" title="' + desc  +'">' + res.html + '</div>';
				$("#positioned_elements").append(html);
				$('#myhome-image-preview').makeModal({
					'id': 'myhome-image-preview-popup',
					'width': res.width
				});
			});

			// remove lock
			delete MyHome.imagePreviewLock;
		}
	});
}


// load next x entries when "more" is clicked
MyHome.fetchMore = function(node) {
	var feedType = node.id.split('-')[1];

	var feedContent = $("#myhome-main").find(".activityfeed:last");
	var fetchSince = MyHome.fetchSince[feedType];

	MyHome.log('fetching ' + feedType + ' since ' + fetchSince);

	// show loading indicator
	feedContent.parent().addClass('myhome-feed-loading');

	// get the data
	MyHome.ajax('getFeed', {
		'type': feedType,
		'since': fetchSince
	}, function(data) {
		if (data.html) {
			// add rows
			$(data.html).insertAfter(feedContent);

			// setup onclicks on thumbnails
			MyHome.setupThumbnails(feedContent);

			// show more?
			if (data.fetchSince) {
				// store new timestamp to fetch from
				MyHome.fetchSince[feedType] = data.fetchSince;
			}
			else {
				// remove "more" link
				$('#myhome-' + feedType + '-feed-more').parent().remove();
			}
		}

		// remove loading indicator
		feedContent.parent().removeClass('myhome-feed-loading');
	});
}

// setup onclick events for image/video thumbnails
MyHome.setupThumbnails = function(node) {
	$(node).find('.activityfeed-image-thumbnail').click(MyHome.loadFullSizeImage);
	$(node).find('.activityfeed-video-thumbnail').click(MyHome.loadVideoPlayer);

	MyHome.log('thumbnails setup');
}

// set default feed
MyHome.setDefaultView = function() {
	var node = $(this);
	var defaultView = node.attr('name');

	MyHome.ajax('setDefaultView', {'defaultView': defaultView}, function (data) {
		if (data.msg) {
			// show message and slooowly fade out
			$(node).parent().html(data.msg).fadeOut(2000);
		}
	});
}

MyHome.trackClick = function(e) {
	var target = getTarget(e);
	if(target.id == 'myhome-feed-switch-default-checkbox') {
		MyHome.track('/toggle/default/' + MyHome.mode);
	} else if($.nodeName(target, 'a')) {
		if(target.parentNode.id == 'myhome-community-corner-edit') {
			MyHome.track('/communitycorner-edit');
		} else if(target.parentNode.id == 'myhome-feed-switch') {
			MyHome.track('/toggle/' + ((MyHome.mode == 'activity') ? 'watchlist' : 'activity'));
		} else if($(target).hasClass('title') && target.parentNode.parentNode.parentNode.parentNode.id == 'myhome-' + MyHome.mode + '-feed-content') {
			MyHome.track('/' + MyHome.mode + '/item');
		} else if($(target).hasClass('title') && target.parentNode.parentNode.parentNode.id == 'myhome-user-contributions-feed-content') {
			MyHome.track('/contributions/item');
		} else if($.nodeName(target.parentNode, 'CITE') && target.parentNode.parentNode.parentNode.parentNode.id == 'myhome-' + MyHome.mode + '-feed-content') {
			MyHome.track('/' + MyHome.mode + '/user');
		} else if($(target.parentNode.previousSibling).hasClass('activityfeed-details-label')) {
			MyHome.track('/' + MyHome.mode + '/category');
		} else if(target.parentNode.parentNode.parentNode.parentNode.id == 'myhome-hot-spots-feed-content') {
			MyHome.track('/hotspots/item');
		} else if(target.id == 'myhome-' + MyHome.mode + '-feed-more') {
			MyHome.track('/' + MyHome.mode + '/seemore');
		}
	} else if($.nodeName(target, 'img')) {
		if($.nodeName(target.parentNode, 'a')) {
			if($(target.parentNode).hasClass('activityfeed-diff')) {
				if(target.parentNode.parentNode.parentNode.parentNode.id == 'myhome-user-contributions-feed-content') {
					MyHome.track('/contributions/diff');
				} else {
					MyHome.track('/' + MyHome.mode + '/diff');
				}
			} else if($(target.parentNode).hasClass('activityfeed-image-thumbnail')) {
				MyHome.track('/' + MyHome.mode + '/image');
			}
		}
	} else if($.nodeName(target, 'span') && $.nodeName(target.parentNode, 'a') && $(target.parentNode).hasClass('activityfeed-video-thumbnail')) {
		MyHome.track('/' + MyHome.mode + '/video');
	}
}

// init onclicks
jQuery(function() {
	if ($('#activityfeed-wrapper').exists()) {
		// Special:ActivityFeed
		MyHome.mode = 'activity';

		// change prefix used for tracking and logging
		MyHome.trackerRoot = 'ActivityFeedPage';
	}
	else {
		// Special:MyHome
		MyHome.mode = ($("#myhome-main").children().filter("[id$='-feed-content']").attr("id") == "myhome-activity-feed-content") ? "activity" : "watchlist";
	}

	MyHome.setupThumbnails($('.activityfeed'));
	$('#myhome-feed-switch-default-checkbox').removeAttr('disabled').click(MyHome.setDefaultView);
	$('#myhome-wrapper').click(MyHome.trackClick);
	MyHome.track('/view/' + MyHome.mode);
});
