/*global define*/
define('ext.wikia.adEngine.lookup.dfpSniffer', [
	'ext.wikia.adEngine.utils.adLogicZoneParams'
], function () {
	'use strict';

	function init () {
		console.log('I am sniffing!');
	}

	return {
		init: init
	};
});
