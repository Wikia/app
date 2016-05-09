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
			win.adslots2.push(['REVCONTENT_ABOVE_ARTICLE']);
			win.adslots2.push(['REVCONTENT_RIGHT_RAIL']);
			win.adslots2.push(['REVCONTENT_BELOW_ARTICLE']);
		});
	}

	return {
		init: init
	};
});
