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
			var tutorialPlayed = store.get('tutorialPlayed') || true,//false,
			games,
			gamesListLoader = new data.XDomainLoader(),
			gameLoader = new data.XDomainLoader(),
			selectedGame,
			selectedGameIndex,
			g,
			Game = gameLogic.Game,
			muteButton,
			imgPath,
			
			view = {
				image: function() {
					return function(text, render) {
						return imageServer.getAsset(text);
					}
				}
			},
			
			gameScreenRender = function(event, round){
				screenManager.get('game').show()
				.getElement().style.pointerEvents = 'none';

				//on load picture
				var self = this;
				document.getElementById('bgPic').getElementsByTagName('img')[0].onload = function() {
					imageLoaded();
				}
				
				//highscore
				if(!store.get('highScore_' + g.getId())) store.set('highScore_' + g.getId(), 0);
				document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = store.get('highScore_' + g.getId());
				
				if(g.getId() == 'tutorial')
					g.openModal({
						name: 'intro',
						html: "Tap the screen to take a peek of the mystery image underneath.",
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
			},
			
			changeImg = function(gameId, image) {
				//TODO: preload the image
				imgPath = (gameId == 'tutorial') ? imageServer.getAsset(image) : image;
				document.getElementById('bgPic').getElementsByTagName('img')[0].src = imgPath;
			},
			
			imageLoaded = function() {
				screenManager.get('game').getElement().style.pointerEvents = 'auto';
				if(g.getId() != 'tutorial') g.closeModal();
			},
			
			loadSelectedGame = function(){
				if(typeof selectedGame != 'undefined'){
					gameLoader.load('http://' +
							((config.settings.testDomain) ? selectedGame.dbName + '.' + config.settings.testDomain : selectedGame.domain) +
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
					
					for(var x = 0, y = games.length; x < y; x++){
						games[x].index = x;
						templateVars.games.push(games[x]);
					}
					
					document.getElementById('sliderContent').innerHTML = Mustache.to_html(templates.gameSelector, templateVars);
					
					var gamesList = document.getElementById('gamesList').onclick = function(event){
						event = event || window.event;
						var target = event.target || event.srcElement;
						
						while(target.tagName != 'LI' && target.id != 'gamesList'){
							target = target.parentNode;
						}
						
						if(target.tagName == 'LI'){
							selectedGameIndex = target.getAttribute('data-idx');
							selectedGame = games[selectedGameIndex];
							loadSelectedGame();
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
				
				setTimeout(
					function(){
						document.getElementById('sliderWrapper').style.bottom = 0;
					},
					2000
				);
				
				var muteButton = document.getElementById('button_volume'),
				imgs = muteButton.getElementsByTagName('img');
				
				if(store.get('mute')) {
					console.log('mute');
					soundServer.setMute(true);
					imgs[0].style.display = "none";
					imgs[1].style.display = "block";
				}
				
				
				muteButton.onclick = function(){
					if(!soundServer.getMute()) {
						store.set('mute', true);
						soundServer.setMute(true);
						imgs[0].style.display = "none";
						imgs[1].style.display = "block";
					} else {
						store.set('mute', false)
						soundServer.setMute(false);
						soundServer.play('pop');
						imgs[1].style.display = "none";
						imgs[0].style.display = "block";
					}
				}
				document.getElementById('button_tutorial').onclick = function() {
					runTutorial();
				}
			},
			
			//event handlers
			modalOpened = function(event, options) {
				if(g.getId() == 'tutorial') {
					console.log(g.getId());
					g.pause();
					g._tutorialSteps[options.name] = 1;
				}
			},
			
			answerClicked = function(event, options) {
				g.resume();
				if(options.li.id != g._correctAnswer) {
					this.fire('wrongAnswerClicked', {li: options.li});
				} else {
					this.fire('rightAnswerClicked', {li: options.li});
				}
			},
			
			wrongAnswerClicked = function(event, options) {
				var li = options.li;
				if(!li.clicked) {
					li.className = Game.INCORRECT_CLASS_NAME;
					li.clicked = true;
					soundServer.play('wrongAnswer');
		
					g._roundPoints.deductPoints(g._wrongAnswerPointDeduction);
					g.updateScoreBar();
					g.updateHudScore();
				}
			},
			
			rightAnswerClicked = function(event, options) {
				if(g.getId() == 'tutorial') {
					g.openModal({
						name: 'continue',
						html: 'After the answer is revealed tap the "next" button to continue on to a new image.',
						fade: true,
						clickThrough: false,
						closeOnClick: true});
				}
				
				g._roundIsOver = true;
				g._timer = null;
	
				// Record this as a correct answer (for the stats at the end of the game).
				g._numCorrect++;
	
				// Move the points from the round-score to the total score.
				g._totalPoints.addPoints(g._roundPoints.getPoints());
				g._roundPoints.setPoints(0);
				// Play sound.
				soundServer.play('win');
	
				// Collapse answer-drawer.
				g.hideAnswerDrawer();
				
				// Reveal all tiles.
				g.hideScoreBar();
				g.revealAll();
				//g.showContinue('Excellent! It\'s ' + options.li.innerHTML);
			},
			
			answerDrawerButtonClicked = function(event, options) {
				var button = options.button,
				buttonClassList = button.classList,
				imgs = button.getElementsByTagName('img');
				
				g.resume();
				
				if (buttonClassList.contains('closed')) {
					imgs[0].style.opacity = 0;
					imgs[1].style.opacity = 1;
					buttonClassList.remove('closed');
					document.getElementById('answerDrawer').style.right = 0;
					if(g.getId() == 'tutorial') {
						g.openModal({
							name: 'drawer',
							html: 'The fewer peek you take, the fewer guesses you make, and the less time you take, the bigger your score!',
							fade: true,
							clickThrough: false,
							fontSize: 'x-large',
							closeOnClick: true});
					}
				} else {
					imgs[1].style.opacity = 0;
					imgs[0].style.opacity = 1;
					buttonClassList.add('closed');
					document.getElementById('answerDrawer').style.right = -225;
				}
			},
			
			answerDrawerHidden = function() {
				var answerList = document.getElementById('answerList'),
				answerListLength = answerList.length,
				answerButton = document.getElementById('answerButton');
				
				answerButton.classList.add('closed');
				answerButton.getElementsByTagName('img')[1].style.opacity = 0;
				answerButton.getElementsByTagName('img')[0].style.opacity = 1;
			},
			
			continueClicked = function() {
				g.nextRound();
			},
			
			endGame = function() {
				g.showEndGameScreen();
				if (store.get('highScore_' + g.getId()) < g._totalPoints.getPoints()) {
					document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = g._totalPoints.getPoints();
					store.set('highScore_' + g.getId(), g._totalPoints.getPoints());
					g.openModal({
						name: 'highscore',
						html: 'New highscore: ' + g._totalPoints.getPoints() + ' !',
						fade: true,
						clickThrough: false,
						closeOnClick: true});
				}
				
				if(g.getId() == 'tutorial') {
					store.set('tutorialPlayed', true);
				}
			},
			
			goHome = function(){
				g.pause();
				delete g;
				screenManager.get('home').show();
				this.fire('initHomeScreen');	
			},
			
			playAgain = function(){
				var id = g.getId();
				g.pause();
				delete g;
				selectedGame = games[selectedGameIndex];
				runGame(selectedGame);
			},
			
			displayingMask = function() {
				if(g.getId() != 'tutorial'){
					g.openModal({
						name: 'Loading Image',
						html: 'Loading image...<br /> Please wait.',
						fade: false,
						clickThrough: false,
						closeOnClick: false
					});
				}
				
				screenManager.get('game').getElement().style.pointerEvents = 'none';
			},
			
			maskDisplayed = function(event , options) {
				changeImg(g.getId(), options.image);
				g.updateHudProgress();
			},
			
			tilesShown = function(event, options) {
				g.showContinue('It\'s: ' + options.correct);
			},
			
			scoreBarHidden = function() {
				var scoreBarStyle = document.getElementById('scoreBar').style;
				scoreBarStyle.height = g._barWrapperHeight;
				scoreBarStyle.backgroundColor = 'rgba(137, 196, 64, 0.9)';
			},
			
			tileClicked = function(event, tile) {
				tile = tile.tile;
				
				if(!tile.clicked) {
					g.resume();
					soundServer.play('pop');
					tile.clicked = true;
					tile.style.opacity = 0;
					if( g.getId() == "tutorial" ) {
						g.openModal({
							name: 'tile',
							html:'Tap the "answer" button to make your guess.',
							fade: true,
							clickThrough: false,
							closeOnClick: true,
							triangle: 'right'});
					}

				}
			},
			
			timeIsUp = function(){
				soundServer.play('fail');
				g.roundIsOver = true;
				g.hideAnswerDrawer();
				g.hideScoreBar();
				g.showTimeUp();
				g.updateHudScore();
				setTimeout(function() {
					g.hideTimeUp();
				}, Game.TIME_UP_NOTIFICATION_DURATION_MILLIS);
			},
			
			timeUpHidden = function(event, options) {
				g.revealAll();
			},
			
			timerEvent = function() {
				g._roundPoints.deductPoints(g._timerPointDeduction);
				g.updateScoreBar();
				g.updateHudScore();
			},
			
			timeIsLow = function() {
				soundServer.play('timeLow')
			},
			
			onDataError = function(event, resp){
				alert('Error loading ' + resp.url + ': ' + resp.error.toString());
			};
			
			function runGame(selectedGame) {
				var id = selectedGame.dbName,
				data = [],
				watermark = 'watermark_' + id,
				correctLength = selectedGame.c.length,
				wrongLength = selectedGame.w.length;
				
				for(var i = 0; i < Game.ROUND_LENGTH; i++) {
					
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
				g = new Game({
					id: id,
					data: data,
					watermark: imageServer.getAsset(watermark),
					screen: screenManager.get('game')
				});
				
				console.log(data[0].image);
				registerEvents(g);
				g.prepareGame();
				
			};
			
			function runTutorial() {
				g = new Game({
					id: 'tutorial',
					data: config.tutorial,
					screen: screenManager.get('game'),
					watermark: imageServer.getAsset('watermark_tutorial')
				});
				
				registerEvents(g);
				g.prepareGame();
			};
			
			function initHighScoreScreen(){
				alert('Sorry, this is not implemented ATM...');
			}
			
			function registerEvents(game) {
				game.addEventListener('displayingMask', displayingMask);
				game.addEventListener('renderGameScreen', gameScreenRender);
				game.addEventListener('initHomeScreen', initHomeScreen);
				game.addEventListener('goHome', goHome);
				game.addEventListener('playAgain', playAgain);
				game.addEventListener('goToHighScores', initHighScoreScreen);
				game.addEventListener('timeIsUp', timeIsUp);
				game.addEventListener('modalOpened', modalOpened);
				game.addEventListener('answerClicked', answerClicked);
				game.addEventListener('wrongAnswerClicked', wrongAnswerClicked);
				game.addEventListener('rightAnswerClicked', rightAnswerClicked);
				game.addEventListener('answerDrawerButtonClicked', answerDrawerButtonClicked);
				game.addEventListener('continueClicked', continueClicked);
				game.addEventListener('maskDisplayed', maskDisplayed);
				game.addEventListener('scoreBarHidden',scoreBarHidden);
				game.addEventListener('answerDrawerHidden', answerDrawerHidden);
				game.addEventListener('tileClicked', tileClicked);
				game.addEventListener('timerEvent', timerEvent);
				game.addEventListener('timeIsLow', timeIsLow);
				game.addEventListener('endGame', endGame);
				game.addEventListener('timeUpHidden', timeUpHidden);
				game.addEventListener('tilesShown', tilesShown);
			}
			
			//end of event handlers
			imageServer.init(config.images);
			soundServer.init(config.sounds);
			
			document.body.innerHTML = Mustache.to_html(templates.wrapper, view);
			
			screenManager.addEventListener('show', function(event, data){
				switch(data.id){
					case 'game':
						screenManager.get('home').hide();
						break;
					case 'home':
						screenManager.get('game').hide();
						break;
				}
			});
			
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
				
				runGame(selectedGame);
				//alert('Loaded game: ' + selectedGame.name + ' (' + selectedGame.c.length + ' correct answers).');
			});
			
			if(!tutorialPlayed){
				runTutorial();			
			}else{
				initHomeScreen();
			};
		}
	);
})();