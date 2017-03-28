/*global define*/
define('ext.wikia.adEngine.provider.yavliTag', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.recovery.sourcePoint',
	'wikia.document',
	'wikia.log'
], function (adContext, sourcePoint, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.yavliTag';

	log('init', 'debug', logGroup);

	function add() {
		sourcePoint.addOnBlockingCallback(function () {
			var context = adContext.getContext(),
				yavli = doc.createElement('script');

			yavli.async = true;
			yavli.type = 'text/javascript';
			yavli.src = context.opts.yavliUrl;

			log('Appending Yavli to the end of body', 'debug', logGroup);
			doc.body.appendChild(yavli);
		});
	}

	return {
		add: add
	};
});
