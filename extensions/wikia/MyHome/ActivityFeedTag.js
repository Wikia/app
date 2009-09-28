var ActivityFeedTag = {};

// setup onclick events for image/video thumbnails
ActivityFeedTag.setupThumbnails = function(node) {
	$(node).find('.myhome-image-thumbnail').click(ActivityFeedTag.loadFullSizeImage);
	$(node).find('.myhome-video-thumbnail').click(ActivityFeedTag.loadVideoPlayer);
}

ActivityFeedTag.ajax = function(method, params, callback) {
	$.getJSON(wgScript + '?action=ajax&rs=MyHomeAjax&method=' + method, params, callback);
}


ActivityFeedTag.loadVideoPlayer = function(ev) {
	ev.preventDefault();

	var title = $(this).attr('title');

	// catch doubleclicks on video thumbnails
	if (ActivityFeedTag.videoPlayerLock) {
		return;
	}

	ActivityFeedTag.videoPlayerLock = true;

	ActivityFeedTag.ajax('getVideoPlayer', {'title': title}, function(res) {
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
			delete ActivityFeedTag.videoPlayerLock;
		}
	});
}


ActivityFeedTag.loadFullSizeImage = function(ev) {
	ev.preventDefault();

	var title = $(this).attr('title');
	var timestamp = $(this).attr('ref');

	timestamp = parseInt(timestamp) ? timestamp : 0;

	// catch doubleclicks on video thumbnails
	if (ActivityFeedTag.imagePreviewLock) {
		return;
	}

	ActivityFeedTag.imagePreviewLock = true;

	ActivityFeedTag.ajax('getImagePreview', {
		'title': title,
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
			delete ActivityFeedTag.imagePreviewLock;
		}
	});
}


wgAfterContentAndJS.push(function() {
	ActivityFeedTag.setupThumbnails($('.myhome-feed'));
});