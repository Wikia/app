/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.recovery.gcs', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'jquery',
	'wikia.document',
	'wikia.location',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window'
], function (
	adContext,
	adTracker,
	recoveryHelper,
	$,
	doc,
	loc,
	log,
	scriptWriter,
	win
) {
	'use strict';
	var articleUrl = loc.href,
		contentId = 'everything',
		context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.recovery.gcs';

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

	function getGcsUrl() {
		return '//survey.g.doubleclick.net/survey?site=_grm5podgin6cup4wmqjqct4h5e' +
				'&url=' + encodeURIComponent(articleUrl) +
				(contentId ? '&cid=' + encodeURIComponent(contentId) : '') +
				'&random=' + (new Date()).getTime();
	}

	function init() {
		log('init', 'info', logGroup);
		scriptWriter.injectScriptByUrl(doc.body, getGcsUrl(), function () {
			addClasses();
			try {
				win._402_Show();
			} catch (ignore) {}
			trackPosition();
		});
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
