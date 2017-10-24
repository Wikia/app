define('wikia.articleVideo.featuredVideo.jwplayer.logger', [], function () {
	var loggerUrl = 'https://services' + wgCookieDomain + '/event-logger/error',
		prefix = 'JWPlayer';

	function logErrorToService(name, description) {
		var request = new XMLHttpRequest(),
			data = {
				name: prefix + ' ' + name
			};

		if (description) {
			data.description = typeof description === 'string' ? description : JSON.stringify(description);
		}

		request.open('POST', loggerUrl, true);
		request.setRequestHeader('Content-type', 'application/json');

		request.send(data);
	}

	function info(name, description) {
		console.info(prefix, name, description);
	}

	function warn(name, description) {
		console.warn(prefix, name, description);
	}

	function error(name, description) {
		logErrorToService(name, description);
	}

	function subscribeToPlayerErrors(playerInstance) {
		playerInstance.on('setupError', function (err) {
			error(err.message, err.error);
		});

		playerInstance.on('error', function (err) {
			error(err.message, err.error);
		});
	}

	return {
		info: info,
		warn: warn,
		error: error,
		subscribeToPlayerErrors: subscribeToPlayerErrors
	}
});
