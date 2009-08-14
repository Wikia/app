var MyHome = {};

// timestamps to fetch feeds since
MyHome.fetchSince = {};

// send AJAX request to MyHome Ajax dispatcher in MW
MyHome.ajax = function(method, params, callback) {
	$.getJSON(wgScript + '?action=ajax&rs=MyHomeAjax&method=' + method, params, callback);
}

// track events
MyHome.track = function(fakeUrl) {
	WET.byStr('myhome' + fakeUrl);
}

// console logging
MyHome.log = function(msg) {
	$().log(msg, 'MyHome');
}

// show popup with video player when clicked on video thumbnail
MyHome.loadVideoPlayer = function(ev) {
	ev.preventDefault();

	var title = $(this).attr('title');

	// catch doubleclicks on video thumbnails
	if (MyHome.videoPlayerLock) {
		MyHome.log('lock detected: video player is loading');
		return;
	}

	MyHome.videoPlayerLock = true;

	MyHome.ajax('getVideoPlayer', {'title': title}, function(res) {
		// replace thumbnail with video preview
		if (res.html) {
			// open modal
			title = title.replace(/_/g, ' ');
			$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
				var html = '<div id="myhome-video-player" title="' + title  +'">' + res.html + '</div>';
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

	var title = $(this).attr('title');
	var timestamp = $(this).attr('ref');

	// catch doubleclicks on video thumbnails
	if (MyHome.imagePreviewLock) {
		MyHome.log('lock detected: full-size image is loading');
		return;
	}

	MyHome.imagePreviewLock = true;

	MyHome.ajax('getImagePreview', {
		'title': 'File:' + title,
		'timestamp': timestamp,
		'maxwidth': $.getViewportWidth(),
		'maxheight': $.getViewportHeight()
	}, function(res) {
		// replace thumbnail with video preview
		if (res.html) {
			// open modal
			title = title.replace(/_/g, ' ');
			$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
				var html = '<div id="myhome-image-preview" title="' + title  +'">' + res.html + '</div>';
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

	var feedContent = $('#myhome-' + feedType + '-feed-content');
	var fetchSince = MyHome.fetchSince[feedType];

	MyHome.log('fetching ' + feedType + ' since ' + fetchSince);

	// show loading indicator
	feedContent.parent().addClass('myhome-feed-loading');

	// get the data
	MyHome.ajax('getFeed', {
		'type': feedType,
		'since': fetchSince
	}, function(data) {
		MyHome.log(data);

		if (data.html) {
			// add rows
			feedContent.append(data.html);

			// setup onclicks on thumbnails
			MyHome.setupThumbnails(feedContent);

			// store new timestamp
			MyHome.fetchSince[feedType] = data.last_timestamp;
		}

		// remove loading indicator
		feedContent.parent().removeClass('myhome-feed-loading');
	});
}

MyHome.setupThumbnails = function(node) {
	$(node).find('.myhome-image-thumbnail').click(MyHome.loadFullSizeImage);
	$(node).find('.myhome-video-thumbnail').click(MyHome.loadVideoPlayer);

	MyHome.log('thumbnails setup');
}

jQuery(function() {
	MyHome.setupThumbnails($('.myhome-feed'));
});
