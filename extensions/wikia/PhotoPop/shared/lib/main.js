(function(){
	require.config({
		baseUrl: (Wikia.Platform.is('app')) ? 'shared/' : 'extensions/wikia/PhotoPop/shared/'
	});

	require([
			"modules/settings",
			"modules/templates",
			"modules/graphics",
			"modules/audio",
			"modules/games",
			"modules/screens",
			"modules/data"
		],

		function(settings, templates, graphics, audio, games, screens, data) {
			var gamesData,
			gamesListLoader = new data.XDomainLoader('getGamesList'),
			gameLoader = new data.XDomainLoader('getImages'),
			selectedGame,
			selectedGameId,
			currentGame,
			Game = games.Game,
			muteButton,
			mute = false,
			imgPath,
			img = new Image(),
			imagePreloaded = false,
			maskShown = false,
			highscore = [],
			tutorialSteps = [],
			clickEvent = Wikia.Platform.getClickEvent(),
			view = {
				image: function() {
					return function(text, render) {
						return graphics.getAsset(text);
					}
				}
			};

			function initGameScreen(event, gameId){
				screens.get('game').fire('prepareGameScreen', {
					watermark: (gamesData &&
						    gamesData[gameId] &&
						    gamesData[gameId].watermark) ?
						gamesData[gameId].watermark : graphics.getAsset('watermark_default'),
						mute: audio.getMute(),
						initGame: true
				});

				if(gameId == 'tutorial' && !tutorialSteps['intro']) {
					screens.openModal({
						name: 'intro',
						html: Wikia.i18n.Msg('photopop-game-tutorial-intro'),
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
					tutorialSteps['intro'] = true;
				}
				screens.get('game').fire('muteButtonClicked', {mute: audio.getMute()});
			}

			function loadSelectedGame(){
				if(typeof selectedGame != 'undefined'){
					//in the app be sure that the aspect is landscape
					/*
					var width = '',
					height = '';

					if(Wikia.Platform.is('app')){
						if(screen.width > screen.height){
							width = screen.width;
							height = screen.height;
						}else{
							height = screen.width;
							width = screen.height;
						}
					}
					*/
					gameLoader.load('http://' +
							((settings.testDomain) ? selectedGame.id + '.' + settings.testDomain : selectedGame.domain) +
							'/wikia.php?controller=PhotoPopController&method=getData&category=' +
							encodeURIComponent(selectedGame.category),
							{method: 'get', gameId: selectedGame.id}
					);
				}
			}

			function renderGamesList(){
				if(typeof gamesData != 'undefined'){
					var templateVars = {
						games: []
					},
					item;

					for(var p in gamesData){
						var game = gamesData[p];

						if(!game.thumbnail)
								game.thumbnail = graphics.getAsset('gameicon_default');

						//remove photopop naming from games
						game.label = game.name.replace(/photopop/ig, '');

						templateVars.games.push(game);
					}

					document.getElementById('sliderContent').innerHTML = Mustache.to_html(templates.gameSelector, templateVars);

					var gamesList = document.getElementById('gamesList')[clickEvent] = function(event){
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
			}

			function initHomeScreen(){
				var home = screens.get('home');

				home.getElement().style.backgroundImage = "url(" + graphics.getAsset('background') + ")";

				gamesListLoader.load(
					'http://' + (settings.testDomain || settings.centralDomain) +
					'/wikia.php?controller=PhotoPopController&method=listGames',
					{method: 'get'}
				);

				document.getElementById('button_volume')[clickEvent] = function(){
					var mute = audio.toggleMute();
					audio.play('pop');
					screens.get('home').fire('muteButtonClicked', {mute: mute});
					screens.get('game').fire('muteButtonClicked', {mute: mute});
				};

				document.getElementById('button_tutorial')[clickEvent] = function(){
					screens.closeModal();
					runGame('tutorial');
				};

				document.getElementById('button_scores')[clickEvent] = function(){
					openHighscore();
				};

				home.fire('muteButtonClicked', {mute: audio.getMute()});
			}

			function modalOpened(event, options){
				if(currentGame) {
					currentGame.fire('modalOpened', options);
				}
			}

			function wrongAnswerClicked(event, options){
				screens.get('game').fire('wrongAnswerClicked', {
					"class" : Game.INCORRECT_CLASS_NAME,
					li: options.li,
					percent: options.percent
				});
				audio.play('wrongAnswer');
			}

			function rightAnswerClicked(event, correct){
				if(currentGame.getId() == 'tutorial' && !tutorialSteps['continue']) {
					screens.openModal({
						name: 'continue',
						html: Wikia.i18n.Msg('photopop-game-tutorial-continue'),
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
					tutorialSteps['continue'] = true;
				}
				audio.play('win');
				screens.get('game').fire('rightAnswerClicked', correct);
			}

			function answerDrawerButtonClicked(){
				screens.get('game').fire('answerDrawerButtonClicked');

				if(currentGame.getId() == 'tutorial' && !tutorialSteps['drawer']){
					screens.openModal({
						name: 'drawer',
						html: Wikia.i18n.Msg('photopop-game-tutorial-drawer'),
						fade: true,
						clickThrough: false,
						fontSize: 'x-large',
						closeOnClick: true
					});

					tutorialSteps['drawer'] = true;
				}
			}

			function answersPrepared(event, options){
				screens.get('game').fire('answersPrepared', options);
			}

			function continueClicked(){
				screens.get('game').fire('continueClicked');
			}

			function endGame(event, options){
				screens.get('game').fire('endGame', options);

				data.storage.remove(currentGame.getId());
				currentGame = null;

				if(options.gameId !== 'tutorial') {
					var score = options.totalPoints;

					if(highscore.length < 5 || score > highscore[highscore.length-1].score){
						var date = new Date();
						highscore.push({
							score: score,
							date: [date.getDate(),date.getMonth(),date.getFullYear()],
							wiki: options.gameId
						});

						highscore.sort(function(a,b) {
							return a.score < b.score;
						});

						highscore = highscore.slice(0, 5);
					}
					var highscoreSpan = document.getElementById('highScore').getElementsByTagName('span')[0];
					if(highscore.length == 0 || (highscore.length && score > highscore[0].score)) {
						highscoreSpan.innerHTML = score;
					} else if(highscore.length) {
						highscoreSpan.innerHTML = highscore[0].score;
					}

					data.storage.set('highscore', highscore);
				}
			}

			function playAgain(){
				currentGame = null;
				loadSelectedGame();
			}

			function goHome(event, gameFinished){
				if(!gameFinished && currentGame.getId() !== 'tutorial') currentGame.fire('storeData');

				screens.get('game').fire('goHomeClicked', gameFinished);
				screens.get('home').show();
			}

			function displayingMask(event, options){
				//preloading an image
				var imgSrc = (currentGame.getId() === 'tutorial') ? graphics.getAsset(options.image) : graphics.getPicture(options.image);
				//if img is already there don't reload it
				if(img.src.indexOf(imgSrc) !== -1) {
					imageLoaded();
				} else {
					img.src = imgSrc;
				}

				screens.get('game').getElement().style.pointerEvents = 'none';
			}

			function maskDisplayed(){
				document.getElementById('bgPic').getElementsByTagName('img')[0].src = img.src;

				if(currentGame.getId() != 'tutorial' && !Wikia.Platform.is('app')){
					screens.openModal({
						name: 'Loading Image',
						html: Wikia.i18n.Msg('photopop-game-loading-image'),
						fade: false,
						clickThrough: false,
						closeOnClick: false
					});
				}

				maskShown = true;
				manageInteraction();
			}

			function imageLoaded(){
				imagePreloaded = true;
				manageInteraction();
			}

			function imageLoadError() {
				//'this' reffers to img
				if(this.src !== "") {
					data.storage.remove(currentGame.getId());
					currentGame = null;
					screens.get('home').show();
					screens.openModal({
						name: 'tile',
						html: Wikia.i18n.Msg('photopop-game-image-load-error'),
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
					if(Wikia.Platform.is('app')) {
						Titanium.App.fireEvent('Image:error', {id:'getImages', gameId: selectedGame.id});
					}
				}
			}

			function manageInteraction(){
				if(maskShown && imagePreloaded){
					if(currentGame.getId() != 'tutorial') screens.closeModal();
					screens.get('game').getElement().style.pointerEvents = 'auto';
					imagePreloaded = maskShown = false;
				}
			}

			function tileClicked(event, tile){
				var gameScreen = screens.get('game');

				if(gameScreen.canClickTiles() && !tile.clicked){
					audio.play('pop');
					gameScreen.fire('tileClicked', tile);

					if(currentGame.getId() == "tutorial" && !tutorialSteps['tile']){
						screens.openModal({
							name: 'tile',
							html: Wikia.i18n.Msg('photopop-game-tutorial-tile'),
							fade: true,
							clickThrough: false,
							closeOnClick: true,
							triangle: 'right'
						});

						tutorialSteps['tile'] = true;
					}
				}
			}

			function muteButtonClicked(event, button){
				var mute = audio.toggleMute();
				screens.get('game').fire('muteButtonClicked', {mute: mute});
				screens.get('home').fire('muteButtonClicked', {mute: mute});
			}

			function roundStart(event, options) {
				screens.get('game').show().getElement().style.pointerEvents = 'none';
				screens.get('game').fire('roundStart', options);
			}

			function timeIsUp(event, options){
				audio.play('fail');
				screens.get('game').fire('timeIsUp', options);
			}

			function timerEvent(event, percent){
				screens.get('game').fire('timerEvent', percent);
			}

			function pause(event, options){
				var pauseModal = ('pauseButton' == options.caller || ('goHomeButton' == options.caller && !currentGame.getId() != 'tutorial'));

				if(options.pause){
					screens.get('game').fire('paused');

					if(pauseModal){
						screens.openModal({
							name: 'pause',
							html: Wikia.i18n.Msg('photopop-game-paused'),
							clickThrough: false,
							leaveBottomBar: true,
							closeOnClick: false,
							dim: true
						});
					}
				}else{
					screens.get('game').fire('resumed');

					if(pauseModal)
						screens.closeModal();
				}
			}

			function timeIsLow(){
				audio.play('timeLow');
			}

			function onDataError(event, resp){
				alert(Wikia.i18n.Msg('photopop-game-request-error'));

				if(screens.getCurrent().getId() != 'home')
						screens.get('home').show();
			}

			function runGame(target){
				if(target == 'tutorial') {
					tutorialSteps = [];
					newGame({
						_id: 'tutorial',
						_data:settings.tutorial
					});
				} else {
					selectedGameId = target.getAttribute('data-id');
					selectedGame = gamesData[selectedGameId];

					if(currentGame && currentGame.getId() == selectedGame.id) {
						screens.get('game').show();
					} else {
						if(currentGame) currentGame.fire('storeData');
						var gameData = null;

						data.storage.addEventListener({name: 'get', key: selectedGameId}, function(event, options) {
							var gameData = options.value || gameData;
							//if there is already a game in localstorage start it from this data otherwise load a new one
							(gameData)? newGame(gameData): loadSelectedGame();
						}, {oneTime: true});

						data.storage.get(selectedGameId);
					}
				}
			}

			function loadGame(){
				var id = selectedGame.id,
				data = [],
				watermark = 'watermark_' + id,
				correctAnswers = selectedGame.c.slice().shuffle(),
				correctAnswersLength = correctAnswers.length,
				//concatenate correct answers with wrong to have array with possible answers if wrong is empty use only correct ones
				allAnswers = (selectedGame.w)?selectedGame.c.concat(selectedGame.w).slice():selectedGame.c.slice(),
				allAnswersLength = allAnswers.length,
				choosenAllAnswers = [],
				randId, item, correct;

				for(var i = 0, l = Game.ROUND_LENGTH;i < l && i < correctAnswersLength; i++){
					choosenAllAnswers = [], j = 4;

					while(j--) {
						if(j === 3) {
							correct = correctAnswers.shift();
						} else {
							randId = Math.floor(Math.random()*allAnswersLength);
							//check if the aswer is already there or is undefined or is the same as correct one
							//then choose another one
							while(choosenAllAnswers.contains(item = allAnswers[randId]) || !item || item.id === correct.id) {
								(allAnswersLength === randId)?randId++:randId--;
							};
							choosenAllAnswers.push(item);
						}
					}

					data.push({
						image: correct.image,
						answers: [
							correct.text,
							choosenAllAnswers[0].text,
							choosenAllAnswers[1].text,
							choosenAllAnswers[2].text,
						],
						correct: correct.text
					});
				}
				newGame({_id:id, _data:data});
			}

			function trackStats(event, data){ /* noop */ }

			function newGame(gameData){
				currentGame = new Game(gameData);

				currentGame.addEventListener('initGameScreen', initGameScreen);
				currentGame.addEventListener('initHomeScreen', initHomeScreen);
				currentGame.addEventListener('goHome', goHome);
				currentGame.addEventListener('playAgain', playAgain);
				currentGame.addEventListener('goToHighScores', openHighscore);
				currentGame.addEventListener('timeIsUp', timeIsUp);
				currentGame.addEventListener('wrongAnswerClicked', wrongAnswerClicked);
				currentGame.addEventListener('rightAnswerClicked', rightAnswerClicked);
				currentGame.addEventListener('answerDrawerButtonClicked', answerDrawerButtonClicked);
				currentGame.addEventListener('continueClicked', continueClicked);
				currentGame.addEventListener('tileClicked', tileClicked);
				currentGame.addEventListener('timerEvent', timerEvent);
				currentGame.addEventListener('timeIsLow', timeIsLow);
				currentGame.addEventListener('endGame', endGame);
				currentGame.addEventListener('muteButtonClicked', muteButtonClicked);
				currentGame.addEventListener('answersPrepared', answersPrepared);
				currentGame.addEventListener('roundStart', roundStart);

				if(Wikia.Platform.is('web')){
					currentGame.addEventListener('roundEnd', trackStats);
					currentGame.addEventListener('startGame', trackStats);
				}

				currentGame.addEventListener('pause', pause);

				currentGame.prepareGame();
			}

			function initHighscore(){

				screens.get('highscore').getElement().style.backgroundImage = "url(" + graphics.getAsset('background') + ")";

				document.getElementById('goBack')[clickEvent] = function(){
					screens.get('home').show();
				};

				data.storage.addEventListener({name: 'get', key: 'highscore'}, function(event, options) {
					highscore = options.value || highscore;
					if(highscore && highscore.length) {
						document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = highscore[0].score;
					}
				});

				data.storage.get('highscore');
			}

			function openHighscore(){
				screens.get('highscore').fire('openHighscore', highscore);
				screens.get('highscore').show();
			}

			function screenShown(event, data){
				var names = screens.getScreenIds();

				for(var i = 0, l = names.length; i < l; i++){
					if(data.id != names[i]) {
						screens.get(names[i]).hide();
					}
				}
			}

			function gameListLoaded(event, resp){
				gamesData = resp.response;
				renderGamesList();
			}

			function gameLoaded(event, obj){
				var item, x, y;
				selectedGame.c = new Array();
				selectedGame.w = new Array();

				for(x = 0, y = obj.response.length; x < y; x++){
					item = obj.response[x];
					selectedGame[(typeof item.image != 'undefined') ? 'c' : 'w'].push(item);
				}

				loadGame();
			}

			/**
			 * init
			 */
			var gameWrapper = document.getElementById('gameWrapper') || document.body;

			gameWrapper.innerHTML = Mustache.to_html(templates.wrapper, view);

			initHomeScreen();

			img.onload = imageLoaded;
			img.onerror = imageLoadError;

			if(Wikia.Platform.is('app')){
				Titanium.App.addEventListener('XDomainLoader:showProgress', function(event){
					screens.openModal({
						name: 'Loading data',
						html: Wikia.i18n.Msg((event.update) ? 'photopop-game-update-progress-text' : 'photopop-game-download-progress-text'),
						progress: true,
						total: event.total
					});
				});

				Titanium.App.addEventListener('XDomainLoader:updateProgress', function(event){
					screens.updateModalProgress();
				});

				Titanium.App.addEventListener('XDomainLoader:hideProgress', function(){
					screens.closeModal();
				});

				Titanium.App.addEventListener('ScreenManager:back', function(event){
					if(games.getCurrentId() != 'tutorial' || screens.getCurrentId() != 'game')
						screens.closeModal();

					if(screens.getCurrentId() == 'game'){
						currentGame.handlePause(true, 'goHomeButton');
						goHome('goHome', false);
					}

					if(screens.getCurrentId() == 'highscore') {
						screens.get('home').show();
					}
				});
			}

			screens.addEventListener('show', screenShown);
			screens.get('game').addEventListener('maskDisplayed', maskDisplayed);
			screens.get('game').addEventListener('modalOpened', modalOpened);
			screens.get('game').addEventListener('displayingMask', displayingMask);

			//init data loading
			gamesListLoader.addEventListener('error', onDataError);
			gamesListLoader.addEventListener('success', gameListLoaded);

			gameLoader.addEventListener('error', onDataError);
			gameLoader.addEventListener('success', gameLoaded);

			//Init all screens
			screens.get('highscore').init();
			screens.get('game').init();
			screens.get('home').init();

			initHighscore();
		}
	);
})();