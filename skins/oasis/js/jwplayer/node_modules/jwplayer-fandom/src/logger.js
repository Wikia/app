function wikiaJWPlayerLogger(options) {
	var servicesDomain = options.servicesDomain || 'services.wikia.com',
		loggerPath = '/event-logger/error',
		loggerUrl = 'https://' + servicesDomain + loggerPath,
		prefix = 'JWPlayer',
		logLevels = {
			info: 1,
			warn: 2,
			error: 3,
			off: 4
		},
		loggerOptions = options.logger || {},
		logLevel = loggerOptions.logLevel ? logLevels[loggerOptions.logLevel] : logLevels['error'],
		clientName = loggerOptions.clientName;

	/**
	 * logs errors to event-logger service
	 *
	 * @param name
	 * @param description
	 */
	function logErrorToService(name, description) {
		var request = new XMLHttpRequest(),
			data = {
				name: prefix + ' ' + name
			};

		if (description) {
			data.description = typeof description === 'string' ? description : JSON.stringify(description);
		}

		if (clientName) {
			data.client = clientName;
		}

		request.open('POST', loggerUrl, true);
		request.setRequestHeader('Content-type', 'application/json');

		request.send(JSON.stringify(data));
	}


	function info(name, description) {
		if (logLevel <= logLevels['info']) {
			console.info(prefix, name, description);
		}
	}

	function warn(name, description) {
		if (logLevel <= logLevels['warn']) {
			console.warn(prefix, name, description);
		}
	}

	function error(name, description) {
		if (logLevel <= logLevels['error']) {
			console.error(prefix, name, description);
			logErrorToService(name, description);
		}
	}

	/**
	 * subscribes to jwplayer errors
	 *
	 * @param playerInstance
	 */
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
