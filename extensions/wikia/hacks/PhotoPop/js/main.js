(function(){
	var isApp = (typeof Titanium != 'undefined'),
	prefix = (isApp) ? '' : '../';
	
	require([
			prefix + "shared/modules/configServer",
			prefix + "shared/modules/templates",
			prefix + "shared/modules/imageServer",
			prefix + "shared/modules/soundServer",
			prefix + "shared/modules/game",
			prefix + "shared/modules/data"
		],
		
		function(config, templates, imageServer, soundServer, gameLogic, data) {
			var startTutorial = false,//true,
			games,
			gamesListLoader = new data.XDomainLoader(),
			gameLoader = new data.XDomainLoader(),
			selectedGame,
			wrapper,
			muteButton,
			view = {
				image: function() {
					return function(text, render) {
						  return imageServer.getAsset(render(text));
					}
				},
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
					gameLoader.load('http://' +
							((config.settings.testDomain) ? selectedGame.dbName + '.' + config.settings.testDomain : selectedGame.domain) +
							'/wikia.php?controller=PhotoPopController&method=getData&category=' +
							encodeURIComponent(selectedGame.category) +
							'&callback=?');
				}
			};
			
			function renderGamesList(){
				if(typeof games != 'undefined'){
					var templateVars = {
						games: []
					},
					item;
					
					for(var x = 0, y = games.length; x < y; x++){
						item = games[x];
						templateVars.games.push({
							name: item.name,
							image: 'http://' +  ((config.settings.testDomain) ? item.dbName + '.' + config.settings.testDomain : item.domain) + '/wikia.php?controller=PhotoPopController&method=getIcon&title=' + item.thumbnail + '&format=raw',
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
			}
			
			function initHomeScreen(){
				setTimeout(
					function(){
						document.getElementById('sliderWrapper').style.bottom = 0;
						
						gamesListLoader.load(
							'http://' + (config.settings.testDomain || config.settings.centralDomain) +
							'/wikia.php?controller=PhotoPopController&method=listGames&callback=?',
							{method: 'get'}
						);
					},
					2000
				);
			}
			
			function onDataError(event, resp){
				alert('Error loading ' + resp.url + ': ' + resp.error.toString());
			}
			
			//init audio and graphics
			imageServer.init(config.images);
			soundServer.init(config.sounds);
			
			//init data loading
			gamesListLoader.addEventListener('error', onDataError);
			gameLoader.addEventListener('error', onDataError);
			
			gamesListLoader.addEventListener('success', function(event, resp){
				games = resp.response.items;
				renderGamesList();
			});
			
			gameLoader.addEventListener('success', function(event, obj){
				var item;
				selectedGame.c = new Array();
				selectedGame.w = new Array();
				
				for(var x = 0, y = obj.response.length; x < y; x++){
					item = obj.response[x];
					selectedGame[(typeof item.image != 'undefined') ? 'c' : 'w'].push(item);
				}
				
				console.log(selectedGame);
				alert('Loaded game: ' + selectedGame.name + ' (' + selectedGame.c.length + ' correct answers).');
			});
			
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