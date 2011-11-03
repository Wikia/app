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
			var tutorialPlayed = false,
			gamesData,
			gamesListLoader = new data.XDomainLoader(),
			gameLoader = new data.XDomainLoader(),
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
			choosenCorrectPictures = [],
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
						mute: audio.getMute()

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
						var game = gamesData[p];

						if(!game.thumbnail)
								game.thumbnail = graphics.getAsset('gameicon_default');

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

				document.getElementById('button_volume').onclick = function(){
					var mute = audio.toggleMute();
					audio.play('pop');
					screens.get('home').fire('muteButtonClicked', {mute: mute});
					screens.get('game').fire('muteButtonClicked', {mute: mute});
				};

				document.getElementById('button_tutorial').onclick = function(){
					screens.closeModal();
					runGame('tutorial');
				};

				document.getElementById('button_scores').onclick = function(){
					openHighscore();
				};

				document.getElementById('goBack').onclick = function(){
					screens.get('home').show();
				};

				screens.get('home').fire('muteButtonClicked', {mute: audio.getMute()});
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

				if(options.gameId == 'tutorial') {
					data.storage.set('tutorialPlayed', true);
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
				img.src = (currentGame.getId() == 'tutorial') ? graphics.getAsset(options.image) : graphics.getPicture(options.image);
				screens.get('game').getElement().style.pointerEvents = 'none';
			}

			function maskDisplayed(){
				document.getElementById('bgPic').getElementsByTagName('img')[0].src = img.src;

				if(currentGame.getId() != 'tutorial'){
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
				screens.openModal({
					name: 'tile',
					html: Wikia.i18n.Msg('photopop-game-image-load-error'),
					fade: true,
					clickThrough: false,
					closeOnClick: true
				});
			}

			function manageInteraction(){
				if(img.complete) imagePreloaded = true;
				if(maskShown && imagePreloaded){
					if(currentGame.getId() != 'tutorial') screens.closeModal();
					screens.get('game').getElement().style.pointerEvents = 'auto';
					imagePreloaded = maskShown = false;
				}
			}

			function tileClicked(event, tile){
				if(!tile.clicked){
					audio.play('pop');
					screens.get('game').fire('tileClicked', tile);

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
							closeOnClick: false
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
				alert('Error loading ' + resp.url + ': ' + resp.error.toString());
			}

			function runGame(target){
				if(target == 'tutorial') {
					newGame({
						_id: 'tutorial',
						_data:settings.tutorial.shuffle()
					});
				} else {
					selectedGameId = target.getAttribute('data-id');
					selectedGame = gamesData[selectedGameId];

					if(currentGame && currentGame.getId() == selectedGame.id) {
						screens.get('game').show();
					} else {
						if(currentGame) currentGame.fire('storeData');
						var gameData = null;

						data.storage.addEventListener({name: 'get', key: selectedGame.id}, function(event, options) {
							gameData = options.value || gameData;
							//if there is already a game in localstorage start it from this data otherwise load a new one

							/*if(typeof gameData == 'string')
								gameData = JSON.parse(gameData);*/

							(gameData)? newGame(gameData): loadSelectedGame();
						});

						data.storage.get(selectedGame.id);


					}
				}
			}

			function chooseRandomPicture(val, max, correct) {
				var nextRandom = val;

				while(nextRandom == val) {

					nextRandom = Math.floor(Math.random() * max);
					if(correct) {
						for(var i = 0; i < choosenCorrectPictures.length; i++) {
							if(nextRandom == choosenCorrectPictures[i]) {
								nextRandom = val;
							}
						}
					}
				}

				if(correct) {
					choosenCorrectPictures.push(nextRandom)
				}
				return nextRandom;
			}

			function loadGame(){
				var id = selectedGame.id,
				data = [],
				watermark = 'watermark_' + id,
				correctLength = selectedGame.c.length,
				wrongLength = selectedGame.w.length,
				a,b,c,d;

				choosenCorrectPictures = [];

				for(var i = 0, l = Game.ROUND_LENGTH;i < l; i++){
					a = chooseRandomPicture(-1, correctLength, true);
					b = chooseRandomPicture(a, correctLength);
					c = chooseRandomPicture(-1, wrongLength);
					d = chooseRandomPicture(c, wrongLength);

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
Wikia.log(choosenCorrectPictures);
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
			document.body.innerHTML = Mustache.to_html(templates.wrapper, view);

			initHighscore();

			img.onload = imageLoaded;
			img.onerror = imageLoadError;

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

			initHomeScreen();

			data.storage.addEventListener({name: 'get', key: 'tutorialPlayed'}, function(event, options) {
				tutorialPlayed = options.value || tutorialPlayed;

				if(!tutorialPlayed) runGame('tutorial');
			});

			data.storage.get('tutorialPlayed');
		}
	);
})();