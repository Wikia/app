/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.sourcePointRecovery', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
	'wikia.document'
], function (
	adContext,
	sourcePoint,
	doc
) {
	'use strict';

	function addResponseListener(callback) {
		sourcePoint.addOnBlockingCallback(callback);
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
