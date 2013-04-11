require(['wikia.window','jquery', 'wikia.log'], function(window, $, log) {
	var img = new Image(),
		data = {
			controller: 'LyricFind',
			method: 'track',
			pageid: window.wgArticleId || 0
		},
		url = window.wgServer + window.wgScriptPath + '/wikia.php?' + $.param(data);

	img.src = url;
	log('tracking page view', log.levels.info, 'LyricFind');
});
