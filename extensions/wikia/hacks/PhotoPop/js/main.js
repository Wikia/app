require(["core/configServer", "lib/mustache", "core/templates", "imageServer"], function(config) {

	var view = {
		"image": function() {
			return function(text, render) {
			      return imageServer.get(config.images[text]);
			}
		}
	}
	
	
	document.body.innerHTML = Mustache.to_html(templates.mainPage, view)
	//document.body.innerHTML += Mustache.to_html(templates.selectorScreen, config.selectorScreen);
});
