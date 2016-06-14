/*global define*/
define('ext.wikia.adEngine.template.bfab', [
	'wikia.log',
	'wikia.document'
], function (log, doc) {
	'use strict';

	var logGroup = '9',
		slot = doc.getElementById('BOTTOM_LEADERBOARD') || doc.getElementById('MOBILE_BOTTOM_LEADERBOARD');

	function show(params) {
		log(['show', params], 'debug', logGroup);
		var ratio = params.width/params.height;

		slot.classList.add('bfab-template');
		slot.lastElementChild.style.paddingBottom = 100/ratio + '%';

		log('show', 'info', logGroup);
	}

	return {
		show: show
	};
});
