require(["core/configServer", "lib/mustache", "core/templates", "imageServer", "soundServer"], function(config) {

	var view = {
		"image": function() {
			return function(text, render) {
			      return imageServer.get(text);
			}
	;	}
	}
	imageServer.init(config.images);
	soundServer.init(config.sounds);	
	
	document.body.innerHTML = Mustache.to_html(templates.mainPage, view);
	var but = document.getElementById("button_volume");
	but.onclick = function() {
		document.body.innerHTML += Mustache.to_html(templates.selectorScreen, view);	
	}

});
