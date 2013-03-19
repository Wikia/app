(function(context){
	'use strict';
	
	function videoBootstrap(loader) {

		function VideoBootstrap(element, json) {
			
//console.log(element);
//console.log(json);
console.log(json.scripts);
			
			// insert html
			element.innerHTML = json.html;
			/*loader({
				type: loader.JS,
				resources: 'http://player.ooyala.com/v3/52bc289bedc847e3aa8eb2b347644f68'
			})*/
			
			//loader('http://player.ooyala.com/v3/52bc289bedc847e3aa8eb2b347644f68')
			
			
			/*loader({
				type: loader.JS,
				resources: {
					scripts: json.scripts[1]
				}
				//resources: json.scripts[1]
			})
			.done(function(res) {
console.log(res);
				var script = res.scripts;
console.log('done');
console.log(script);
				loader.processScript(script);

				loader(json.scripts[1]).done(function(res) {

					require([json.init], function(init) {
						init(json.jsParams);
					});
					
				});
			});*/
			// load the script
			
			
			// Load all JS files with jQuery for now, while we sort out loader()
			var dfd = [],
				d = {},
				i;
			
			for(i=0; i<json.scripts.length; i++) {
				(function(i) {
					d[i] = $.Deferred(); 

					$.getScript(json.scripts[i]).done(function() {
						d[i].resolve();
					});
					
					dfd.push(d[i]);
				})(i);
			}
			
			$.when(dfd).done(function() {
				// hack for now - not sure why there's a race condition here but we're not going to stick with this code anyway, so I'm not going to worry about it for now (liz)
				setTimeout(function() {
					require([json.init], function(init) {
						init(json.jsParams);
					});							
				
				},1000)
			});
			
			/*$.getScript(json.scripts[0]).done(function() {
				$.getScript(json.scripts[1]).done(function() {
					
					require([json.init], function(init) {
						init(json.jsParams);
					});				
				
				});
			});*/
			
			// execute the init function
				
		}

		return VideoBootstrap;
	}

	if (context.define && context.define.amd) {
		context.define('wikia.videoBootstrap', ['wikia.loader'], videoBootstrap);
	}

	context.Wikia = context.Wikia || {};
	context.Wikia.VideoBootstrap = videoBootstrap();

})(this);