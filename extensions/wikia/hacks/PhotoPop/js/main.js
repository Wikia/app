(function(){
	var isApp = (typeof Titanium != 'undefined'),
	prefix = (isApp) ? '' : '../';
	
	require([
			prefix + "shared/modules/configServer",
			prefix + "shared/modules/templates",
			prefix + "shared/modules/imageServer",
			prefix + "shared/modules/soundServer",
			prefix + "shared/modules/game"
		],
		
		function(config, templates, imageServer, soundServer, games) {
			var startTutorial = true,
			wrapper,
			muteButton,
			view = {
				image: function() {
					return function(text, render) {
						  return imageServer.getAsset(render(text));
					}
				},
				games: config.games,
				url: function() {
					return function(text, render) {
						  return config.urls[text];
					}
				}
			},
			gameScreenRender = function(event, round){
				var imgPath = (round.gameId == 'tutorial') ? imageServer.getAsset(round.data.image) : imageServer.getPicture(round.data.image);
				view.path = imgPath;
				wrapper.innerHTML = Mustache.to_html(templates.gameScreen, view);
			};
		
			imageServer.init(config.images);
			soundServer.init(config.sounds);	
			
			//load main page
			var elm = (isApp) ? document.body : document.getElementById('PhotoPopWrapper');
			
			elm.innerHTML = Mustache.to_html(templates.mainPage, view);
			
			wrapper = document.getElementById('wrapper'),
			wrapper.innerHTML += Mustache.to_html(templates.selectorScreen, view);
			
			muteButton = document.getElementById('button_volume');
			muteButton.onclick = function(){
				soundServer.play('pop');
				
				var imgs = this.getElementsByTagName('img');
				
				if(!soundServer.getMute()) {
					soundServer.setMute(true);
					imgs[0].style.display = "none";
					imgs[1].style.display = "block";
				} else {
					soundServer.setMute(false);
					imgs[1].style.display = "none";
					imgs[0].style.display = "block";
				}
			}
			
			if(startTutorial){
				var g = new games.Game({
					id: 'tutorial',
					data: config.tutorial,
					watermark: imageServer.getAsset('watermark_dexter')
				});
				
				g.addEventListener('roundStart', gameScreenRender);
				g.addEventListener('playSound', function(event, sound) {
					soundServer.play(sound.name);
				});
				g.play();			
			}


		}
	);
})();