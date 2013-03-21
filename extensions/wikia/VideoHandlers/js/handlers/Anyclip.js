(function( context ) {
	'use strict';

	context.define('wikia.anyclip', ['wikia.window'], function() {
		function Anyclip(params) {
			window.AnyClipPlayer.load(['#'+params.playerId, {clipID:params.videoId, autoPlay:params.autoPlay}, {wmode: "opaque"}]);
		}

		return Anyclip;
	});

})(this);