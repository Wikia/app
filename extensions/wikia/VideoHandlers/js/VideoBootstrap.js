context.define('wikia.videoBootstrap', ['wikia.loader'], function videoBootstrap(loader) {

	return function(element, json) {
		var init = json.init,
			html = json.html,
			scripts = json.scripts,
			jsParams = json.jsParams;

		// insert html
		if(html) {
			element.innerHTML = html;
		}

		// load the script (Load all JS files with jQuery for now, while we sort out loader())
		if(scripts) {
			var i,
				args = [];

			for(i=0; i<scripts.length; i++){
				args.push({
					type: loader.JS,
					resources: scripts[i]
				});
			}

			loader
			.apply(context, args)
			.done(function() {
				// execute the init function
				if(init) {
					require([init], function(init) {
						init(jsParams);
					});
				}
			});
		}
	}
});