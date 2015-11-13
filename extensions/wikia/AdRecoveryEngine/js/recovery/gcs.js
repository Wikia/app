/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adRecoveryEngine.recovery.gcs', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'jquery',
	'wikia.cookies',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	adTracker,
	recoveryHelper,
	$,
	cookies,
	log,
	win
) {
	'use strict';
	var context = adContext.getContext(),
		logGroup = 'ext.wikia.adRecoveryEngine.recovery.gcs';

	function addClasses() {
		var article = $('#WikiaArticle');
		article.addClass('p402_premium');
		article.find('table,figure,.portable-infobox').each(function () {
			$(this).addClass('p402_hide');
		});
	}

	function trackPosition() {
		var survey = $('.t402-prompt-iframe-container'),
			position,
			bucket;

		if (!survey.length) {
			log(['trackPosition', 'Survey not visible yet'], 'debug', logGroup);
			return;
		}

		position = survey.offset().top -  $('#WikiaArticle').offset().top;
		bucket = position - (position % 100);
		log(['trackPosition', position], 'debug', logGroup);
		adTracker.track('recovery/gcs', bucket + '-' + (bucket + 99));
	}

	function init() {
		log('init', 'info', logGroup);
		addClasses();
		try {
			win._402_Show();
		} catch (ignore) {}
		trackPosition();
	}

	function addRecoveryCallback() {
		if (context.targeting.pageType !== 'article') {
			log(['addRecoveryCallback', 'This page is not an article'], 'debug', logGroup);
			return;
		}
		if (cookies.get('sp.blocking') !== 'yes') {
			log(['addRecoveryCallback', 'Blocking not detected yet'], 'debug', logGroup);
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
