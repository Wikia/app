(function( context ) {
	'use strict';

	context.define('wikia.jwplayer', ['wikia.window'], function() {
		function JWPlayer(params) {
				var script = window.document.createElement('script');

				script.type = 'text/javascript';
				script.text = params.jwScript;

				var head = window.document.head || window.document.getElementsByTagName('head')[0];
				head.appendChild(script);
		}

		return JWPlayer;
	});

})(this);
