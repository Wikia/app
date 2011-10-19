(function(){
	var isApp = (typeof Titanium != 'undefined'),
	prefix = (isApp) ? 'shared/' : '../';
	
	require([
			prefix + "modules/configServer",
			prefix + "modules/templates",
			prefix + "modules/imageServer",
			prefix + "modules/soundServer",
			prefix + "modules/game",
			prefix + "modules/screenManager",
			prefix + "modules/data"
		],
		
		function(config, templates, imageServer, soundServer, gameLogic, screenManager, data) {
			var tutorialPlayed = true, //store.get('tutorialPlayed') || true,//false,
			games,
			gamesListLoader = new data.XDomainLoader(),
			gameLoader = new data.XDomainLoader(),
			selectedGame,
			selectedGameId,
			g,
			Game = gameLogic.Game,
			muteButton,
			imgPath,
			img = new Image(),
			imagePreloaded = false,
			maskShown = false,
			highscore = [],
			tutorialSteps = [],
			
			view = {
				image: function() {
					return function(text, render) {
						return imageServer.getAsset(text);
					}
				}
			},
			
			initGameScreen = function(e , gameId){

				screenManager.get('game').fire('prepareGameScreen', {
					watermark: (games[gameId] && games[gameId].watermark) ? games[gameId].watermark : imageServer.getAsset('watermark_default'),
					mute: soundServer.getMute()
				});

				//highscore
				//if(!store.get('highScore_' + gameId)) store.set('highScore_' + gameId, 0);
				
				//document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = store.get('highScore_' + gameId);
				
				
				
				if(gameId == 'tutorial' && !tutorialSteps['intro'])
					screenManager.get('game').openModal({
						name: 'intro',
						html: wgMessages['photopop-game-tutorial-intro'],
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
					tutorialSteps['intro'] = true;
			},
			
			loadSelectedGame = function(){
				if(typeof selectedGame != 'undefined'){
					gameLoader.load('http://' +
							((config.settings.testDomain) ? selectedGame.id + '.' + config.settings.testDomain : selectedGame.domain) +
							'/wikia.php?controller=PhotoPopController&method=getData&category=' +
							encodeURIComponent(selectedGame.category) +
							'&callback=?');
				}
			},
			
			renderGamesList = function(){
				if(typeof games != 'undefined'){
					var templateVars = {
						games: []
					},
					item;
					
					for(var p in games){
						var game = games[p],
						gameData = store.get(game.id);
						
						if(!game.thumbnail)
							game.thumbnail = imageServer.getAsset('gameicon_default');
						
						if(gameData) {
							game.round = gameData._currentRound;
							game.correct = gameData._numCorrect;
							game.totalPoints = gameData._totalPoints;
							game.roundPoints = gameData._roundPoints;
						}
						
						templateVars.games.push(game);
					}
					
					document.getElementById('sliderContent').innerHTML = Mustache.to_html(templates.gameSelector, templateVars);
					
					var gamesList = document.getElementById('gamesList').onclick = function(event){
						event = event || window.event;
						var target = event.target || event.srcElement;
						
						while(target.tagName != 'LI' && target.id != 'gamesList'){
							target = target.parentNode;
						}
						
						if(target.tagName == 'LI'){
							runGame(target);
						}
					}
				}
			},
			
			initHomeScreen = function(){
				gamesListLoader.load(
					'http://' + (config.settings.testDomain || config.settings.centralDomain) +
					'/wikia.php?controller=PhotoPopController&method=listGames&callback=?',
					{method: 'get'}
				);
				
				screenManager.get('home').init(soundServer.getMute());
				
				var muteButton = document.getElementById('button_volume'),
				imgs = muteButton.getElementsByTagName('img');
				
				
				muteButton.onclick = function(){
					var mute = !soundServer.getMute();
					
					soundServer.setMute(mute);
					soundServer.play('pop');
					console.log("main:"+ mute);
					screenManager.get('home').fire('muteButtonClicked', {mute: mute});	
				}
				document.getElementById('button_tutorial').onclick = function() {
					runGame('tutorial');
				}
				
				document.getElementById('button_scores').onclick = function() {
					initHighscore();
				}
			},
			
			//event handlers
			modalOpened = function(e, options) {
				g.fire('modalOpened', options);	
			},
			
			wrongAnswerClicked = function(event, options) {
				screenManager.get('game').fire('wrongAnswerClicked', {
					"class" : Game.INCORRECT_CLASS_NAME,
					li: options.li,
					percent: options.percent
				});
				soundServer.play('wrongAnswer');
			},
			
			rightAnswerClicked = function(event, correct) {
				if(g.getId() == 'tutorial' && !tutorialSteps['continue']) {
					screenManager.get('game').openModal({
						name: 'continue',
						html: wgMessages['photopop-game-tutorial-continue'],
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
					tutorialSteps['continue'] = true;
				}
				soundServer.play('win');
				screenManager.get('game').fire('rightAnswerClicked', correct);
			},
			
			answerDrawerButtonClicked = function() {
				screenManager.get('game').fire('answerDrawerButtonClicked');
				
				if(g.getId() == 'tutorial' && !tutorialSteps['drawer']) {
					screenManager.get('game').openModal({
						name: 'drawer',
						html: wgMessages['photopop-game-tutorial-drawer'],
						fade: true,
						clickThrough: false,
						fontSize: 'x-large',
						closeOnClick: true});
					tutorialSteps['drawer'] = true;
				}
			},
			
			answersPrepared = function(e, options) {
				screenManager.get('game').fire('answersPrepared', options);	
			},
			
			continueClicked = function() {
				screenManager.get('game').fire('continueClicked');
			},
			
			endGame = function(e, options) {
				screenManager.get('game').fire('endGame', options);

				store.remove(g.getId());
				g = null;

				if(options.totalPoints > highscore[highscore.length-1].score) {
					var date = new Date();
					highscore.push({
						score: options.totalPoints,
						date: date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear(),
						wiki: options.gameId
					});
					highscore.sort(function(a,b) {
						return a.score < b.score;
					});
					console.log(highscore);
					highscore = highscore.slice(0, 5);
				}
				
				if(options.totalPoints > highscore[0].score) {
					document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = options.totalPoints;
					screenManager.get('game').openModal({
						name: 'highscore',
						html: 'New highscore: ' + options.totalPoints + ' !',
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
				}
				
				
				store.set('highscore', highscore);
				
				if(options.gameId == 'tutorial') {
					store.set('tutorialPlayed', true);
				}
			},
			
			playAgain = function(){
				var id = g.getId();
				g.pause();
				g = null;
				selectedGame = games[selectedGameId];
				runGame(selectedGame);
			},
			
			goHome = function(e, gameFinished) {
				
				if(!gameFinished && g.getId() != 'tutorial') g.fire('storeData');
				
				screenManager.get('game').fire('goHomeClicked', gameFinished);
				screenManager.get('home').show();
			},
			
			displayingMask = function(e, options) {
				//preloading an image
				img.src = (g.getId() == 'tutorial') ? imageServer.getAsset(options.image) : options.image;
				
				if(g.getId() != 'tutorial'){
					screenManager.get('game').openModal({
						name: 'Loading Image',
						html: 'Loading image...<br /> Please wait.',
						fade: false,
						clickThrough: false,
						closeOnClick: false
					});
				}
				
				screenManager.get('game').getElement().style.pointerEvents = 'none';
			},
			
			maskDisplayed = function() {
				document.getElementById('bgPic').getElementsByTagName('img')[0].src = img.src;
				maskShown = true;
				manageInteraction();
			},
			
			imageLoaded = function() {
				imagePreloaded = true;
				manageInteraction();
			},
			
			manageInteraction = function() {
				if(maskShown && imagePreloaded) {
					if(g.getId() != 'tutorial') screenManager.get('game').closeModal();
					screenManager.get('game').getElement().style.pointerEvents = 'auto';
					imagePreloaded = maskShown = false;
				}
			},
			
			tileClicked = function(event, tile) {
				if(!tile.clicked) {
					soundServer.play('pop');
					screenManager.get('game').fire('tileClicked', tile);

					if( g.getId() == "tutorial" && !tutorialSteps['tile']) {
						screenManager.get('game').openModal({
							name: 'tile',
							html: wgMessages['photopop-game-tutorial-tile'],
							fade: true,
							clickThrough: false,
							closeOnClick: true,
							triangle: 'right'});
						tutorialSteps['tile'] = true;
					}

				}
			},
			
			muteButtonClicked = function(e, button){
				var mute = !soundServer.getMute();
				screenManager.get('game').fire('muteButtonClicked', {mute: mute});
				screenManager.get('home').fire('muteButtonClicked', {mute: mute});
				soundServer.setMute(mute);
			},
			
			roundStart = function(e, options) {
				screenManager.get('game').show().getElement().style.pointerEvents = 'none';
				screenManager.get('game').fire('roundStart', options);	
			},
			
			timeIsUp = function(e, options){
				soundServer.play('fail');
				screenManager.get('game').fire('timeIsUp', options);
			},
			
			timerEvent = function(event, percent) {
				screenManager.get('game').fire('timerEvent', percent);
			},
			
			paused = function() {
				screenManager.get('game').fire('paused');

			},
			
			resumed = function() {
				screenManager.get('game').fire('resumed');
			},
			
			pauseButtonClicked = function(e, pause) {
				if(!pause) {
					screenManager.get('game').openModal({
						name: 'pause',
						html: 'Game paused',
						clickThrough: false,
						leaveBottomBar: true,
						closeOnClick: false
					});
				} else {
					screenManager.get('game').closeModal();
				}
			},
			
			timeIsLow = function() {
				soundServer.play('timeLow')
			},
			
			onDataError = function(event, resp){
				alert('Error loading ' + resp.url + ': ' + resp.error.toString());
			},
			
			runGame = function(target) {
				var id, data, game;
				console.log(g);
				if(target == 'tutorial') {
					id =  'tutorial';
					data = config.tutorial;
					newGame({
						_id:id,
						_data:data
					});
				} else {
					selectedGameId = target.getAttribute('data-id');
					selectedGame = games[selectedGameId];
					
					if(g && g.getId() == selectedGame.id) {
						screenManager.get('game').show();		
					} else {
						if(g) g.fire('storeData');
						gameData = store.get(selectedGame.id);
						console.log(gameData);
						//if there is already a game in localstorage start it from this data otherwise load a new one
						(gameData)? newGame(gameData): loadSelectedGame();
					}
				}
			},
			
			loadGame = function() {
				var id = selectedGame.id,
					data = [],
					watermark = 'watermark_' + id,
					correctLength = selectedGame.c.length,
					wrongLength = selectedGame.w.length;
				
				
					for(var i = 0, l = Game.ROUND_LENGTH;i < l; i++) {
						
						var a = Math.floor(Math.random() * correctLength),
						b = Math.floor(Math.random() * correctLength),
						c = Math.floor(Math.random() * wrongLength),
						d = Math.floor(Math.random() * wrongLength);
						
						data.push({
							image: selectedGame.c[a].image,
							answers: [
								selectedGame.c[a].text,
								selectedGame.c[b].text,
								selectedGame.w[c].text,
								selectedGame.w[d].text,
							],
							correct: selectedGame.c[a].text
							});
					}
				newGame({_id:id, _data:data});
			},
			
			newGame = function(gameData) {
				g = new Game(gameData);
				
				g.addEventListener('initGameScreen', initGameScreen);
				g.addEventListener('initHomeScreen', initHomeScreen);
				g.addEventListener('goHome', goHome);
				g.addEventListener('playAgain', playAgain);
				g.addEventListener('goToHighScores', initHighscore);
				g.addEventListener('timeIsUp', timeIsUp);
				g.addEventListener('wrongAnswerClicked', wrongAnswerClicked);
				g.addEventListener('rightAnswerClicked', rightAnswerClicked);
				g.addEventListener('answerDrawerButtonClicked', answerDrawerButtonClicked);
				g.addEventListener('continueClicked', continueClicked);
				g.addEventListener('tileClicked', tileClicked);
				g.addEventListener('timerEvent', timerEvent);
				g.addEventListener('timeIsLow', timeIsLow);
				g.addEventListener('endGame', endGame);
				g.addEventListener('muteButtonClicked', muteButtonClicked);
				g.addEventListener('answersPrepared', answersPrepared);
				g.addEventListener('roundStart', roundStart);
				g.addEventListener('paused', paused);
				g.addEventListener('resumed', resumed);
				g.addEventListener('pauseButtonClicked', pauseButtonClicked);
				
				g.prepareGame();
			},
			
			initHighscore = function(){
				
				highscore = store.get('highscore') || [];
				
				if(!highscore.length) {
					var date = new Date();
					for(var i=0;i<5;i++) {
						highscore.push({
							score: 1000,
							date: date.getDate()-1 + '-' + (date.getMonth() + 1) + '-' + date.getFullYear(),
							wiki: 'tutorial'
						});
					}
					console.log(highscore);
					store.set('highscore', highscore);
				}
				
				document.getElementById('goBack').onclick = function() {
					screenManager.get('home').show();
				}

				screenManager.get('highscore').show();
				screenManager.get('highscore').fire('openHighscore', highscore);
			};
			
			imageServer.init(config.images);
			soundServer.init(config.sounds);
			
			highscore = store.get('highscore');
			
			document.body.innerHTML = Mustache.to_html(templates.wrapper, view);
			
			img.onload = function() {
				imageLoaded();
			};
			
			img.onerror = function() {
				screenManager.get('game').openModal({
					name: 'tile',
					html: wgMessages['photopop-game-image-load-error'],
					fade: true,
					clickThrough: false,
					closeOnClick: true});
			};
			
			screenManager.addEventListener('show', function(event, data){
				var names = screenManager.getScreenIds();
				
				for(var i = 0, l = names.length; i < l; i++) {
					if(data.id != names[i]) {
						screenManager.get(names[i]).hide();
					}
				}
			});
			
			//Init all screens
			screenManager.get('home');
			screenManager.get('highscore').init();
			screenManager.get('game').init();
			
			screenManager.get('game').addEventListener('maskDisplayed', maskDisplayed);
			screenManager.get('game').addEventListener('modalOpened', modalOpened);
			screenManager.get('game').addEventListener('displayingMask', displayingMask);
			
			//init data loading
			gamesListLoader.addEventListener('error', onDataError);
			gameLoader.addEventListener('error', onDataError);
			
			gamesListLoader.addEventListener('success', function(event, resp){
				games = resp.response;
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
				
				loadGame(selectedGame);
			});
			
			if(!tutorialPlayed){
				runGame('tutorial');			
			} else {
				initHomeScreen();
			};
		}
	);
})();