define('wikia.videoBootstrap', ['wikia.loader'], function videoBootstrap(loader) {

	return function(element, json) {
		var init = json.init,
			html = json.html,
			scripts = json.scripts,
			jsParams = json.jsParams;

		// insert html
		if(html) {
			element.innerHTML = html;
		}

		if(scripts) {
			loader({
				type: loader.JS,
				resources: scripts
			}).done(
				function() {
					// execute the init function
					if(init) {
						require([init], function(init) {
							init(jsParams);
						});
					}
				}
			);
		}
	}
});