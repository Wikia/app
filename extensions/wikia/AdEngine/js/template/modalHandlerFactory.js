/*global define, require*/
define('ext.wikia.adEngine.template.modalHandlerFactory', [
	'ext.wikia.adEngine.adContext',
	'wikia.log'
], function (adContext, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.modalHandlerFactory',
		skin = adContext.getContext().targeting.skin,
		MercuryHandler,
		OasisHandler;

	try {
		MercuryHandler = require('ext.wikia.adEngine.template.modalMercuryHandler');
	} catch (exception) {
		MercuryHandler = null;
	}

	try {
		OasisHandler = require('ext.wikia.adEngine.template.modalOasisHandler');
	} catch (exception) {
		OasisHandler = null;
	}

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
