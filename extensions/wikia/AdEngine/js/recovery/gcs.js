/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.recovery.gcs', [
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'wikia.document',
	'wikia.location',
	'wikia.log',
	'wikia.scriptwriter',
	'wikia.window'
], function (
	adTracker,
	recoveryHelper,
	doc,
	loc,
	log,
	scriptWriter,
	win
) {
	'use strict';
	var article = doc.getElementById('WikiaArticle'),
		articleUrl = loc.href,
		contentId = 'everything',
		logGroup = 'ext.wikia.adEngine.recovery.gcs';

	function getTopPos(el) {
		var pos;
		for (pos = 0; el !== null; el = el.offsetParent) {
			pos += el.offsetTop;
		}
		return pos;
	}

	function addClasses() {
		var elementsToHide;
		if (!article) {
			return;
		}
		elementsToHide = article.querySelectorAll('table,figure,.portable-infobox');
		article.classList.add('p402_premium');
		Array.prototype.forEach.call(elementsToHide, function (element) {
			element.classList.add('p402_hide');
		});
	}

	function trackPosition() {
		var survey = doc.getElementsByClassName('t402-prompt-iframe-container')[0],
			position,
			bucket;

		if (!survey) {
			log(['trackPosition', 'Survey not visible yet'], 'debug', logGroup);
			return;
		}

		position = getTopPos(survey) -  getTopPos(article);
		bucket = position - (position % 100);
		log(['trackPosition', position], 'debug', logGroup);
		adTracker.track('recovery/gcs', 'position', bucket + '-' + (bucket + 99));
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
		recoveryHelper.addOnBlockingCallback(function () {
			init();
		});
	}

	return {
		addRecoveryCallback: addRecoveryCallback
	};
});
