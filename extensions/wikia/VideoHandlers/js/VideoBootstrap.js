define('wikia.videoBootstrap', ['wikia.loader', 'wikia.nirvana'], function videoBootstrap(loader, nirvana) {

	// "vb" = video bootstrap
	function vb (element, json) {
		this.element = element;

		var init = json.init,
			html = json.html,
			scripts = json.scripts,
			jsParams = json.jsParams;

		// insert html if it hasn't been inserted already
		if(html && !json.htmlPreloaded) {
			element.innerHTML = html;
		}

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
			.apply(loader, args)
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

	vb.prototype = {
		/**
		 * This is a full reload of the video player. Use this when you
		 * need to reset the player with altered settings (such as autoplay).
		 */
		reload: function(title, width, autoplay) {
			var element = this.element;
			nirvana.getJson(
				'VideoHandler',
				'getEmbedCode',
				{
					fileTitle: title,
					width: width,
					autoplay: autoplay ? 1 : 0 // backend needs an integer
				}
			).done(function(data) {
				vb(element, data.embedCode);
			});
		}
	}

	return vb;
});