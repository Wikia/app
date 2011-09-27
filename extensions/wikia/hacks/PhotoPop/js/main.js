require(["../shared/modules/configServer", "../shared/modules/templates", "../shared/modules/imageServer", "../shared/modules/soundServer", "../shared/lib/mustache"], function(config,templates,imageServer,soundServer) {
	

	var view = {
		"image": function() {
			return function(text, render) {
			      return imageServer.get(render(text));
			}
		},
		"games": config.games,
		"url": function() {
			return function(text, render) {
			      return config.urls[text];
			}
		}
	}
	
	imageServer.init(config.images);
	soundServer.init(config.sounds);	
	
	//load main page
	document.body.innerHTML = Mustache.to_html(templates.mainPage, view);
	
	var wrapper = document.getElementById('wrapper');
	wrapper.innerHTML += Mustache.to_html(templates.selectorScreen, view);
	
	var play = document.getElementById('playWrapper').getElementsByTagName('div')[0];

	play.onclick =  function() {
		var sliderWrapper = document.getElementById('sliderWrapper');
		sliderWrapper.style.bottom = 0;
	};
	
	var closeButton = document.getElementById('closeButton');

	closeButton.onclick =  function() {
		var sliderWrapper = document.getElementById('sliderWrapper');
		sliderWrapper.style.bottom = "-250px";
		soundServer.play('pop');
	};

});
