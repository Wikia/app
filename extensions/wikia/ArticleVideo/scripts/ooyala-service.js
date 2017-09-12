define('wikia.articleVideo.ooyalaService', ['wikia.nirvana'], function (nirvana) {
	return {
		getLabels: function (videoId) {
			var deferred = $.Deferred();
			nirvana.sendRequest({
				controller: 'ArticleVideo',
				method: 'labels',
				type: 'get',
				data: {
					videoId: videoId
				},
				callback: function (response) {
					deferred.resolve(response.labels);
				}
			});
			return deferred.promise();
		}
	};
});
