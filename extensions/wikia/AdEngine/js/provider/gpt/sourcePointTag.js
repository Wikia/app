/*global define*/
/*jshint maxlen:125, camelcase:false, maxdepth:7*/
define('ext.wikia.adEngine.provider.gpt.sourcePointTag', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.provider.gpt.googleTag',
	'wikia.document',
	'wikia.log',
	'wikia.tracker',
	'wikia.window'
], function (adContext, GoogleTag, doc, log, tracker, window) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.gpt.sourcePointTag',
		sourcePointClientId = 'rMbenHBwnMyAMhR',
		context = adContext.getContext();

	function SourcePointTag() {
		GoogleTag.call(this);
	}

	function track(eventLabel) {
		tracker.track({
			action: 'impression',
			category: 'ads-sourcepoint-detection',
			label: eventLabel,
			trackingMethod: 'analytics'
		});
	}

	SourcePointTag.prototype = new GoogleTag();

	SourcePointTag.prototype.init = function () {
		log('init', 'debug', logGroup);

		var gads = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		gads.async = true;
		gads.type = 'text/javascript';
		gads.src = context.opts.sourcePointUrl;
		gads.setAttribute('data-client-id', sourcePointClientId);

		gads.addEventListener('load', function () {
			var spReadyEvent = new window.Event('sp.ready');
			window.dispatchEvent(spReadyEvent);
		});

		doc.addEventListener('sp.blocking', function () {
			track('ads-blocked');
		});

		doc.addEventListener('sp.not_blocking', function () {
			track('ads-not-blocked');
		});

		log('Appending GPT script to head', 'debug', logGroup);
		node.parentNode.insertBefore(gads, node);

		this.enableServices();
		this.initialized = true;
	};

	return SourcePointTag;
});
