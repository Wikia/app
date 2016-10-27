/*global define, require*/
define('ext.wikia.adEngine.template.bfaa', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	require.optional('ext.wikia.adEngine.template.bfaaDesktop'),
	require.optional('ext.wikia.adEngine.template.bfaaMobile')
], function (
	adContext,
	log,
	bfaaDesktop,
	bfaaMobile
) {
	'use strict';

	var bfaa,
		logGroup = 'ext.wikia.adEngine.template.bfaa';

	function show(params) {
		switch (adContext.getContext().targeting.skin) {
			case 'oasis':
				bfaa = bfaaDesktop;
				break;
			case 'mercury':
				bfaa = bfaaMobile;
				break;
			default:
				return log(['show', 'not supported skin'], log.levels.error, logGroup);
		}

		if (!bfaa) {
			log(['show', 'module is not loaded'], log.levels.error, logGroup);
		}

		bfaa.show(params);
	}

	return {
		show: show
	};
});
