/*global define, Promise*/
define('ext.wikia.adEngine.video.player.porvata.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader',
	'ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory',
	'wikia.log',
	'wikia.window'
], function (scriptLoader, imaPlayerFactory, log, win) {
	'use strict';
	var imaLibraryUrl = '//imasdk.googleapis.com/js/sdkloader/ima3.js',
		logGroup = 'ext.wikia.adEngine.video.googleIma';

	function load() {
		if (win.google && win.google.ima) {
			return new Promise(function (resolve) {
				log('Google IMA library already loaded', log.levels.info, logGroup);
				resolve();
			});
		}
		return scriptLoader.loadScript(imaLibraryUrl);
	}

	function getPlayer(params) {
		var adDisplayContainer =  new win.google.ima.AdDisplayContainer(params.container),
			adsLoader = new win.google.ima.AdsLoader(adDisplayContainer);

		return imaPlayerFactory.create(adDisplayContainer, adsLoader, params);
	}

	return {
		load: load,
		getPlayer: getPlayer
	};
});
