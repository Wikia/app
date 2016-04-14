/*global define*/
/*jshint camelcase:false*/
define('ext.wikia.adEngine.lookup.speedBidder', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';

	var loggroup = 'ext.wikia.adengine.lookup.speedbidder';

	function call() {
		log('call', 'debug', loggroup);

		var openx = doc.createElement('script'),
			node = doc.getElementsByTagName('script')[0];

		openx.async = true;
		openx.type = 'text/javascript';
		openx.src = '//wikia-d.openx.net/w/1.0/jstag?nc=5441-Pre_Wikia';

		node.parentNode.insertBefore(openx, node);
	}

	return {
		call: call
	};
});
