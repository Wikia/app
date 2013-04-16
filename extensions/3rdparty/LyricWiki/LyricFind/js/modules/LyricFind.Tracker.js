define('LyricFindTracker', ['wikia.window', 'jquery'], function(window, $) {
	function track(amgId) {
		var img = new Image(),
			data = {
				controller: 'LyricFind',
				method: 'track',
				amgid:  amgId,
				rand: ('' + Math.random()).substr(2,8)
			},
			url = window.wgServer + window.wgScriptPath + '/wikia.php?' + $.param(data);

		img.src = url;
	}

	return track;
});
