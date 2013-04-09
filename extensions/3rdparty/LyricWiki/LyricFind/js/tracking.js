(function(context) {

	var trackingServiceUrl = context.wgServer + '/tracking.php',
		img = new Image();

	img.src = trackingServiceUrl + '?pageid=' + context.wgArticleId;

})(window);
