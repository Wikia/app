(function(){
	require.config({
		baseUrl: (Wikia.Platform.is('app')) ? 'shared/' : 'extensions/wikia/hacks/PhotoPop/shared/'
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
			var tutorialPlayed = false,// data.storage.get('tutorialPlayed') || false,
			gamesData,
			gamesListLoader = new data.XDomainLoader(),
			gameLoader = new data.XDomainLoader(),
			selectedGame,
			selectedGameId,
			currentGame,
			Game = games.Game,
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
						return graphics.getAsset(text);
					}
				}
			};

			function initGameScreen(event, gameId){
				screens.get('game').fire('prepareGameScreen', {
					watermark: (gamesData[gameId] && gamesData[gameId].watermark) ? gamesData[gameId].watermark : graphics.getAsset('watermark_default'),
					mute: audio.getMute()
				});

				//highscore
				//if(!store.get('highScore_' + gameId)) store.set('highScore_' + gameId, 0);

				//document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = store.get('highScore_' + gameId);

				if(gameId == 'tutorial' && !tutorialSteps['intro']) {
					screens.get('game').openModal({
						name: 'intro',
						html: Wikia.i18n.Msg('photopop-game-tutorial-intro'),
						fade: true,
						clickThrough: false,
						closeOnClick: true
					});
					tutorialSteps['intro'] = true;
				}
			}

			function loadSelectedGame(){
				if(typeof selectedGame != 'undefined'){
					gameLoader.load('http://' +
							((settings.testDomain) ? selectedGame.id + '.' + settings.testDomain : selectedGame.domain) +
							'/wikia.php?controller=PhotoPopController&method=getData&category=' +
							encodeURIComponent(selectedGame.category),
							{method: 'get'}
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
						var game = gamesData[p],
						gameData = store.get(game.id);

						if(!game.thumbnail)
							game.thumbnail = graphics.getAsset('gameicon_default');

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
			}

			function initHomeScreen(){
				gamesListLoader.load(
					'http://' + (settings.testDomain || settings.centralDomain) +
					'/wikia.php?controller=PhotoPopController&method=listGames',
					{method: 'get'}
				);

				screens.get('home').init(audio.getMute());

				var muteButton = document.getElementById('button_volume'),
				imgs = muteButton.getElementsByTagName('img');

				muteButton.onclick = function(){
					audio.toggleMute();
					audio.play('pop');
					screens.get('home').fire('muteButtonClicked', {mute: audio.getMute()});
				};

				document.getElementById('button_tutorial').onclick = function(){
					runGame('tutorial');
				};

				document.getElementById('button_scores').onclick = function(){
					openHighscore();
				};
			}

			function modalOpened(event, options){
				currentGame.fire('modalOpened', options);
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
					screens.get('game').openModal({
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
					screens.get('game').openModal({
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
				store.remove(currentGame.getId());
				currentGame = null;

				var score = options.totalPoints;

				if(score > highscore[highscore.length-1].score){
					var date = new Date();
					highscore.push({
						score: score,
						date: date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear(),
						wiki: options.gameId
					});

					highscore.sort(function(a,b) {
						return a.score < b.score;
					});

					highscore = highscore.slice(0, 5);
				}

				if(score > highscore[0].score) {
					document.getElementById('highScore').getElementsByTagName('span')[0].innerHTML = score;
					screens.get('game').openModal({
						name: 'highscore',
						html: 'New highscore: ' + score + ' !',
						clickThrough: false,
						closeOnClick: true
					});
				}

				store.set('highscore', highscore);

				if(options.gameId == 'tutorial') {
					store.set('tutorialPlayed', true);
				}
			}

			function playAgain(){
				currentGame = null;
				loadSelectedGame();
			}

			function goHome(event, gameFinished){
				if(!gameFinished && currentGame.getId() != 'tutorial')
					currentGame.fire('storeData');

				screens.get('game').fire('goHomeClicked', gameFinished);
				screens.get('home').show();
			}

			function displayingMask(event, options){
				//preloading an image
				img.src = (currentGame.getId() == 'tutorial') ? graphics.getAsset(options.image) : options.image;

				if(currentGame.getId() != 'tutorial'){
					screens.get('game').openModal({
						name: 'Loading Image',
						html: 'Loading image...<br /> Please wait.',
						fade: false,
						clickThrough: false,
						closeOnClick: false
					});
				}

				screens.get('game').getElement().style.pointerEvents = 'none';
			}

			function maskDisplayed(){
				document.getElementById('bgPic').getElementsByTagName('img')[0].src = img.src;
				maskShown = true;
				manageInteraction();
			}

			function imageLoaded(){
				imagePreloaded = true;
				manageInteraction();
			}

			function imageLoadError() {
				screens.get('game').openModal({
					name: 'tile',
					html: Wikia.i18n.Msg('photopop-game-image-load-error'),
					fade: true,
					clickThrough: false,
					closeOnClick: true
				});
			}

			function manageInteraction(){
				if(maskShown && imagePreloaded){
					if(currentGame.getId() != 'tutorial') screens.get('game').closeModal();
					screens.get('game').getElement().style.pointerEvents = 'auto';
					imagePreloaded = maskShown = false;
				}
			}

			function tileClicked(event, tile){
				if(!tile.clicked){
					audio.play('pop');
					screens.get('game').fire('tileClicked', tile);

					if(currentGame.getId() == "tutorial" && !tutorialSteps['tile']){
						screens.get('game').openModal({
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
				var pauseModal = ('pauseButton' == options.caller || 'goHomeButton' == options.caller);

				if(options.pause){
					screens.get('game').fire('paused');

					if(pauseModal){
						screens.get('game').openModal({
							name: 'pause',
							html: 'Game paused',
							clickThrough: false,
							leaveBottomBar: true,
							closeOnClick: false
						});
					}
				}else{
					screens.get('game').fire('resumed');

					if(pauseModal)
						screens.get('game').closeModal();
				}
			}

			function timeIsLow(){
				audio.play('timeLow');
			}

			function onDataError(event, resp){
				alert('Error loading ' + resp.url + ': ' + resp.error.toString());
			}

			function runGame(target){
				var id, data, game;
				if(target == 'tutorial') {
					id =  'tutorial';
					data = settings.tutorial;
					newGame({
						_id:id,
						_data:data
					});
				} else {
					selectedGameId = target.getAttribute('data-id');
					selectedGame = gamesData[selectedGameId];

					if(currentGame && currentGame.getId() == selectedGame.id) {
						screens.get('game').show();
					} else {
						if(currentGame) currentGame.fire('storeData');
						gameData = store.get(selectedGame.id);
						//if there is already a game in localstorage start it from this data otherwise load a new one
						(gameData)? newGame(gameData): loadSelectedGame();
					}
				}
			}

			function loadGame(){
				var id = selectedGame.id,
				data = [],
				watermark = 'watermark_' + id,
				correctLength = selectedGame.c.length,
				wrongLength = selectedGame.w.length,
				a,b,c,d;

				for(var i = 0, l = Game.ROUND_LENGTH;i < l; i++){
					a = Math.floor(Math.random() * correctLength);
					b = Math.floor(Math.random() * correctLength);
					c = Math.floor(Math.random() * wrongLength);
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
			}

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
				currentGame.addEventListener('pause', pause);

				currentGame.prepareGame();
			}

			function initHighscore(){
				highscore = store.get('highscore') || [];

				if(!highscore.length){
					var date = new Date();

					for(var i = 0; i < 5; i++){
						highscore.push({
							score: 1000,
							date: date.getDate()-1 + '-' + (date.getMonth() + 1) + '-' + date.getFullYear(),
							wiki: 'tutorial'
						});
					}

					store.set('highscore', highscore);
				}
			}

			function openHighscore(){
				screens.get('highscore').fire('openHighscore', highscore);
				screens.get('highscore').show();
			}

			function screenShown(event, data){
				var names = screens.getScreenIds(),
				i,l;

				for(i = 0, l = names.length; i < l; i++){
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

				loadGame(selectedGame);
			}

			initHighscore();
			document.body.innerHTML = Mustache.to_html(templates.wrapper, view);

			img.onload = imageLoaded;
			img.onerror = imageLoadError;

			screens.addEventListener('show', screenShown);

			//Init all screens
			screens.get('home');
			screens.get('highscore').init();
			screens.get('game').init();

			screens.get('game').addEventListener('maskDisplayed', maskDisplayed);
			screens.get('game').addEventListener('modalOpened', modalOpened);
			screens.get('game').addEventListener('displayingMask', displayingMask);

			document.getElementById('goBack').onclick = function(){
				screens.get('home').show();
			};

			//init data loading
			gamesListLoader.addEventListener('error', onDataError);
			gamesListLoader.addEventListener('success', gameListLoaded);

			gameLoader.addEventListener('error', onDataError);
			gameLoader.addEventListener('success', gameLoaded);

			if(!tutorialPlayed){
				runGame('tutorial');
			}else{
				initHomeScreen();
			};
		}
	);
})();