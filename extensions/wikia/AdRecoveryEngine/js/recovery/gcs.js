/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adRecoveryEngine.recovery.gcs', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.recovery.helper',
	'wikia.document',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	recoveryHelper,
	doc,
	log,
	win
) {
	'use strict';
	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adRecoveryEngine.recovery.gcs';

	function addClasses() {
		doc.getElementById('WikiaArticle').classList.add('p402_premium');
	}

	function init() {
		var GCS = win._402;
		log('init', 'info', logGroup);
		addClasses();
		try {
			GCS.show();
		} catch (ignore) {}
	}

	function addRecoveryCallback() {
		if (context.targeting.pageType !== 'article') {
			log(['addRecoveryCallback', 'This page is not an article'], 'debug', logGroup);
			return;
		}

		recoveryHelper.addOnBlockingCallback(function () {
			init();
		});
	}

	return {
		addRecoveryCallback: addRecoveryCallback
	};
});
