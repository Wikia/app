var exports = exports || {};
//TODO: Create animation managment system

define.call(exports, function(){
	var Points = my.Class( {

		_points: 0,
		
		constructor: function(points) {
			this._points = points || 0;
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
	
	var Game = my.Class({
		
		STATIC: {
			INCORRECT_CLASS_NAME: 'incorrect',
			TIME_UP_NOTIFICATION_DURATION_MILLIS: 3000,
			MAX_SECONDS_PER_ROUND: 15,
			UPDATE_INTERVAL_MILLIS: 500,
			PERCENT_FOR_TIME_IS_LOW: 25,
			MAX_POINTS_PER_ROUND: 1000,
			PERCENT_DEDUCTION_WRONG_GUESS: 30
		},

		_numCorrect: 0,
		_roundIsOver: false,
		_timeIsLow: false,
		_pause: true,
		_tutorialSteps: {},
		_timer: null,
		_correctAnswer: '',
		_currentRound: 0,
		_totalPoints: new Points(0),
		_barWrapperHeight: 0,
		
		constructor: function(options){
			options = options || {};
			
			Observe(this);
			this._id = options.id;
			this._data = options.data || [];
			this._numRounds = options.data.length;
			this._watermark = options.watermark;
			this._roundPoints = new Points(Game.MAX_POINTS_PER_ROUND);
			this._timerPointDeduction = Math.round((Game.MAX_POINTS_PER_ROUND / ((Game.MAX_SECONDS_PER_ROUND*1000) / Game.UPDATE_INTERVAL_MILLIS)));
			this._wrongAnswerPointDeduction = Math.round((Game.MAX_POINTS_PER_ROUND * (Game.PERCENT_DEDUCTION_WRONG_GUESS / 100)));
		},
		
		getId: function(){
			return this._id;
		},
		
		prepareGame: function(){
			console.log('Starting game: ' + this.getId());
			this.fire('renderGameScreen');
			this._barWrapperHeight = document.getElementById('scoreBarWrapper').clientHeight;
			this.prepareMask();
			this.prepareAnswerDrawer();
			this.prepareContinueView();
			this.prepareFinishScreen();
			this.prepareHud();
			this.nextRound();
		},
		
		nextRound: function(){
			if(this._currentRound < this._data.length){
				this._currentRound++
				this.play();
			}else{
				this.fire('endGame');
			}
		},
		
		play: function() {
			this._roundPoints.setPoints(Game.MAX_POINTS_PER_ROUND);
			this._timeIsLow = false;
			this._pause = true;
			this._timer = null;
			this._roundIsOver = false;
			
			this.showMask();
			this.hideContinue();
			this.showScoreBar();
			this.showAnswerDrawer();
			this.prepareAnswers();
			this.updateHudScore();
		},
		
		prepareHud: function() {
			var self = this;
			document.getElementById('totalPoints').innerHTML = '0';
			document.getElementById('home').onclick = function() {
				self.fire('goHome');
			}
		},
		
		prepareMask: function( rows, cols ) {
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
			
			var trs = tilesWrapper.getElementsByTagName('tr');
			
			for(var i = 0; i < rows; i++) {
				var tr = trs[i],
				tds = tr.getElementsByTagName('td');
				tr.style.top = offsetY;
				for(var j = 0; j < cols; j++) {
					var td = tds[j],
					tdStyle = td.style;
					tdStyle.backgroundImage = 'url(' + this._watermark+ ')';
					tdStyle.width = colWidth;
					tdStyle.height = rowHeight;
					tdStyle.backgroundPosition = '-'+ offsetX + 'px -' + offsetY + 'px';
					tdStyle.left = offsetX;
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
				self.fire('tileClicked', {tile: this});
			}
		},
		
		prepareContinueView: function() {
			var self = this;
			document.getElementById('continue').onclick = function() {
				self.fire('continueClicked');	
			}
		},
		
		prepareAnswerDrawer: function() {
			var self = this,
			answerList = document.getElementById('answerList').getElementsByTagName('li');
			
			document.getElementById('answerButton').onclick = function() {
				self.fire('answerDrawerButtonClicked', {button: this});
			};
			
			for(var i = 0; i < 4; i++) {
				answerList[i].onclick = function() {
					self.fire('answerClicked', {li: this});
				}
			};
		},
		
		prepareAnswers: function() {
			var round = this._currentRound-1,
			answers = this._data[round].answers,
			correct = this._data[round].correct,
			answerList = document.getElementById('answerList').getElementsByTagName('li'),
			order = [];

			for(var i = 0; i < 4; i++) {
				(function rand() {
					var randomNum = Math.floor(Math.random() * 4);
					if(order.indexOf(randomNum) != -1) {
						rand();
					} else {
						order[i] = randomNum;
					}
				})();
				answerList[i].clicked = false;
				answerList[i].innerHTML = answers[order[i]];
				answerList[i].classList.remove(Game.INCORRECT_CLASS_NAME);
				if(answers[order[i]] === correct) this._correctAnswer = 'answer' + i;
			}
		},
		
		prepareFinishScreen: function() {
			var self = this;
			document.getElementById('goHome').onclick = function() {
				document.getElementById('gameScreen').style.opacity = 0;
				self.fire('goHome');
			}
			
			document.getElementById('playAgain').onclick = function() {
				document.getElementById('gameScreen').style.opacity = 0;
				self.fire('playAgain');
			}
			
			document.getElementById('goToHighScores').onclick = function() {
				document.getElementById('gameScreen').style.opacity = 0;
				self.fire('goToHighScores');
			}
		},
		
		showMask: function() {
			
			this.fire('displayingMask');
			
			var tds = document.getElementsByTagName('td'),
			tdLength = tds.length,
			next = 0,
			self = this;
			
			t = setInterval(function() {
				tds[next].clicked = false;
				tds[next++].style.opacity = 1;
				if(next == tdLength) {
					clearInterval(t);
					setTimeout(function() {self.fire('maskDisplayed', {gameId: self.getId(), image: self._data[self._currentRound-1].image});}, 400);
				}
			}, 100);
		},
		
		openModal: function(options) {
			options = options || {};
			
			if(!this._tutorialSteps[options.name]) {
			
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
				
				
				if(options.closeOnClick) {
					modalWrapper.onclick = function() {
						self.closeModal();
					}
				}
			}
		},
		
		closeModal: function() {
			var modalWrapper = document.getElementById('modalWrapper'),
			modal = document.getElementById('modal');
			console.log('closeModal');
			modal.style.opacity = 0;
			modalWrapper.style.visibility = 'hidden';	
		},
		
		pause: function() {
			console.log('pause');
			this._pause = true;
			this._timer = null;
		},
		
		resume: function() {
			console.log('resume');
			if(this._pause) {
				this._pause = false;
				this.timer();
			}
		},
		
		timer: function() {
			if(!this._timer) {
				var self = this;
				(function time() {
					if( !self._pause ) {
						if((self._roundPoints.getPoints() <= 0) && (!self._roundIsOver)){
							self.fire('timeIsUp');
						} else if(!self._roundIsOver){
							self.fire('timerEvent');
							if(!self._timeIsLow){
								if(((self._roundPoints.getPoints() * 100) / Game.MAX_POINTS_PER_ROUND) < Game.PERCENT_FOR_TIME_IS_LOW){
									self.fire('timeIsLow');
									self._timeIsLow = true;
								}
							}
							self._timer = setTimeout(time, Game.UPDATE_INTERVAL_MILLIS);
						}
					}
				})();
			}
		},
		
		updateScoreBar: function(){
			var percent = ((this._roundPoints.getPoints() * 100)/ Game.MAX_POINTS_PER_ROUND),
			barHeight = Math.floor(percent * this._barWrapperHeight / 100),
			scoreBarStyle = document.getElementById('scoreBar').style;
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
			
			scoreBarStyle.height = barHeight;
			scoreBarStyle.backgroundColor = 'rgb('+fgr+', '+fgg+', '+fgb+')';
		},
		
		hideScoreBar: function() {
			document.getElementById('scoreBarWrapper').style.opacity = 0;
			this.fire('scoreBarHidden');
		},
		
		showScoreBar: function() {
			document.getElementById('scoreBarWrapper').style.opacity = 1;
		},
		
		revealAll: function() {
			var tds = document.getElementsByTagName('td'),
			tdLength = tds.length,
			next = 0,
			self = this,
			t = setInterval(function() {
				tds[next++].style.opacity = 0;
				if(next == tdLength) {
					clearInterval(t);
					self.fire('tilesShown', {correct: document.getElementById(self._correctAnswer).innerHTML});
				}
			}, 100);

		},
		
		showEndGameScreen: function(){
			document.getElementById('endGameOuterWrapper').style.display = 'block';

			document.querySelector('#endGameSummary .summaryText_completion').innerHTML = 'you got ' + this._numCorrect + ' out of ' + this._data.length + ' correct.';
			document.querySelector('#endGameSummary .summaryText_score').innerHTML =  'score: ' + this._totalPoints.getPoints();
		},
		
		updateHudScore: function(){
			document.getElementById('roundPoints').innerHTML = this._roundPoints.getPoints();
			document.getElementById('totalPoints').innerHTML = this._totalPoints.getPoints();
		},
		
		updateHudProgress: function() {
			document.getElementById('progress').getElementsByTagName('span')[0].innerHTML = this._currentRound + "/" + this._numRounds;
		},
		
		hideContinue: function() {
			var nextRound = document.getElementById('continue');
			
			nextRound.style.opacity = 0;
			nextRound.style.right = 400;
			nextRound.style.visibility = 'hidden';
			
		},
		
		showContinue: function(text) {
			var nextRound = document.getElementById('continue');
			
			document.getElementById('continueText').innerText = text || 'Next Round';
		
			nextRound.style.opacity = 1;
			nextRound.style.right = 0;
			nextRound.style.visibility = 'visible';
		},
		
		hideAnswerDrawer: function(){
			document.getElementById('answerDrawer').style.display = 'none';
			document.getElementById('answerDrawer').style.right = -225;
			this.fire('answerDrawerHidden');
		},
		
		showAnswerDrawer: function(){
			document.getElementById('answerDrawer').style.display = 'block';
		},
		
		showTimeUp: function() {
			var timeUpTextStyle = document.getElementById('timeUpText').style;
			
			timeUpTextStyle.zIndex = 40;
			timeUpTextStyle.margin = '-50px 0 0 -150px';
			timeUpTextStyle.opacity = 1;
		},
		
		hideTimeUp: function() {
			var timeUpTextStyle = document.getElementById('timeUpText').style,
			self = this;
			
			timeUpTextStyle.zIndex = 0;
			timeUpTextStyle.margin = '50px 0 0 -150px';
			timeUpTextStyle.opacity = 0;
			
			setTimeout(function() {
				self.fire('timeUpHidden',{correct: document.getElementById(self._correctAnswer).innerHTML});
			}, 1001);
		}
	});
	
	return {
		Game: Game
	};
});