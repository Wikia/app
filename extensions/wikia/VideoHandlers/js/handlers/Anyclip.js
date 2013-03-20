(function( context ) {
	'use strict';

	function anyclip() {
		function Anyclip(params) {
			window.AnyClipPlayer.load([params.playId, {clipID:params.videoId, autoPlay:params.autoPlay}, {wmode: "opaque"}]);
		}

		return Anyclip;
	}


	if (context.define && context.define.amd) {
		context.define('wikia.anyclip', [], anyclip);
	}

})(this);