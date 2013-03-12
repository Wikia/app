(function( context ) {
	'use strict';

	function ooyala() {

		var p = window.ooyalaParams;

		var loadOoyala = function(){
			$.getScript(p.jsFile).done(function() {
				window.OO.Player.create(p.playerId, p.videoId, { width: p.width + 'px', height: p.height + 'px', autoplay: p.autoPlay });
			});
		};

		wgAfterContentAndJS.push(loadOoyala);
	}

	// Exports
	context.Wikia = context.Wikia || {};
	context.Wikia.Ooyala = ooyala( context );

	if (context.define && context.define.amd) {
		context.define('wikia.ooyala', ['wikia.window'], ooyala);
	}

})(this);