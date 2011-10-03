var exports = exports || {};

define.call(exports, function(){
	var Points = my.Class( {
		
		STATIC: {
			MAX_POINTS_PER_ROUND: 1000,
			PERCENT_DEDUCTION_WRONG_GUESS: 40
		},

		_totalPoints: 0,
		_pointsThisRound: 0,
		
		constructor: function(options) {
			options = options || {};
			this._pointsThisRound = Points.MAX_POINTS_PER_ROUND;
			this._timerPointDeduction = (Points.MAX_POINTS_PER_ROUND / ((options.maxSecondsPerRound*1000) / options.updateIntervalMillis));
		},
		
		getRoundPoints: function() {
			return this._pointsThisRound;
		},
		
		setRoundPoints: function(points) {
			this._pointsThisRound = Math.round(points);
		},
		
		deductRoundPoints: function(points) {
			this._pointsThisRound -= Math.round(points);
		},
		
		addRoundPoints: function(points) {
			this._pointsThisRound += Math.round(points);
		},
		
		deductTimerPoints: function() {		
			this._pointsThisRound = Math.max(0, (this._pointsThisRound - this._timerPointDeduction))	
		},
		
		deductWrongGuessPoints: function() {
			this._pointsThisRound -= ((Points.PERCENT_DEDUCTION_WRONG_GUESS/100) * this._pointsThisRound);
		},
		
		getTotalPoints: function() {
			return this._totalPoints;
		},
		
		setTotalPoints: function(points) {
			this._totalPoints = points;
		},
		
		deductTotalPoints: function(points) {
			this._totalPoints -= points;
		},
		
		addTotalPoints: function(points) {
			this._totalPoints += points;
		},
		
		transferToTotal: function() {
			this._totalPoints = this._pointsThisRound;
			this._pointsThisRound = 0;
		}
	});
	
	var Game = my.Class(Observable, {
		
		STATIC: {
			INCORRECT_CLASS_NAME: 'incorrect',
			TIME_UP_NOTIFICATION_DURATION_MILLIS: 3000,
			MAX_SECONDS_PER_ROUND: 10,
			UPDATE_INTERVAL_MILLIS: 1000,
			PERCENT_FOR_TIME_IS_LOW: 30
		},

		_numCorrect: 0,
		_roundIsOver: false,
		_timeIsLow: false,
		_pause: false,
		
		constructor: function(options){
			options = options || {};
			
			this._id = options.id;
			this._data = options.data || [];
			this._currentRound = 0;
			this._watermark = options.watermark;
			this._points = new Points({
					maxSecondsPerRound: Game.MAX_SECONDS_PER_ROUND,
					updateIntervalMillis: Game.UPDATE_INTERVAL_MILLIS
				});
		},
		
		getId: function(){
			return this._id;
		},
		
		play: function(){
			console.log('Starting game: ' + this._id);
			this.next();
			this.createMask();
			this.startActivator();
			this.answerButtonClick();
			this.answerClick();
			if(this._id == "tutorial")
				this.fire('tutorialStart', {});
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
		
		startActivator: function() {
			var self = this;
			document.getElementById('wrapper').onclick = function() {
				self.timer();
				this.onclick = null;
			}
		},
		
		pause: function() {
			this._pause = true;
		},
		
		resume: function() {
			this._pause = false;
			this.timer();
		},
		
		timer: function() {
			// Time has passed, take that off of the score bar

			self = this;
						
			(function time() {
				if( !self._pause ) {
					self._points.deductTimerPoints();
					self.updateScoreBar();
					// If the round is out of time/points, end the round... otherwise queue up the next game-clock tick.
					if((self._points.getRoundPoints() <= 0) && (!self._roundIsOver)){
						self.timeIsUp();
						
					} else if(!self._roundIsOver){
						// If the user is low on time, play timeLow sound to increase suspense.
						if(!self._timeIsLow){
							var percent = ((self._points.getRoundPoints() * 100)/ Points.MAX_POINTS_PER_ROUND);
							if(percent < Game.PERCENT_FOR_TIME_IS_LOW){
								self.fire('playSound', {name: 'timeLow'});
								self._timeIsLow = true;
							}
						}
						setTimeout(time, Game.UPDATE_INTERVAL_MILLIS);
					}
				}
			})();	
		},
		
		createMask: function( rows, cols ) {
			rows = rows || 4;
			cols = cols || 6;
			
			var tilesWrapper = document.getElementById('tilesWrapper'),
			table = "",
			tableWidth = wrapper.clientWidth,
			tableHeight = wrapper.clientHeight,
			rowHeight = tableHeight / rows,
			colWidth = tableWidth / cols,
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
			
			var trs = tilesWrapper.getElementsByTagName('tr'),
			trLength = trs.length;

			
			for(var i = 0; i < trLength; i++) {
				var tr = trs[i],
				tds = tr.getElementsByTagName('td'),
				tdLength = tds.length;
				tr.style.top = offsetY;
				for(var j = 0; j < tdLength; j++) {
					var td = tds[j];
					td.style.backgroundImage = 'url(' + this._watermark+ ')';
					td.style.width = colWidth;
					td.style.height = rowHeight;
					td.style.backgroundPosition = '-'+ offsetX + 'px -' + offsetY + 'px';
					td.style.left = offsetX;
					td.onclick = this.tileClick();
					offsetX += tableWidth / cols;
				}
				offsetX = 0;
				offsetY += colWidth;
			}
			
			document.getElementById('bgPic').style.display = "block";
		},
		
		tileClick: function() {
			var self = this;
			return function() {
				if(!self._pause) {
					self.fire('playSound', {name: 'pop'});
					this.onclick = null;
					this.style.opacity = 0;	
				}

			}
		},
		
		answerButtonClick: function() {
			document.getElementById('answerButton').onclick = function() {
				if(!self._pause) {
					if (this.classList.contains('closed')) {
						this.getElementsByTagName('img')[0].style.opacity = 0;
						this.getElementsByTagName('img')[1].style.opacity = 1;
						this.classList.remove('closed');
						document.getElementById('answerDrawer').style.right = 0;
					} else {
						this.getElementsByTagName('img')[1].style.opacity = 0;
						this.getElementsByTagName('img')[0].style.opacity = 1;
						this.classList.add('closed');
						document.getElementById('answerDrawer').style.right = -225;
					}
				}
			}	
		},
		
		answerClick: function() {
			var answerList = document.getElementById('answerList').getElementsByTagName('li'),
			correctAnswer = 'answer1',
			self = this;
			
			for(var i = 0; i < 4; i++) {
				answerList[i].onclick = function() {
					if(this.id != correctAnswer) {
						self.gotWrongAnswer(this);
					} else {
						self.gotRightAnswer(this);
					}
				}
			}	
		},
		
		updateScoreBar: function(){
			var percent = ((this._points.getRoundPoints() * 100)/ Points.MAX_POINTS_PER_ROUND);
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
			//console.log("SCORE-FOR-ROUND PERCENT: " + Math.floor(percent) + "% ... COLOR: rgb(" + fgr + ", " + fgg + ", " + fgb + ")");

			// Update the size & color of the bar.
			var scoreBar = document.getElementById('scoreBar');
			
			scoreBar.style.height = barHeight;
			scoreBar.style.backgroundColor = 'rgb('+fgr+', '+fgg+', '+fgb+')';
		},
		
		timeIsUp: function(){
			this.roundIsOver = true;
			this.hideAnswerDrawer();

			this.fire('playSound', {name: 'fail'});
			this.revealAll();
			this.hidescoreBar();
			// Show the user that the time is up & let them continue to the next round.
			this.showTimeUp();
	
			// After some time has passed, show the correct answer and the continue-button.
			setTimeout(this.continueAfterTimeIsUp(), Game.TIME_UP_NOTIFICATION_DURATION_MILLIS);
		},
		
		continueAfterTimeIsUp: function() {
			var self = this;
			return function() {
				self.hideTimeUp();
				// put the 'correct' text into the area
				self.showContinue();
			}

		},
		
		hidescoreBar: function() {
			var scoreBar = document.getElementById('scoreBarWrapper');
			scoreBar.style.opacity = 0;
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
			this._roundIsOver = true;

			// Record this as a correct answer (for the stats at the end of the game).
			this._numCorrect++;

			// Move the points from the round-score to the total score.
			this._points.transferToTotal();
			this.updateHud_score();
			this.hidescoreBar();
			// Play sound.
			this.fire('playSound', {name: 'win'});

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
			document.getElementById('score').innerText = this._points.getTotalPoints();
		},
		
		hideContinue: function() {
			var nextRound = document.getElementById('continue'),
			nextRoundClone = nextRound.cloneNode(true);
			
			nextRound.style.zIndex = 40;
			nextRound.style.right = 300;
			nextRound = nextRoundClone;
			
		},
		
		showContinue: function(text) {
			document.getElementById('continueText').innerText = 'WIN';
			document.getElementById('continue').style.zIndex = 40;
			document.getElementById('continue').style.right = 0;
		},
		
		hideAnswerDrawer: function(){
			document.getElementById('answerDrawer').style.display = 'none';
			document.getElementById('answerDrawer').style.right = -225;
			document.getElementById('answerButton').src = '';
		},
		
		showTimeUp: function() {
			var timeUpText = document.getElementById('timeUpText')
			
			timeUpText.style.zIndex = 40;
			timeUpText.style.margin = '-50px 0 0 -150px';
			timeUpText.style.opacity = 1;
		},
		
		hideTimeUp: function() {
			var timeUpText = document.getElementById('timeUpText');
			
			timeUpText.style.zIndex = 0;
			timeUpText.style.margin = '50px 0 0 -150px';
			timeUpText.style.opacity = 0;
		},
		
		showTutorialPopUp: function() {
			
		},
		
		hideTutorialPopUp: function() {
			
		},
		
		gotWrongAnswer: function(li){
			li.className = Game.INCORRECT_CLASS_NAME;
			li.onclick = null;
			this.fire('playSound', {name: 'wrongAnswer'});

			// Deduct points for answering incorrectly.
			this._points.deductWrongGuessPoints();
			this.updateScoreBar();
		}
	});
	
	return {
		Game: Game
	};
});