var exports = exports || {};

define.call(exports, function(){
	var Timer = my.Class({
	
	});
	
	var Points = my.Class({
		
		STATIC: {
			MAX_POINTS_PER_ROUND: 1000,
			PERCENT_DEDUCTION_WRONG_GUESS: 40
		},

		numCorrect: 0,
		totalPoints: 0,
		pointsThisRound: 0,
		
		constructor: function(options) {
			options = options || {};
			this._timerPointDeduction = (Points.MAX_POINTS_PER_ROUND / ((options.maxSecondsPerRound*1000) / options.updateIntervalMillis));
		},
		
		getRoundPoints: function() {
			return this.pointsThisRound;
		},
		
		setRoundPoints: function(points) {
			this.pointsThisRound = points;
		},
		
		deductRoundPoints: function(points) {
			this.pointsThisRound -= points;
		},
		
		addRoundPoints: function(points) {
			this.pointsThisRound += points;
		},
		
		deductTimerPoints: function() {		
			this.pointsThisRound = Math.max(0, (this.pointsThisRound - this._timerPointDeduction))	
		},
		
		deductWrongGuessPoints: function() {
			this.pointsThisRound -= ((Points.PERCENT_DEDUCTION_WRONG_GUESS/100) * this.pointsThisRound);
		},
		
		getTotalPoints: function() {
			return this.totalPoints;
		},
		
		setTotalPoints: function(points) {
			this.totalPoints = points;
		},
		
		deductTotalPoints: function(points) {
			this.totalPoints -= points;
		},
		
		addTotalPoints: function(points) {
			this.totalPoints += points;
		},
		
		transferToTotal: function() {
			this.totalPoints = this.pointsThisRound;
			this.pointsThisRound = 0;
		}
	});
	
	var Game = my.Class(Observable, {
		
		STATIC: {
			INCORRECT_CLASS_NAME: 'incorrect',
			TIME_UP_NOTIFICATION_DURATION_MILLIS: 3000,
			MAX_SECONDS_PER_ROUND: 10,
			UPDATE_INTERVAL_MILLIS: 50,
			PERCENT_FOR_TIME_IS_LOW: 25
		},

		roundIsOver: false,
		
		constructor: function(options){
			options = options || {};
			
			this._id = options.id;
			this._data = options.data || [];
			this._currentRound = 0;
			this.soundServer = options.soundServer;
			this.Points = new Points({
					maxSecondsPerRound: Game.MAX_SECONDS_PER_ROUND,
					updateIntervalMillis: Game.UPDATE_INTERVAL_MILLIS
				});
			console.log(this.Points);
		},
		
		getId: function(){
			return this._id;
		},
		
		play: function(){
			console.log('Starting game: ' + this._id);
			this.next();
			this.createMask();
			this.roundTimerTick();
		},
		
		next: function(){
			if(this._currentRound < this._data.length){
				var info = this._data[this._currentRound++];
				
				this.fire('roundStart', {gameId: this._id, data: info});
			}else{
				console.log('Game completed!');
				this.fire('complete');
			}
		},
		
		pauseGame: function() {
			
		},
		
		resumeGame: function() {
			
		},
		
		createMask: function( rows, cols, watermark ) {
			rows = rows || 4;
			cols = cols || 6;
			watermark = watermark || 'watermark_dexter';
			
			var tilesWrapper = document.getElementById('tilesWrapper'),
			table = "",
			tableWidth = wrapper.clientWidth,
			tableHeight = wrapper.clientHeight,
			rowHeight = tableHeight / rows,
			colWidth = tableWidth / cols,
			trs = tilesWrapper.getElementsByTagName('tr'),
			trLength = trs.length,
			offsetY = 0,
			offsetX = 0;
			

			
			for(var row = 0; row < rows; row++) {
				table += "<tr>"
				for(var col = 0; col < cols; col++) {
					table += "<td id='tile" + row + "_" + col + "'></td>"
				}
				table += "</tr>";
				tilesWrapper.innerHTML = table;
			}
			
			for(var i = 0; i < trLength; i++) {
				var tr = trs[i],
				tds = tr.getElementsByTagName('td'),
				tdLength = tds.length;
				tr.style.top = offsetY;
				for(var j = 0; j < tdLength; j++) {
					var td = tds[j],
					tdClone = td.cloneNode(true);
					
					tdClone.style.backgroundImage = 'url(' + imageServer.getAsset(watermark) + ')';
					tdClone.style.width = colWidth;
					tdClone.style.height = rowHeight;
					tdClone.style.backgroundPosition = '-'+ offsetX + 'px -' + offsetY + 'px';
					tdClone.style.left = offsetX;
					tdClone.onclick = Game.tileClick;
					td = tdClone;
					offsetX += tableWidth / cols;
				}
				offsetX = 0;
				offsetY += colWidth;
			}
			
			document.getElementById('bgPic').style.display = "block";
		},
		
		tileClick: function() {
			soundServer.play('pop');
			this.onclick = null;
			this.style.opacity = 0;
		},
		
		answerButtonClick: function() {
			document.getElementById('answerButton').onclick = function() {
				if (this.classList.contains('closed')) {
					this.src = imageServer.getAsset('buttonSrc_answerClose');
					this.classList.remove('closed');
					document.getElementById('answerDrawer').style.right = 0;
				} else {
					this.src = imageServer.getAsset('buttonSrc_answerOpen');
					this.classList.add('closed');
					document.getElementById('answerDrawer').style.right = -225;
				}
				
			}	
		},
		
		answerClick: function() {
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
		},
		
		updateScoreBar: function(){
			var percent = ((this.pointsThisRound * 100)/ this.MAX_POINTS_PER_ROUND);
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
			var scoreBar = document.getElementById('scoreBar'),
			scoreBarClone = scoreBar.cloneNode(true);
			
			scoreBarClone.style.height = barHeight;
			scoreBarClone.style.backgroundColor = 'rgb('+fgr+', '+fgg+', '+fgb+')';
			scoreBar = scoreBarClone;
		},
		
		timeIsUp: function(){
			this.roundIsOver = true;
			this.hideAnswerDrawer();
	
			this.soundServer.play( 'fail' );
			this.revealAll();
			this.hidescoreBar();
			// Show the user that the time is up & let them continue to the next round.
			this.showTimeUp();
	
			// After some time has passed, show the correct answer and the continue-button.
			setTimeout(this.continueAfterTimeIsUp, this.TIME_UP_NOTIFICATION_DURATION_MILLIS);
		},
		
		continueAfterTimeIsUp: function() {
			this.hideTimeUp();
	
			// put the 'correct' text into the area
			this.showContinue();
		},
		
		hidescoreBar: function() {
			var scoreBar = document.getElementById('scoreBar');
			scoreBar.style.left = -20;
		},
		
		revealAll: function() {
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
		},
		
		gotRightAnswer: function(li){
			// Stops the timer from counting down & the clickhandler from listening for answers, etc.
			this.roundIsOver = true;

			// Record this as a correct answer (for the stats at the end of the game).
			numCorrect++;

			// Move the points from the round-score to the total score.
			this.Points.transferToTotal();
			this.updateHud_score();

			// Play sound.
			this.soundServer.play( 'win' );

			// Collapse answer-drawer.
			this.hideAnswerDrawer();
			
			// Reveal all tiles.
			this.revealAll();
			
			this.showContinue(li.innerText);
		},
		
		showEndGameScreen: function(){
			// Make the end-game overlay visible (it will be fairly blank to start).
			document.getElementById('endGameOuterWrapper').style.display = 'block';
			// TODO: Fill the high score box $('#highScore')... this may require some funky communication with Titanium.
			// TODO: Fill the high score box $('#highScore')... this may require some funky communication with Titanium.

			// Fill the summary fields with the i18n messages and the results of the game.
			$('#endGameSummary .summaryText_completion').html( $.msg('photopop-endgame-completion-summary', self._numCorrect, self._PHOTOS_PER_GAME) );
			$('#endGameSummary .summaryText_score').html( $.msg('photopop-endgame-score-summary', self._totalPoints) );
		},
		
		updateHud_score: function(){
			document.getElementById('home').innerHtml = this.Points.totalPoints;
		},
		
		hideContinue: function() {
			var nextRound = document.getElementById('continue'),
			nextRoundClone = nextRound.cloneNode(true);
			
			nextRound.style.zIndex = 40;
			nextRound.style.right = 300;
			nextRound = nextRoundClone;
			
		},
		
		showContinue: function(text) {
			document.getElementById('continueText').innerText = document.getElementById(correctAnswer).innerText;
			document.getElementById('continue').style.zIndex = 40;
			document.getElementById('continue').style.right = 0;
		},
		
		hideAnswerDrawer: function(){
			document.getElementById('answerDrawer').style.display = 'none';
			document.getElementById('answerDrawer').style.right = -225;
			document.getElementById('answerButton').src = imageServer.getAsset('buttonSrc_answerOpen');
		},
		
		showTimeUp: function() {
			var timeUpText = document.getElementById('timeUpText'),
			timeUpTextClone = timeUpText.cloneNode(true);
			
			timeUpTextClone.style.zIndex = 40;
			timeUpTextClone.style.margin = '-50px 0 0 -150px';
			timeUpTextClone.style.opacity = 1;
			timeUpText = timeUpTextClone;
		},
		
		hideTimeUp: function() {
			var timeUpText = document.getElementById('timeUpText'),
			timeUpTextClone = timeUpText.cloneNode(true);
			
			timeUpTextClone.style.zIndex = 0;
			timeUpTextClone.style.margin = '50px 0 0 -150px';
			timeUpTextClone.style.opacity = 0;
			timeUpText = timeUpTextClone;
		},
		
		gotWrongAnswer: function(li){
			li.className = INCORRECT_CLASS_NAME;
			li.onclick = "";
			this.soundServer.play( 'wrongAnswer' );

			// Deduct points for answering incorrectly.
			this.Points.deductWrongGuessPoints();
			this.updateScoreBar();
		},
		
		roundTimerTick: function(){
			// Time has passed, take that off of the score bar
			this.Points.deductTimerPoints();
			this.timeIsLow = false;
			this.updateScoreBar()

			// If the round is out of time/points, end the round... otherwise queue up the next game-clock tick.
			if((this.pointsThisRound <= 0) && (!this.roundIsOver)){
				this.timeIsUp();
				
			} else if(!this.roundIsOver){
				// If the user is low on time, play timeLow sound to increase suspense.
				if(!this.timeIsLow){
					var percent = ((this.Points.getRoundPoints() * 100)/ this.Points.MAX_POINTS_PER_ROUND);
					if(percent < this.PERCENT_FOR_TIME_IS_LOW){
						this.soundServer.play( 'timeLow' );
						this.timeIsLow = true;
					}
				}
				// If the round is continuing, start the timeout again for the next tick.
				setTimeout(this.roundTimerTick, this.UPDATE_INTERVAL_MILLIS);
			}
		}
	});
	
	return {
		Game: Game
	};
});