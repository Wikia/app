require(['jquery', 'wikia.window', 'wikia.loader', 'wikia.log'], function ($, window, loader, log) {
	var logGroup = 'wikia.videohandler.ooyala';

	$(function () {
		// console.log(window.wgArticleVideoData);

		// var ooyalaJsFile = window.wgArticleVideoData.jsParams.jsFile[0];
		// var ooyalaVideoId = window.wgArticleVideoData.jsParams.videoId;
		//
		// // console.log(ooyalaJsFile, ooyalaVideoId);
		//
		// /* the second file depends on the first file */
		// loadJs(ooyalaJsFile).done(function () {
		// 	window.OO.ready(function () {
		// 		window.OO.Player.create('player123', ooyalaVideoId, {
		// 			autoplay: true,
		// 			width: '100%',
		// 			height: 300,
		// 			onCreate: onPlayerCreated
		// 		});
		// 	});
		// });
	});

	function loadJs(resource) {
		return loader({
			type: loader.JS,
			resources: resource
		}).fail(loadFail);
	}

	// log any errors from failed script loading (VID-976)
	function loadFail(data) {
		var message = data.error + ':';

		$.each(data.resources, function () {
			message += ' ' + this;
		});

		log(message, log.levels.error, logGroup);
	}

	function onPlayerCreated(player) {
		player.mb.subscribe(window.OO.EVENTS.PLAYHEAD_TIME_CHANGED, 'test', function(event) {
			console.log(arguments);
		});
	}
});