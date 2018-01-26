define('wikia.articleVideo.featuredVideo.jwplayer.annotations', function () {
	var annotations;

	function getAnnotations(mediaId) {
		var promise = new Promise(function (resolve) {
			if (annotations) {
				resolve(annotations);
			} else {
				fetch('https://services.wikia-dev.pl/video-annotations/videos/' + mediaId + '/annotations/')
					.then(function (response) {
						return response.json()
					})
					.then(function (fetchedAnnotations) {
						annotations = fetchedAnnotations;
						resolve(annotations);
					});
			}
		});

		return promise;

	}

	return {
		getAnnotations: getAnnotations
	}
});
