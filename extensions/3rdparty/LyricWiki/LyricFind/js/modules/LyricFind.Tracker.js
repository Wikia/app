define('LyricFindTracker', ['wikia.window', 'jquery'], function(window, $) {
	function track(amgId, gracenoteId, title) {
		var img = new Image(),
			data = {
				controller: 'LyricFind',
				method: 'track',
                title: title,
				amgid:  amgId,
                gracenoteid:  gracenoteId,
				rand: ('' + Math.random()).substr(2,8)
			},
			url = window.wgScriptPath + '/wikia.php?' + $.param(data);

		img.src = url;

        return img;
	}

	return track;
});
