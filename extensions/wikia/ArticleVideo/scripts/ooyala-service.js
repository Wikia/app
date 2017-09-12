define('wikia.articleVideo.ooyalaService', ['wikia.nirvana'], function (nirvana) {
	return {
		getLabels: function (videoId) {
			return nirvana.sendRequest({
				controller: 'ArticleVideo',
				method: 'labels',
				type: 'get',
				data: {
					videoId: videoId
				}
			});
		}
	};
});
