(function(context) {

	var url = context.wgServer + '/tracking.php',
		img = new Image();

	img.src = url + '?pageid=' + context.wgArticleId;

})(window);
