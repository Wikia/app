var ActivityFeedTag = {};

// setup onclick events for image/video thumbnails
ActivityFeedTag.setupThumbnails = function(node) {
	$(node).find('.activityfeed-image-thumbnail').click(ActivityFeedTag.loadFullSizeImage);
	$(node).find('.activityfeed-video-thumbnail').click(ActivityFeedTag.loadVideoPlayer);
}

ActivityFeedTag.ajax = function(method, params, callback) {
	$.getJSON(wgScript + '?action=ajax&rs=MyHomeAjax&method=' + method, params, callback);
}


ActivityFeedTag.loadVideoPlayer = function(ev) {
	ev.preventDefault();

	var url = $(this).attr('ref');
	var desc = $(this).attr('title');

	// catch doubleclicks on video thumbnails
	if (ActivityFeedTag.videoPlayerLock) {
		return;
	}

	ActivityFeedTag.videoPlayerLock = true;

	ActivityFeedTag.ajax('getVideoPlayer', {'title': url}, function(res) {
		// replace thumbnail with video preview
		if (res.html) {
			// open modal
			desc = desc.replace(/_/g, ' ');
			$.loadModalJS(function() {
				var html = '<div id="myhome-video-player" title="' + desc  +'">' + res.html + '</div>';
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

	var url = $(this).attr('ref');
	var desc = $(this).attr('title');
	var timestamp = $(this).attr('ref');

	timestamp = parseInt(timestamp) ? timestamp : 0;

	// catch doubleclicks on video thumbnails
	if (ActivityFeedTag.imagePreviewLock) {
		return;
	}

	ActivityFeedTag.imagePreviewLock = true;

	ActivityFeedTag.ajax('getImagePreview', {
		'title': url,
		'timestamp': timestamp,
		'maxwidth': $.getViewportWidth(),
		'maxheight': $.getViewportHeight()
	}, function(res) {
		// replace thumbnail with video preview
		if (res.html) {
			// open modal
			desc = desc.replace(/_/g, ' ');
			$.loadModalJS(function() {
				var html = '<div id="myhome-image-preview" title="' + desc  +'">' + res.html + '</div>';
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

ActivityFeedTag.loadFreshData = function(id, params, timestamp) {
	params = params.replace(/&amp;/g, '&');
	var uselang = $.getUrlVar('uselang');
	if (uselang) params += '&uselang=' + uselang;
	$.getJSON(wgScript + '?action=ajax&rs=ActivityFeedAjax', {params: params}, function(json){
		if (json.timestamp > timestamp) {
			var tmpDiv = document.createElement('div');
			tmpDiv.innerHTML = json.data;
			$('#' + id).html($(tmpDiv).find('ul').html());
			ActivityFeedTag.setupThumbnails($('#' + id));
		}
	});
}

ActivityFeedTag.addTracking = function(id) {
	$('#' + id).find('li').each(function(n) {
		$(this).find('strong').find('a').click( function(e) {
			WET.byStr('activityfeedtag/title');
		});
		$(this).find('cite').find('a').eq(0).click( function(e) {
			WET.byStr('activityfeedtag/user');
		});
		$(this).find('cite').find('a').eq(1).click( function(e) {
			WET.byStr('activityfeedtag/diff');
		});
	});
}

ActivityFeedTag.initActivityTag = function(id, params, timestamp) {
	ActivityFeedTag.loadFreshData(id, params, timestamp);
	ActivityFeedTag.addTracking(id);
}

wgAfterContentAndJS.push(function() {
	ActivityFeedTag.setupThumbnails($('.activityfeed'));
});
