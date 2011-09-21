require(["../shared/modules/configServer", "../shared/modules/templates", "../modules/imageServer", "../modules/soundServer", "../shared/lib/mustache"], function(config,templates,imageServer,soundServer) {

	var view = {
		"image": function() {
			return function(text, render) {
			      return imageServer.get(render(text));
			}
		},
		"games": config.games
	}
	
	imageServer.init(config.images);
	soundServer.init(config.sounds);	
	
	document.body.innerHTML = Mustache.to_html(templates.mainPage, view);
	var but = document.getElementById("button_volume");
	but.onclick = function() {
		document.body.innerHTML += Mustache.to_html(templates.selectorScreen, view);	
	}

});
