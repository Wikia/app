/*global define*/
define('ext.wikia.adEngine.utils.eventDispatcher', [
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (doc, log, win) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.utils.eventDispatcher';

	function dispatchEvent(name, data) {
		var event = doc.createEvent('CustomEvent');
		event.initCustomEvent(name, true, true, data || {});
		win.dispatchEvent(event);

		log(['dispatchEvent', name, data], 'info', logGroup);
	}

	return {
		dispatch: dispatchEvent
	};
});
