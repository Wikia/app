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
			muteButton = document.getElementById('button_volume');
			
			wrapper.innerHTML += Mustache.to_html(templates.selectorScreen, view);
			

			
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
					data: config.tutorial
				});
				g.addEventListener('roundStart', gameScreenRender);
				g.play();
				
								
				var tilesWrapper = document.getElementById('tilesWrapper'),
				table = "",
				tableWidth = wrapper.clientWidth,
				tableHeight = wrapper.clientHeight,
				rows = 4,
				cols = 6;
				
				var MAX_POINTS_PER_ROUND = 1000,
				pointsThisRound = MAX_POINTS_PER_ROUND,
				MAX_SECONDS_PER_ROUND = 10,
				UPDATE_INTERVAL_MILLIS = 50,
				PERCENT_DEDUCTION_WRONG_GUESS = 30;
				pointDeduction = (MAX_POINTS_PER_ROUND / ((MAX_SECONDS_PER_ROUND*1000) / UPDATE_INTERVAL_MILLIS)),
				INCORRECT_CLASS_NAME = 'incorrect',
				TIME_UP_NOTIFICATION_DURATION_MILLIS = 3000,
				roundIsOver = false,
				numCorrect = 0,
				totalPoints = 0;
				
				for(var row = 0; row < rows; row++) {
					table += "<tr>"
					for(var col = 0; col < cols; col++) {
						table += "<td id='tile"+row+"_"+col+"'></td>"
					}
					table += "</tr>";
					tilesWrapper.innerHTML = table;
				}
				
				var tr = tilesWrapper.getElementsByTagName('tr'),
				trLength = tr.length,
				offsetY = 0,
				offsetX = 0;
				
				var clickTile = function() {
					if( !this.style.opacity  ) soundServer.play('pop');
					this.style.opacity = 0;
				}
				
				for(var i = 0; i < trLength; i++) {
					var td = tr[i].getElementsByTagName('td'),
					tdLength = td.length;
					tr[i].style.top = offsetY;
					for(var j = 0; j < tdLength; j++) {
						td[j].style.backgroundImage = 'url(' + imageServer.getAsset('watermark_twilight') + ')';
						td[j].style.width = tableWidth / cols;
						td[j].style.height = tableHeight / rows;
						td[j].style.backgroundPosition = '-'+ offsetX + 'px -' + offsetY + 'px';
						td[j].style.left = offsetX;
						td[j].onclick = clickTile;
						offsetX += tableWidth / cols;
					}
					offsetX = 0;
					offsetY += tableHeight / rows;
				}
				document.getElementById('bgPic').style.display = "block";
				
				document.getElementById('answerButton').onclick = function() {
					if (this.className.match(/\bclosed\b/)) {
						this.src = imageServer.getAsset('buttonSrc_answerClose');
						this.className = '';
						document.getElementById('answerDrawer').style.right = 0;
					} else {
						this.src = imageServer.getAsset('buttonSrc_answerOpen');
						this.className = 'closed';
						document.getElementById('answerDrawer').style.right = -225;
					}
					
				}
				
				var answerList = document.getElementById('answerList').getElementsByTagName('li'),
				correctAnswer = 'answer1';
				for(var i = 0; i < 4; i++) {
					
					answerList[i].onclick = function() {
						if(this.id != correctAnswer) {
							gotWrongAnswer(this);
						} else {
							gotRightAnswer(this);
						}
					}
				}
	

			var updateHud_score = function(){
				document.getElementById('home').innerHtml = totalPoints;
			};
			
			var hideContinue = function() {
				document.getElementById('continue').style.zIndex = 40;
				document.getElementById('continue').style.right = 300;
			};
			
			var showContinue = function(text) {
				document.getElementById('continueText').innerText = document.getElementById(correctAnswer).innerText;
				document.getElementById('continue').style.zIndex = 40;
				document.getElementById('continue').style.right = 0;
			};
			
			var hideAnswerDrawer = function(){
				document.getElementById('answerDrawer').style.display = 'none';
				document.getElementById('answerDrawer').style.right = -225;
				document.getElementById('answerButton').src = imageServer.getAsset('buttonSrc_answerOpen');
			};
			
			var showTimeUp = function() {
				document.getElementById('timeUpText').style.zIndex = 40;
				document.getElementById('timeUpText').style.margin = '-50px 0 0 -150px';
				document.getElementById('timeUpText').style.opacity = 1;
			};
			
			var hideTimeUp = function() {
				document.getElementById('timeUpText').style.zIndex = 0;
				document.getElementById('timeUpText').style.margin = '50px 0 0 -150px';
				document.getElementById('timeUpText').style.opacity = 0;
			};
			
			var gotWrongAnswer = function(li){
				// Make the answer highlighted as incorrect & not clickable anymore.
				li.className = INCORRECT_CLASS_NAME;
	
				// Play sound.
				soundServer.play( 'wrongAnswer' );
	
				// Deduct points for answering incorrectly.
				pointsThisRound = (pointsThisRound - ((PERCENT_DEDUCTION_WRONG_GUESS/100) * pointsThisRound) );
				updateScoreBar();
			};
			
			var gotRightAnswer = function(li){
				// Stops the timer from counting down & the clickhandler from listening for answers, etc.
				roundIsOver = true;
	
				// Record this as a correct answer (for the stats at the end of the game).
				numCorrect++;
	
				// Move the points from the round-score to the total score.
				totalPoints = Math.round(totalPoints + pointsThisRound);
				updateHud_score();
	
				// Play sound.
				soundServer.play( 'win' );
	
				// Collapse answer-drawer.
				hideAnswerDrawer();
				
				// Reveal all tiles.
				revealAll();
				
				showContinue(li.innerText);
			};
			
			var showEndGameScreen = function(){
				// Make the end-game overlay visible (it will be fairly blank to start).
				document.getElementById('endGameOuterWrapper').style.display = 'block';
				// TODO: Fill the high score box $('#highScore')... this may require some funky communication with Titanium.
				// TODO: Fill the high score box $('#highScore')... this may require some funky communication with Titanium.
	
				// Fill the summary fields with the i18n messages and the results of the game.
				$('#endGameSummary .summaryText_completion').html( $.msg('photopop-endgame-completion-summary', self._numCorrect, self._PHOTOS_PER_GAME) );
				$('#endGameSummary .summaryText_score').html( $.msg('photopop-endgame-score-summary', self._totalPoints) );
			};
			
			var revealAll = function() {
				var tds = document.getElementsByTagName('td'),
				tdLength = tds.length,
				next = 0,
				t,
				clear = function() {
					tds[next++].style.opacity = 0;
					if(next == tdLength) {
						clearTimeout(t);
					} else {
						t = setTimeout(clear, 100);
					}

				};
				clear();
			};
			
			var timeIsUp = function(){
				roundIsOver = true;
				hideAnswerDrawer();

				soundServer.play( 'fail' );
				revealAll();
				// Show the user that the time is up & let them continue to the next round.
				showTimeUp();
		
				// After some time has passed, show the correct answer and the continue-button.
				setTimeout(continueAfterTimeIsUp, TIME_UP_NOTIFICATION_DURATION_MILLIS);
			};
			
			var continueAfterTimeIsUp = function() {
				hideTimeUp();
	
				// put the 'correct' text into the area
				showContinue();
			};
			
			var updateScoreBar = function(){
				var percent = ((pointsThisRound * 100)/ MAX_POINTS_PER_ROUND);
				var barHeight = Math.floor(percent * document.getElementById('scoreBarWrapper').clientHeight / 100);
				// Will fade the colors from green to yellow to red as we go from full points, approaching no points.
				var fgb=0;
				if(percent > 50){
	
					fgg = 255;
					fgr = Math.floor( 255-((255*((percent-50)*2))/100) ); // in english: the top half of the bar should go from 0 red to 255 red between 100% and 50%.
					
					// Change the color a bit to match the answer drawer
					fgb = 64;
					fgg = 196;
					fgr = Math.min(255, fgr + 127);
				} else {
					fgg = Math.floor( ((255*(percent*2))/100) ); // in english: the bottom half of the bar should go from 255 green to 0 green between 50% and 0%.
					fgr = 255;
					
					// Change the color a bit to match the answer drawer;
					fgg = Math.min(196, fgg);
				}
				//self.log("SCORE-FOR-ROUND PERCENT: " + Math.floor(percent) + "% ... COLOR: rgb(" + fgr + ", " + fgg + ", " + fgb + ")");

				// Update the size & color of the bar.
				document.getElementById('scoreBar').style.height = barHeight;
				document.getElementById('scoreBar').style.backgroundColor = 'rgb('+fgr+', '+fgg+', '+fgb+')';
			};
				
			var roundTimerTick = function(){
				// Time has passed, take that off of the score bar
				pointsThisRound = Math.max(0, (pointsThisRound - pointDeduction)),
				timeIsLow = false;
				updateScoreBar()

				// If the round is out of time/points, end the round... otherwise queue up the next game-clock tick.
				if((pointsThisRound <= 0) && (!roundIsOver)){
					timeIsUp();
					
				} else if(!roundIsOver){
					// If the user is low on time, play timeLow sound to increase suspense.
					if(!timeIsLow){
						var percent = ((pointsThisRound * 100)/ 1000);
						var PERCENT_FOR_TIME_IS_LOW = 25;
						if(percent < PERCENT_FOR_TIME_IS_LOW){
							soundServer.play( 'timeLow' );
							timeIsLow = true;
						}
					}
					// If the round is continuing, start the timeout again for the next tick.
					setTimeout(roundTimerTick, UPDATE_INTERVAL_MILLIS);
				}
			};
			roundTimerTick();			
			}


		}
	);
})();