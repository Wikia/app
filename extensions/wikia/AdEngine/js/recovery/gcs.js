/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.recovery.gcs', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'ext.wikia.adEngine.recovery.helper',
	'wikia.document',
	'wikia.location',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	adTracker,
	recoveryHelper,
	doc,
	location,
	log,
	win
) {
	'use strict';
	var articleUrl = location.href,
		contentId = 'everything',
		context = adContext.getContext(),
		logGroup = 'ext.wikia.adEngine.recovery.message';

	function getGcsUrl() {
		return '//survey.g.doubleclick.net/survey?site=_grm5podgin6cup4wmqjqct4h5e' +
			'&amp;url=' + encodeURIComponent(articleUrl) +
			(contentId ? '&amp;cid=' + encodeURIComponent(contentId) : '') +
			'&amp;random=' + (new Date()).getTime();
	}

	function addClasses() {
		doc.getElementById('WikiaArticle').classList.add('p402_premium');
	}

	function show() {
		addClasses();
		try {
			win._402_Show();
		} catch (ignore) {}
	}

	function init() {
		log('init', 'info', logGroup);
		var gcs = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		gcs.async = true;
		gcs.type = 'text/javascript';
		gcs.src = getGcsUrl();
		gcs.addEventListener('load', function () {
			log('GCS loaded', 'debug', logGroup);
			show();
		});

		node.parentNode.insertBefore(gcs, node);
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
