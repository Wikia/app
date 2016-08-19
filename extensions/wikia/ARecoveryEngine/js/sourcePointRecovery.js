/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.sourcePointRecovery', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.document'
], function (
	adContext,
	helper,
	doc
) {
	'use strict';

	function addResponseListener(callback) {
		helper.addOnBlockingCallback(callback);
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
