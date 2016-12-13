/*global define, google, Promise*/
define('ext.wikia.adEngine.video.player.porvata.googleIma', [
	'ext.wikia.adEngine.utils.scriptLoader',
	'ext.wikia.adEngine.video.player.porvata.googleImaPlayerFactory',
	'ext.wikia.adEngine.video.player.porvata.googleImaSetup',
	'wikia.log',
	'wikia.window'
], function (scriptLoader, imaPlayerFactory, imaSetup, log, win) {
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
		var vastUrl = imaSetup.buildVastUrl(params),
			adsRequestUrl = imaSetup.createRequest(vastUrl, params.width, params.height),
			adDisplayContainer =  new win.google.ima.AdDisplayContainer(params.container),
			adsLoader = new win.google.ima.AdsLoader(adDisplayContainer),
			adsRenderingSettings = imaSetup.getRenderingSettings();

		return imaPlayerFactory.create(adsRequestUrl, adDisplayContainer, adsLoader, adsRenderingSettings);
	}

	return {
		load: load,
		getPlayer: getPlayer
	};
});
