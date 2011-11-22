var exports = exports || {};
//TODO: Create animation managment system

define.call(exports, ['modules/data'], function(data){
	var currentGameId = null,
	clickEvent = Wikia.Platform.getClickEvent();

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
			ROUND_LENGTH: 10,
			INCORRECT_CLASS_NAME: 'incorrect',
			TIME_UP_NOTIFICATION_DURATION_MILLIS: 3000,
			MAX_SECONDS_PER_ROUND: 15,
			UPDATE_INTERVAL_MILLIS: 500,
			PERCENT_FOR_TIME_IS_LOW: 25,
			MAX_POINTS_PER_ROUND: 1000,
			PERCENT_DEDUCTION_WRONG_GUESS: 30
		},

		_roundIsOver: false,
		_timeIsLow: false,
		_pause: true,
		_timer: null,
		_correctAnswer: '',
		_firstRound: true,

		constructor: function(options){
			options = options || {};

			Observe(this);

			this._id = options._id;
			this._numCorrect = options._numCorrect || 0;
			this._currentRound = ((currentGameId == this._id) ? options._currentRound : --options._currentRound) || 0;
			this._totalPoints = options._totalPoints? new Points(options._totalPoints): new Points();
			this._data = options._data || [];
			this._roundPoints = options._roundPoints? new Points(options._roundPoints): new Points(Game.MAX_POINTS_PER_ROUND);
			this._numRounds = options._data.length;

			this._timerPointDeduction = Math.round((Game.MAX_POINTS_PER_ROUND / ((Game.MAX_SECONDS_PER_ROUND*1000) / Game.UPDATE_INTERVAL_MILLIS)));
			this._wrongAnswerPointDeduction = Math.round((Game.MAX_POINTS_PER_ROUND * (Game.PERCENT_DEDUCTION_WRONG_GUESS / 100)));

			this.addEventListener('modalOpened', this.modalOpened);
			this.addEventListener('storeData', this.storeData);
		},

		storeData: function() {
			var self = this;
			data.storage.set(this.getId(), {
				_id: self.getId(),
				_numCorrect: self._numCorrect,
				_currentRound: self._currentRound,
				_totalPoints: self._totalPoints.getPoints(),
				_data: self._data,
				_numRounds: self._numRounds,
				_roundPoints: self._roundPoints.getPoints()
			});
		},

		getId: function(){
			return this._id;
		},

		getPercent: function() {
			return (this._roundPoints.getPoints() * 100)/ Game.MAX_POINTS_PER_ROUND;
		},

		prepareGame: function(){
			this.fire('initGameScreen', this.getId());
			this.fire('startGame', {
				gameId: this.getId()
			});
			this.prepareAnswerDrawer();
			this.prepareContinueView();
			this.prepareFinishScreen();
			this.prepareHud();
			this.prepareTiles();
			this.nextRound();
		},

		nextRound: function(){
			if(this._currentRound < this._data.length){
				this._currentRound++;
				this.play();
			}else{
				this.fire('endGame', {
					gameId: this.getId(),
					totalPoints: this._totalPoints.getPoints(),
					numCorrect: this._numCorrect,
					numTotal: this._data.length
				});
			}
		},

		play: function() {
			this._roundPoints.setPoints(Game.MAX_POINTS_PER_ROUND);
			this._timeIsLow = false;
			this._pause = true;
			this._timer = null;
			this._roundIsOver = false;

			currentGameId = this.getId();

			this.fire('roundStart', {
				gameId: this.getId(),
				image: this._data[this._currentRound-1].image,
				totalPoints: this._totalPoints.getPoints(),
				currentRound: this._currentRound,
				numRounds: this._data.length,
				firstRound: this._firstRound
			});

			this._firstRound = false;
			this.prepareAnswers();
		},

		modalOpened: function() {
			this.handlePause(true, 'modalOpened');
		},

		prepareTiles: function() {
			var divs = document.getElementById('tilesWrapper').getElementsByTagName('div'),
			divsLength = divs.length,
			self = this;

			for(var i = 0; i < divsLength; i++) {
				divs[i][clickEvent] = function() {
					self.handlePause(false);
					self.fire('tileClicked', this)
				}
			}
		},

		endRound: function(){
			this.fire('roundEnd', {
				gameId: this.getId(),
				totalPoints: this._totalPoints.getPoints(),
				currentRound: this._currentRound,
				numRounds: this._data.length
			});
		},

		prepareHud: function(){
			var self = this;

			document.getElementById('totalPoints').innerHTML = '0';

			document.getElementById('pauseButton')[clickEvent] = function() {
				self.handlePause(!self._pause, 'pauseButton');
			};
			document.getElementById('muteButton')[clickEvent] = function() {
				self.fire('muteButtonClicked', this);
			};
			document.getElementById('home')[clickEvent] = function() {
				self.handlePause(true, 'goHomeButton');
				self.fire('goHome');
			};
		},

		prepareContinueView: function() {
			var self = this;
			document.getElementById('continue')[clickEvent] = function() {
				self.nextRound();
				self.fire('continueClicked');
			}
		},

		prepareAnswerDrawer: function() {
			var self = this,
			answerList = document.getElementById('answerList').getElementsByTagName('li');
			document.getElementById('answerButton')[clickEvent] = function() {
				self.handlePause(false);
				self.fire('answerDrawerButtonClicked');
			};

			for(var i = 0; i < 4; i++) {
				answerList[i][clickEvent] = function() {
					if(!this.clicked) {
						if(this.id != self._correctAnswer) {
							self._roundPoints.deductPoints(self._wrongAnswerPointDeduction);
							self.handlePause(false);
							self.fire('wrongAnswerClicked', {li: this, percent: self.getPercent()});
						} else {
							self._roundIsOver = true;
							self._timer = null;
							// Record this as a correct answer (for the stats at the end of the game).
							self._numCorrect++;
							// Move the points from the round-score to the total score.
							self._totalPoints.addPoints(self._roundPoints.getPoints());
							self._roundPoints.setPoints(0);
							self.fire('rightAnswerClicked', this.innerHTML);
							self.endRound();
						}
					}

				}
			};
		},

		prepareAnswers: function() {
			var round = this._currentRound-1,
			answers = this._data[round].answers,
			correct = this._data[round].correct;

			answers.shuffle();

			this.fire('answersPrepared', {
				answers:answers,
				"class":Game.INCORRECT_CLASS_NAME
			});

			this._correctAnswer = 'answer' + answers.indexOf(correct);
		},

		prepareFinishScreen: function() {
			var self = this;
			document.getElementById('goHome')[clickEvent] = function() {
				self.handlePause(true);
				self.fire('goHome', true);
			};

			document.getElementById('playAgain')[clickEvent] = function() {
				self.handlePause(true);
				self.fire('playAgain');
			};

			document.getElementById('goToHighScores')[clickEvent] = function() {
				self.handlePause(true);
				self.fire('goToHighScores');
			};

			document.getElementById('playAgain').style.visibility = (this._id == 'tutorial') ? 'hidden' : 'visible';
		},

		handlePause: function(state, caller) {
			state = state || false;
			this._pause = state;

			if(state) {
				this._timer = null;
			} else {
				this.timer();
			}

			this.fire('pause', {pause: state, caller: caller});
		},

		timer: function() {
			if(!this._timer) {
				var self = this;
				(function time() {
					if( !self._pause ) {
						if((self._roundPoints.getPoints() <= 0) && (!self._roundIsOver)){
							self.roundIsOver = true;
							self.fire('timeIsUp', {
								totalPoints: self._totalPoints.getPoints(),
								timeout: Game.TIME_UP_NOTIFICATION_DURATION_MILLIS,
								correct: self._correctAnswer
							});
							self.endRound();
						} else if(!self._roundIsOver){
							self._roundPoints.deductPoints(self._timerPointDeduction);
							self.fire('timerEvent', self.getPercent());
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
		}
	});

	return {
		getCurrentId: function(){
			return currentGameId;
		},

		Game: Game
	};
});