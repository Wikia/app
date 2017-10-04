(function () {
	var videoDetails = window.wgFeaturedVideoData;
	var videoElementId = 'featured-video-player';
	var videoId = videoDetails.videoId;
	var playerInstance = jwplayer(videoElementId);
	playerInstance.setup({
		file: "//content.jwplatform.com/videos/"+videoId+".mp4",
		mediaid: videoId
	});
})();