var videoElementId = 'featured-video-player';
var videoId = 'FYykS9se';
var playerInstance = jwplayer(videoElementId);
playerInstance.setup({
	file: "//content.jwplatform.com/videos/"+videoId+".mp4",
	mediaid: videoId
});

