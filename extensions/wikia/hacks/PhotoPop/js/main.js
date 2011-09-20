require(["core/configServer", "lib/mustache", "core/templates", "imageServer"], function(config) {
	
	imageServer.processImages(config.mainPage);
	
	
	for(var prop in config.selectorScreen.games) {
		config.selectorScreen.games[prop].iconSrc = "extensions/wikia/hacks/PhotoPop/" + config.selectorScreen.games[prop].iconSrc;
	};
	document.body.innerHTML = Mustache.to_html(templates.mainPage, config.mainPage)
	document.body.innerHTML += Mustache.to_html(templates.selectorScreen, config.selectorScreen);
});
