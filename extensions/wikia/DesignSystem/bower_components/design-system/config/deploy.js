/* eslint-env node */
'use strict';

module.exports = function (deployTarget) {
	let ENV = {
		// include other plugin configuration that applies to all deploy targets here
	};

	if (deployTarget.startsWith('dev-')) {
		ENV.build = {
			environment: 'devbox',
			outputPath: 'docs-dev',
		};
		ENV.sftp = {
			host: deployTarget,
			distDir: 'docs-dev',
			remoteDir: '/var/www/design-system',
			remoteUser: deployTarget.replace('dev-', ''),
			agent: process.env.SSH_AUTH_SOCK
		};

		// Note: if you need to build some configuration asynchronously, you can return
		// a promise that resolves with the ENV object instead of returning the
		// ENV object synchronously.
		return ENV;
	}
};
