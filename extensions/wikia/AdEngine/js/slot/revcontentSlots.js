/*global define*/
define('ext.wikia.adEngine.slot.revcontentSlots', [
	'ext.wikia.aRecoveryEngine.recovery.helper',
	'wikia.log',
	'wikia.window'
], function (recoveryHelper, log, win) {

	var logGroup = 'ext.wikia.adEngine.slot.revcontentSlots';

	function init() {
		log('init', 'Init Revcontent slots', logGroup);

		recoveryHelper.addOnBlockingCallback(function () {
			[
				'REVCONTENT_ABOVE_ARTICLE',
				'REVCONTENT_RIGHT_RAIL',
				'REVCONTENT_BELOW_ARTICLE'
			].forEach(win.adslots2.push);
		});
	}

	return {
		init: init
	};
});
