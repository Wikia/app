define('wikia.articleVideo.featuredVideo.jwplayer.logger', [], function () {
	var loggerUrl = 'https://services.wikia.com/event-logger/error';

	function logErrorToService(name, description) {
		var request = new XMLHttpRequest(),
			data = {
				name: name
			};

		if (description) {
			data.description = typeof description === 'string' ? description : JSON.stringify(description);
		}

		request.open('POST', loggerUrl, true);
		http.setRequestHeader('Content-type', 'application/json');

		http.send(data);
	}

	function info(name, description) {
		console.info(name, description);
	}

	function warn(name, description) {
		console.warn(name, description);
	}

	function error(name, description) {
		logErrorToService(name, description);
	}

	function subscribeToInternalPlayerErrors(playerInstance) {
		playerInstance.on('error', function (err) {
			debugger;
			error(err);
		});
	}

	function subscribeToPlayerSetupError(playerInstance) {
		playerInstance.on('setupError', function (err) {
			debugger;
			error(err);
		});
	}

	return {
		info: info,
		warn: warn,
		error: error,
		subscribeToInternalPlayerErrors: subscribeToInternalPlayerErrors,
		subscribeToPlayerSetupError: subscribeToPlayerSetupError
	}
});
