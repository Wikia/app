define('LyricFindTracker', ['wikia.window', 'jquery'], function(window, $) {
	function track(pageid) {
		var img = new Image(),
			data = {
				controller: 'LyricFind',
				method: 'track',
				pageid:  pageid
			},
			url = window.wgServer + window.wgScriptPath + '/wikia.php?' + $.param(data);

		img.src = url;
	}

	return track;
});
