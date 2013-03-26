define('wikia.anyclip', ['wikia.window'], function Anyclip(window) {
	'use strict';

	return function (params) {
		window.AnyClipPlayer.load(['#'+params.playerId, {clipID:params.videoId, autoPlay:params.autoPlay}, {wmode: "opaque"}]);
	}
});