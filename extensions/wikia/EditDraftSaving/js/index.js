CKEDITOR.on('instanceReady', function () {
	setInterval(function () {
		console.log(RTE.getInstance().getData());
	}, 3000);
});

