function wikiaJWPlayerLogger(options) {
	var servicesDomain = options.servicesDomain || 'services.wikia.com',
		loggerPath = '/event-logger/error',
		loggerUrl = 'https://' + servicesDomain + loggerPath,
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

		request.send(JSON.stringify(data));
	}

	function info(name, description) {
		console.info(prefix, name, description);
	}

	function warn(name, description) {
		console.warn(prefix, name, description);
	}

	function error(name, description) {
		console.error(prefix, name, description);
		logErrorToService(name, description);
	}

	function subscribeToPlayerErrors(playerInstance) {
		playerInstance.on('setupError', function (err) {
			error('setupError', err);
		});

		playerInstance.on('error', function (err) {
			error('error', err);
		});
	}

	return {
		info: info,
		warn: warn,
		error: error,
		subscribeToPlayerErrors: subscribeToPlayerErrors
	};
}
