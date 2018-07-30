function wikiaJWPlayerLogger(options) {
	var servicesDomain = options.servicesDomain || 'services.wikia.com',
		loggerPath = '/event-logger/',
		loggerUrl = 'https://' + servicesDomain + loggerPath,
		prefix = 'JWPlayer',
		logLevels = {
			debug: 0,
			info: 1,
			warn: 2,
			error: 3,
			off: 4
		},
		loggerOptions = options.logger || {},
		logLevel = loggerOptions.logLevel ? logLevels[loggerOptions.logLevel] : logLevels['error'],
		logDebugToService = loggerOptions.logDebugToService,
		clientName = loggerOptions.clientName,
		clientVersion = loggerOptions.clientVersion;

	/**
	 * logs errors to event-logger service
	 *
	 * @param resource - 'debug' or 'error'
	 * @param name
	 * @param description
	 */
	function logToService(resource, name, description) {
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

		if (clientVersion) {
			data.client_version = clientVersion;
		}

		request.open('POST', loggerUrl + resource, true);
		request.setRequestHeader('Content-type', 'application/json');

		request.send(JSON.stringify(data));
	}

	function debug(name, description) {
		if (logLevel <= logLevels['debug']) {
			console.log(prefix, name, description);
		}

		if (logDebugToService) {
			logToService('debug', name, description);
		}
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

			logToService('error', name, description);
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
		debug: debug,
		info: info,
		warn: warn,
		error: error,
		subscribeToPlayerErrors: subscribeToPlayerErrors
	};
}
