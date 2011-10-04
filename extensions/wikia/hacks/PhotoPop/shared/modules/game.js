var exports = exports || {};

define.call(exports, function(){
	var Points = my.Class( {

		_points: 0,
		
		constructor: function(options) {
			options = options || {};
			this._points = options.points || 1000;
		},
		
		getPoints: function() {
			return this._points;
		},
		
		setPoints: function(points) {
			this._points = Math.round(points);
		},
		
		deductPoints: function(points) {
			this._points = Math.max(0, (this._points - Math.round(points)));
		},
		
		addPoints: function(points) {
			this._points += Math.round(points);
		}
	});
	
	var Game = my.Class(Observable, {
		
		STATIC: {
			INCORRECT_CLASS_NAME: 'incorrect',
			TIME_UP_NOTIFICATION_DURATION_MILLIS: 3000,
			MAX_SECONDS_PER_ROUND: 20,
			UPDATE_INTERVAL_MILLIS: 50,
			PERCENT_FOR_TIME_IS_LOW: 30,
			MAX_POINTS_PER_ROUND: 1000,
			PERCENT_DEDUCTION_WRONG_GUESS: 40
		},

		_numCorrect: 0,
		_roundIsOver: false,
		_timeIsLow: false,
		_pause: false,
		_tileClicked: false,
		_answerButtonClicked: false,
		_tutorialSteps: [],
		_timer: null,
		
		constructor: function(options){
			options = options || {};
			
			this._id = options.id;
			this._data = options.data || [];
			this._currentRound = 0;
			this._watermark = options.watermark;
			this._roundPoints = new Points();
			this._totalPoints = new Points();
			this._timerPointDeduction = Math.round((Game.MAX_POINTS_PER_ROUND / ((Game.MAX_SECONDS_PER_ROUND*1000) / Game.UPDATE_INTERVAL_MILLIS)));
			this._wrongAnswerPointDeduction = Math.round((Game.MAX_POINTS_PER_ROUND * (Game.PERCENT_DEDUCTION_WRONG_GUESS / 100)));
			
			this.addEventListener('modalOpened', this.modalOpened);
			this.addEventListener('modalClosed', this.modalClosed);
			this.addEventListener('wrongAnswerClicked', this.wrongAnswerClicked);
			this.addEventListener('rightAnswerClicked', this.rightAnswerClicked);
			this.addEventListener('answerDrawerClosed', this.answerDrawerClosed);
			this.addEventListener('answerDrawerOpened', this.answerDrawerOpened);
			this.addEventListener('answerDrawerButtonClicked', this.answerDrawerButtonClicked);
			this.addEventListener('continueClicked', this.continueClicked);
		},
		
		getId: function(){
			return this._id;
		},
		
		play: function(){
			console.log('Starting game: ' + this._id);
			this.next();
			this.createMask();
			this.answerButtonClick();
			this.answerClick();
			this.continueClick();
			if(this._id == 'tutorial') this.openModal({
				name: 'intro',
				html: "Tap the screen to take a peek of the mystery image underneath.",
				fade: true,
				clickThrough: false,
				closeOnClick: true});
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
		
		continueClick: function() {
			var self = this;
			document.getElementById('continue').onclick = function() {
				self.fire('continueClicked');	
			}

		},
		
		continueClicked: function() {
			this.play();
		},
		
		modalOpened: function(event, options) {
			console.log('modal opened: ' + options.name);
			if(this._id == 'tutorial') {
				this.pause();
				this._tutorialSteps.push(options.name);
				console.log(this._tutorialSteps);
			}
		},
		
		modalClosed: function(event, options) {
			console.log('modal closed: ' + options.name);
		},
		
		openModal: function(options) {
			options = options || {};
			
			var modalWrapper = document.getElementById('modalWrapper'),
			modal = document.getElementById('modal'),
			self = this;
			
			if(options.fontSize) {
				modal.style.fontSize = options.fontSize;
			}
			
			if(options.fade) {
				modal.classList.add('transition-all');
			} else {
				modal.classList.remove('transition-all');
			}
			
			if(options.triangle) {
				modal.classList.add('triangle');
				modal.classList.add(options.triangle);
			}
			
			modalWrapper.style.visibility = 'visible';
			modal.style.opacity = 0.8;
			
			if( options.clickThrough ) {
				modalWrapper.style.pointerEvents = 'none';
				modal.style.pointerEvents = 'auto';
			} else {
				modalWrapper.style.pointerEvents = 'auto';
			}
			
			if(options.html) {
				modal.innerHTML = options.html;
			}
			
			this.fire('modalOpened', {name: options.name});
			
			modalWrapper.onclick = function() {
				if(options.closeOnClick) {
					self.fire('modalClosed', {name: options.name});
					
					modal.style.opacity = 0;
					modalWrapper.style.visibility = 'hidden';
				}

			}
		},
		
		pause: function() {
			this._pause = true;
			this._timer = null;
		},
		
		resume: function() {
			this._pause = false;
			this.timer();
		},
		
		timer: function() {
			// Time has passed, take that off of the score bar

			self = this;
			if(!self._timer) {	
				(function time() {
					if( !self._pause ) {
						self._roundPoints.deductPoints(self._timerPointDeduction);
						self.updateScoreBar();
						self.updateHud_score();
						// If the round is out of time/points, end the round... otherwise queue up the next game-clock tick.
						if((self._roundPoints.getPoints() <= 0) && (!self._roundIsOver)){
							self.timeIsUp();
							
						} else if(!self._roundIsOver){
							// If the user is low on time, play timeLow sound to increase suspense.
							if(!self._timeIsLow){
								var percent = ((self._roundPoints.getPoints() * 100)/ Points.MAX_POINTS_PER_ROUND);
								if(percent < Game.PERCENT_FOR_TIME_IS_LOW){
									self.fire('playSound', {name: 'timeLow'});
									self._timeIsLow = true;
								}
							}
							self._timer = setTimeout(time, Game.UPDATE_INTERVAL_MILLIS);
						}
					}
				})();
			}
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
				if(self._pause) self.resume();
				self.fire('playSound', {name: 'pop'});
				this.onclick = null;
				this.style.opacity = 0;
				self.resume();
				if(self._id == "tutorial" && !self._tileClicked) {
					self._tileClicked = true;
					self.pause();
					self.openModal({
						name: 'tile',
						html:'Tap the "answer" button to make your guess.',
						fade: true,
						clickThrough: false,
						closeOnClick: true,
						triangle: 'right'});
				}
			}
		},
		
		answerDrawerButtonClicked: function(event, options) {
			console.log('answerDrawerButtonClicked');
			var button = options.button;
			
			if(!this._pause || this._id == 'tutorial') {
				if (button.classList.contains('closed')) {
					button.getElementsByTagName('img')[0].style.opacity = 0;
					button.getElementsByTagName('img')[1].style.opacity = 1;
					button.classList.remove('closed');
					document.getElementById('answerDrawer').style.right = 0;
					this.fire('answerDrawerOpened');
				} else {
					button.getElementsByTagName('img')[1].style.opacity = 0;
					button.getElementsByTagName('img')[0].style.opacity = 1;
					button.classList.add('closed');
					document.getElementById('answerDrawer').style.right = -225;
					this.fire('answerDrawerClosed');
				}
			}
		},
		
		answerDrawerOpened: function() {
			console.log('answerDrawerOpened');
			this.openModal({
				name: 'drawer',
				html: 'The fewer peek you take, the fewer guesses you make, and the less time you take, the bigger your score!',
				fade: true,
				clickThrough: false,
				fontSize: 'x-large',
				closeOnClick: true});
		},
		
		answerDrawerClosed: function() {
			console.log('answerDrawerClosed');		
		},
		
		answerButtonClick: function() {
			var self = this;
			document.getElementById('answerButton').onclick = function() {
				self.fire('answerDrawerButtonClicked', {button: this});
			}
		},
		
		answerClick: function() {
			var answerList = document.getElementById('answerList').getElementsByTagName('li'),
			correctAnswer = 'answer1',
			self = this;
			
			for(var i = 0; i < 4; i++) {
				answerList[i].onclick = function() {
					if(this.id != correctAnswer) {
						self.fire('wrongAnswerClicked', {li: this});
					} else {
						self.fire('rightAnswerClicked', {li: this});
					}
				}
			}	
		},
		
		updateScoreBar: function(){
			var percent = ((this._roundPoints.getPoints() * 100)/ Game.MAX_POINTS_PER_ROUND);
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

		wrongAnswerClicked: function(event, options) {
			console.log('wrongAnswerClicked');
			
			var li = options.li;
			
			li.className = Game.INCORRECT_CLASS_NAME;
			li.onclick = null;
			this.fire('playSound', {name: 'wrongAnswer'});

			// Deduct points for answering incorrectly.
			this._roundPoints.deductPoints(this._wrongAnswerPointDeduction);
			this.updateScoreBar();
			this.updateHud_score();
		},
		
		rightAnswerClicked: function(event, options) {
			console.log('rightAnswerClicked');
			// Stops the timer from counting down & the clickhandler from listening for answers, etc.
			if(this._id == 'tutorial') {
				this.openModal({
					name: 'continue',
					html: 'After the answer is revealed tap the "next" button to continue on to a new image.',
					fade: true,
					clickThrough: false,
					closeOnClick: true});
			}
			this._roundIsOver = true;

			// Record this as a correct answer (for the stats at the end of the game).
			this._numCorrect++;

			// Move the points from the round-score to the total score.
			this._totalPoints.addPoints(this._roundPoints.getPoints());
			this._roundPoints.setPoints(0);
			this.updateHud_score();
			this.hidescoreBar();
			// Play sound.
			this.fire('playSound', {name: 'win'});

			// Collapse answer-drawer.
			this.hideAnswerDrawer();
			
			// Reveal all tiles.
			this.revealAll();
			
			this.showContinue(options.li.innerText);
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
			document.getElementById('score').innerText = this._roundPoints.getPoints();
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
			
		}
	});
	
	return {
		Game: Game
	};
});