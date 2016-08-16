/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.sourcePointRecovery', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.log'
], function (
	adContext,
	doc
) {
	'use strict';

	function addResponseListener(callback) {
		doc.addEventListener('sp.blocking', callback);
		doc.addEventListener('sp.not_blocking', callback);
	}

	function getName() {
		return 'sp_recovery';
	}

	function isEnabled() {
		var context = adContext.getContext();

		return !!context.opts.sourcePointRecovery;
	}

	return {
		addResponseListener: addResponseListener,
		getName: getName,
		wasCalled: isEnabled
	};
});
