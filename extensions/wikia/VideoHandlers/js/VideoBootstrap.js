(function(context){
	'use strict';
	
	function videoBootstrap(loader) {

		function VideoBootstrap(element, json) {
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
					args = [],
					dfd;
				
				for(i=0; i<scripts.length; i++){
					args.push({
						type: loader.JS,
						resources: scripts[i]
					});
				}
				
				dfd = loader.apply(context, args);
				
				dfd.done(function() {
					runInit();
				});

			}
			
			// execute the init function				
			function runInit() {
				if(init) {
					require([init], function(init) {
						init(jsParams);
					});			
				}
			}
		}

		return VideoBootstrap;
	}

	if (context.define && context.define.amd) {
		context.define('wikia.videoBootstrap', ['wikia.loader'], videoBootstrap);
	}

	context.Wikia = context.Wikia || {};
	context.Wikia.VideoBootstrap = videoBootstrap();

})(this);