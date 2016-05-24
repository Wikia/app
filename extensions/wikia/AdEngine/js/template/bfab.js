/*global define*/
define('ext.wikia.adEngine.template.bfab', [
	'wikia.log',
	'wikia.document'
], function (log, doc) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.template.bfab',
		footer = doc.getElementById('WikiaFooter');

	function show() {
		footer.classList.add('bfab-template');
		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
