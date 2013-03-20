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
				var dfd = [],
					d = {},
					i;
				
				for(i=0; i<scripts.length; i++) {
					(function(i) {
						d[i] = $.Deferred(); 
	
						$.getScript(scripts[i]).done(function() {
							d[i].resolve();
						});
						
						dfd.push(d[i]);
					})(i);
				}
				
				$.when(dfd).done(function() {
					// hack for now - not sure why there's a race condition here but we're not going to stick with this code anyway, so I'm not going to worry about it for now (liz)
					setTimeout(runInit, 1000)
				});
			} else {
				runInit();
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