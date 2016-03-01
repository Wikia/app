/*global define, require*/
define('ext.wikia.adEngine.template.modalHandlerFactory', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	require.optional('ext.wikia.adEngine.template.modalMercuryHandler'),
	require.optional('ext.wikia.adEngine.template.modalOasisHandler')
], function (adContext, log, MercuryHandler, OasisHandler) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modalHandlerFactory',
		skin = adContext.getContext().targeting.skin;

	function create() {
		log(['create', skin], 'debug', logGroup);

		switch (skin) {
			case 'mercury':
				log('Created handler for mercury skin', 'debug', logGroup);
				return new MercuryHandler();
			case 'oasis':
				log('Created handler for oasis skin', 'debug', logGroup);
				return new OasisHandler();
			default:
				log('Unsupported skin', 'debug', logGroup);
				return null;
		}
	}

	return {
		create: create
	};
});
