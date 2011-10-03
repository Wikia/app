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
		
		function(config, templates, imageServer, soundServer, gameLogic) {
			var startTutorial = true,
			games,
			selectedGame,
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
			},
			
			loadSelectedGame = function(){
				if(typeof selectedGame != 'undefined'){
					microAjax(
						'/wikia.php?controller=PhotoPopController&method=getData&category=' + encodeURIComponent(selectedGame.category) + '&format=json',
						function(data) {
							data = JSON.parse(data).items;
							var item;
							selectedGame.c = new Array();
							selectedGame.w = new Array();
							
							for(var x = 0, y = data.length; x < y; x++){
								item = data[x];
								selectedGame[(typeof item.image != 'undefined') ? 'c' : 'w'].push(item);
							}
							
							console.log(selectedGame);
						}
					);
				}
			},
			renderGamesList = function(){
				if(typeof games != 'undefined'){
					var templateVars = {
						games: []
					},
					item;
					
					for(var x = 0, y = games.length; x < y; x++){
						item = games[x];
						templateVars.games.push({
							name: item.name,
							image: 'http://' + item.dbName + '.federico.wikia-dev.com/wikia.php?controller=PhotoPopController&method=getIcon&title=' + item.thumbnail + '&format=raw',
							index: x
						})
					}
					
					document.getElementById('sliderContent').innerHTML = Mustache.to_html(templates.gameSelector, templateVars);
					
					var gamesList = document.getElementById('gamesList').onclick = function(event){
						event = event || window.event;
						var target = event.target || event.srcElement;
						
						while(target.tagName != 'LI' && target.id != 'gamesList'){
							target = target.parentNode;
						}
						
						if(target.tagName == 'LI'){
							selectedGame = games[target.getAttribute('data-idx')];
							loadSelectedGame();
						}
					}
				}
			},
			loadGamesList = function(){
				microAjax(
					'/wikia.php?controller=PhotoPopController&method=listGames&format=json',
					function(data) {
						games = JSON.parse(data).items
						setTimeout(renderGamesList, 2000);
					}
				);
			},
			initHomeScreen = function(){
				setTimeout(
					function(){
						document.getElementById('sliderWrapper').style.bottom = 0;
						loadGamesList();
					},
					2000
				);
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
				var g = new gameLogic.Game({
					id: 'tutorial',
					data: config.tutorial,
					watermark: imageServer.getAsset('watermark_dexter')
				});
				
				g.addEventListener('roundStart', gameScreenRender);
				g.addEventListener('playSound', function(event, sound) {
					soundServer.play(sound.name);
				});
				g.play();			
			}else{
				initHomeScreen();
			}
		}
	);
})();