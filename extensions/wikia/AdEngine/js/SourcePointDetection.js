/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.sourcePointDetection', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adTracker',
	'wikia.document',
	'wikia.krux',
	'wikia.log'
], function (adContext, adTracker, doc, krux, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.sourcePointDetection',
		kruxEventSent = false,
		detectionInitialized = false,
		spDetectionTime;

	function getClientId() {
		log('getClientId', 'info', logGroup);
		return 'rMbenHBwnMyAMhR';
	}

	function sendKruxEvent(value) {
		var eventId = 'KEa0tIof';

		if (kruxEventSent) {
			return;
		}

		if (krux.sendEvent(eventId, {blocking: value})) {
			log(['sendKruxEvent', eventId, value], 'debug', logGroup);
			kruxEventSent = true;
		}
	}

	function initDetection() {
		var context = adContext.getContext(),
			detectionScript = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		spDetectionTime = adTracker.measureTime('spDetection', {}, 'start');
		spDetectionTime.track();

		if (!context.opts.sourcePointDetection && !context.opts.sourcePointDetectionMobile) {
			log(['init', 'SourcePoint detection disabled'], 'debug', logGroup);
			return;
		}
		if (detectionInitialized) {
			log(['init', 'SourcePoint detection already initialized'], 'debug', logGroup);
			return;
		}
		log('init', 'debug', logGroup);

		detectionScript.async = true;
		detectionScript.type = 'text/javascript';
		detectionScript.src = context.opts.sourcePointDetectionUrl;
		detectionScript.setAttribute('data-client-id', getClientId());

		// @TODO Refactor event listeners after ADEN-2452
		doc.addEventListener('sp.blocking', function () {
			sendKruxEvent('yes');
			spDetectionTime.measureDiff({}, 'end').track();
		});
		doc.addEventListener('sp.not_blocking', function () {
			sendKruxEvent('no');
			spDetectionTime.measureDiff({}, 'end').track();
		});

		log('Appending detection script to head', 'debug', logGroup);
		node.parentNode.insertBefore(detectionScript, node);
		detectionInitialized = true;
	}

	return {
		initDetection: initDetection,
		getClientId: getClientId
	};
});
