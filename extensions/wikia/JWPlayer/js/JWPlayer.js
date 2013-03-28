define('wikia.jwplayer', ['wikia.window'], function jwplayer(window) {
	return function(params) {
		var doc = window.document,
			script = doc.createElement('script');

		script.type = 'text/javascript';
		script.text = params.jwScript;

		var head = doc.head || doc.getElementsByTagName('head')[0];
		head.appendChild(script);
	}
});