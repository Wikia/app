require(["core/configServer", "lib/mustache", "core/templates"], function(config) {
	
	for(var prop in config.mainPage) {
		config.mainPage[prop] = "extensions/wikia/hacks/PhotoPop/" + config.mainPage[prop];
	};
		
	document.body.innerHTML = Mustache.to_html(templates.selectorScreen, config.selectorScreen);
});
