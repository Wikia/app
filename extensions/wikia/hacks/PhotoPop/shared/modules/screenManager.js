var exports = exports || {};

define.call(exports, function(){
	var screens = {},
	lastScreen;
	
	Screen = my.Class({
		_screenId: '',
		_domElement: null,
		_origDisplay: '',
		_manager: null,
		_this: this,
		
		constructor: function(id, manager){
			this._domElement = document.getElementById(id + 'Screen');
			
			if(!this._domElement) throw "Couldn't find screen '" + id + "'";
				
			this._manager = manager;
			this._screenId = id;
			this._origDisplay = (this._domElement.style.display && this._domElement.style.display != 'none') ? this._domElement.style.display : 'block';
			Observe(this);
			
			switch(id){
				case 'game':
					return new GameScreen(this);
				case 'home':
					return new HomeScreen(this);
				case 'highscore':
					return new HighscoreScreen(this);
			};
			return this;
		},
		
		hide: function(){
			this._domElement.style.display = 'none';
			this._manager.fire('hide', {id: this._screenId});
			return this;
		},
		
		show: function(){
			this._domElement.style.display = this._origDisplay;
			this._manager.fire('show', {id: this._screenId});
			return this;
		},
		
		getElement: function(){
			return this._domElement;
		}
	}),
	
	GameScreen = my.Class({
		
		_barWrapperHeight: 0,

		constructor: function(parent) {
			console.log('Game Screen created');
			Observe(this);
			this._parent = parent;
		},
		
		show: function() {
			return this._parent.show();
		},
		hide: function() {
			return this._parent.hide();
		},
		getElement: function() {
			return this._parent.getElement();
		},
		
		init: function(mute) {
			this._barWrapperHeight = document.getElementById('PhotoPopWrapper').clientHeight;

			this.addEventListener('prepareGameScreen', this.prepareGameScreen);
			this.addEventListener('tileClicked', this.tileClicked);
			this.addEventListener('answerDrawerButtonClicked', this.answerDrawerButtonClicked);
			this.addEventListener('rightAnswerClicked', this.rightAnswerClicked);
			this.addEventListener('wrongAnswerClicked', this.wrongAnswerClicked);
			this.addEventListener('timerEvent', this.timerEvent);
			this.addEventListener('muteButtonClicked', this.muteButtonClicked);
			this.addEventListener('answersPrepared', this.answersPrepared);
			this.addEventListener('roundStart', this.roundStart);
			this.addEventListener('tileClicked', this.tileClicked);
			this.addEventListener('timeIsUp', this.timeIsUp);
			this.addEventListener('continueClicked', this.continueClicked);
			this.addEventListener('endGame', this.endGame);
			this.addEventListener('paused', this.paused);
			this.addEventListener('resumed', this.resumed);
			this.addEventListener('goHomeClicked', this.goHomeClicked);
		},
		
		goHomeClicked: function(e, gameFinished) {
			if(gameFinished) {
				//this.prepareGameScreen();
			}
		},
		
		resumed: function() {
			document.getElementById('pauseButton').getElementsByTagName('img')[0].style.visibility = 'hidden';
			document.getElementById('pauseButton').getElementsByTagName('img')[1].style.visibility = 'visible';
		},
		
		paused: function() {
			document.getElementById('pauseButton').getElementsByTagName('img')[1].style.visibility = 'hidden';
			document.getElementById('pauseButton').getElementsByTagName('img')[0].style.visibility = 'visible';
		},
		
		endGame: function(e, options) {
			this.showEndGameScreen(options);
		},
		
		continueClicked: function() {
			this.showAnswerDrawer();
			this.showScoreBar();
			this.hideContinue();
		},
		
		timeIsUp: function(e, options) {
			var self = this;
			this.hideAnswerDrawer();
			this.hideScoreBar();
			this.showTimeUp();
			this.updateHudScore(options.totalPoints);
			setTimeout(function() {
				self.hideTimeUp(options.correct);
			}, options.timeout);	
		},
		
		prepareGameScreen: function(e, options) {
			this.prepareMask(options.watermark);
			this.hideContinue();
			this.showScoreBar();
			this.hideAnswerDrawer();//puts the drawer back in place
			this.showAnswerDrawer();
			this.hideEndGameScreen();//needs to hide previously shown final screen
			this.updateScoreBar(100);//resets the scorebar
			this.updateMuteButton(options.mute);
		},
		
		roundStart: function(e, options) {
			this.showMask(options);
			this.updateHudProgress(options.currentRound, options.numRounds);
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
				
				if(options.closeOnClick) {
					modalWrapper.onclick = function() {
						self.closeModal();
					}
				}
		},
		
		closeModal: function() {
			var modalWrapper = document.getElementById('modalWrapper'),
			modal = document.getElementById('modal');
			modal.classList.remove('triangle');
			modal.style.opacity = 0;
			modalWrapper.style.visibility = 'hidden';	
		},
		
		timerEvent: function(event, percent) {
			this.updateScoreBar(percent);
			//this.updateHudScore();
		},
		
		muteButtonClicked: function(event, mute) {
			this.updateMuteButton(mute.mute);
		},
		
		prepareMask: function( watermark, rows, cols ) {
			rows = rows || 4;
			cols = cols || 6;
			
			var tilesWrapper = document.getElementById('tilesWrapper'),
			screenElement = document.getElementById('PhotoPopWrapper'),
			table = "",
			tableWidth = screenElement.clientWidth,
			tableHeight = screenElement.clientHeight,
			rowHeight = Math.floor(tableHeight / rows),
			colWidth = Math.floor(tableWidth / cols),
			offsetY = 0,
			offsetX = 0,
			self = this;
			
			for(var row = 0; row < rows; row++) {
				table += "<tr>"
				for(var col = 0; col < cols; col++) {
					table += "<td id='tile" + row + "_" + col + "'></td>"
				}
				table += "</tr>";
				tilesWrapper.innerHTML = table;
			}
			
			var trs = tilesWrapper.getElementsByTagName('tr'),
			lastCol = cols - 1,
			lastRow = rows - 1;
			
			for(var i = 0; i < rows; i++) {
				var tr = trs[i],
				tds = tr.getElementsByTagName('td');
				
				tr.style.top = offsetY;
				
				for(var j = 0; j < cols; j++) {
					var td = tds[j],
					tdStyle = td.style;
					tdStyle.backgroundImage = 'url(' + watermark + ')';
					tdStyle.width = (j == lastCol) ? tableWidth - (colWidth * j) : colWidth;
					tdStyle.height = (i == lastRow) ? tableHeight - (rowHeight * i) : rowHeight;
					tdStyle.backgroundPosition = '-'+ offsetX + 'px -' + offsetY + 'px';
					tdStyle.left = offsetX;
					offsetX += colWidth;
				}
				
				offsetX = 0;
				offsetY += rowHeight;
			}
			
			document.getElementById('bgPic').style.display = "block";

		},
		
		tileClicked: function(event, tile) {
			tile.clicked = true;
			tile.style.opacity = 0;
		},
		
		answerDrawerButtonClicked: function(event, options) {
			var button = document.getElementById('answerButton'),
			buttonClassList = button.classList,
			imgs = button.getElementsByTagName('img');
			
			if (buttonClassList.contains('closed')) {
				imgs[0].style.opacity = 0;
				imgs[1].style.opacity = 1;
				buttonClassList.remove('closed');
				document.getElementById('answerDrawer').style.right = 0;
			} else {
				imgs[1].style.opacity = 0;
				imgs[0].style.opacity = 1;
				buttonClassList.add('closed');
				document.getElementById('answerDrawer').style.right = -225;
			}
		},
		
		answersPrepared: function(e, options) {
			var answerList = document.getElementById('answerList').getElementsByTagName('li'),
			answerListLength = answerList.length;
			
			for(var i = 0; i < answerListLength; i++) {
				answerList[i].clicked = false;
				answerList[i].innerHTML = options.answers[i];
				answerList[i].classList.remove(options['class']);
			}
		},
		
		wrongAnswerClicked: function(event, options) {
			var li = options.li;
			li.className = options["class"];
			li.clicked = true;
			this.updateScoreBar(options.percent);
			//this.updateHudScore();
		},
		
		rightAnswerClicked: function(event, correct) {
			this.hideScoreBar();
			this.revealAll(correct);
			this.hideAnswerDrawer();
		},
		
		updateScoreBar: function(percent){
			var barHeight = Math.floor(percent * this._barWrapperHeight / 100),
			scoreBarStyle = document.getElementById('scoreBar').style,
			fgb = 0, fgg = 0, fgr = 0;
			
			// Will fade the colors from green to yellow to red as we go from full points, approaching no points.
			if(percent > 50){
				//in english: the top half of the bar should go from 0 red to 255 red between 100% and 50%.
				fgr = Math.min(255, (Math.floor( 255-((255*((percent-50)*2))/100))  + 127) ); 
				fgb = 64;
				fgg = 196;
			} else {
				//in english: the bottom half of the bar should go from 255 green to 0 green between 50% and 0%.				
				fgg = Math.min(196, Math.floor( ((255*(percent*2))/100) ));
				fgr = 255;
			}

			scoreBarStyle.height = barHeight;
			scoreBarStyle.backgroundColor = 'rgb('+fgr+', '+fgg+', '+fgb+')';
		},
		
		hideScoreBar: function() {
			var scoreBarStyle = document.getElementById('scoreBar').style;
			
			document.getElementById('scoreBarWrapper').style.opacity = 0;
			
			scoreBarStyle.height = this._barWrapperHeight;
			scoreBarStyle.backgroundColor = 'rgba(137, 196, 64, 0.9)';
		},
		
		revealAll: function(correct) {
			var tds = document.getElementsByTagName('td'),
			tdLength = tds.length,
			next = 0,
			self = this,
			td,
			t = setInterval(function() {
				td = tds[next++];
				td.style.opacity = 0;
				td.clicked = true;
				if(next == tdLength) {
					clearInterval(t);
					self.showContinue(correct);
				}
			}, 100);

		},
		
		showMask: function(options) {
			this.fire('displayingMask', options);
			var tds = document.getElementsByTagName('td'),
			tdLength = tds.length,
			next = 0,
			self = this,
			t = setInterval(function() {
				tds[next].clicked = false;
				tds[next++].style.opacity = 1;
				if(next == tdLength) {
					clearInterval(t);
					console.log('done');
					self.updateHudScore(options.totalPoints);
					setTimeout(function() {self.fire('maskDisplayed');}, 400);
				}
			}, 50);
		},
		
		hideAnswerDrawer: function(){
			var answerDrawerStyle = document.getElementById('answerDrawer').style,
			answerButton = document.getElementById('answerButton');
			
			answerDrawerStyle.display = 'none';
			answerDrawerStyle.right = -225;

			answerButton.classList.add('closed');
			answerButton.getElementsByTagName('img')[1].style.opacity = 0;
			answerButton.getElementsByTagName('img')[0].style.opacity = 1;
		},
		
		showContinue: function(text) {
			var nextRoundStyle = document.getElementById('continue').style,
			hudStyle = document.getElementById('hud').style;
			document.getElementById('continueText').innerHTML = wgMessages['photopop-game-continue'] + " " + text;
			nextRoundStyle.right = '0%';
			hudStyle.left = '100%';
		},
		
		hideContinue: function() {
			var nextRoundStyle = document.getElementById('continue').style,
			hudStyle = document.getElementById('hud').style;
			
			nextRoundStyle.right = '100%';
			hudStyle.left = '0%';
		},
		
		showScoreBar: function() {
			document.getElementById('scoreBarWrapper').style.opacity = 1;
		},
		
		showEndGameScreen: function(options){
			//TODO: reset whole game
			document.getElementById('endGameOuterWrapper').style.display = 'block';

			document.querySelector('#endGameSummary .summaryText_completion').innerHTML = wgMessages['photopop-game-yougot'] + ' ' + options.numCorrect + ' ' + wgMessages['photopop-game-outof'] + ' ' + options.numTotal + ' ' + wgMessages['photopop-game-correct'];
			document.querySelector('#endGameSummary .summaryText_score').innerHTML =  wgMessages['photopop-game-score'] + ': ' + options.totalPoints;
		},
		
		hideEndGameScreen: function(){
			document.getElementById('endGameOuterWrapper').style.display = 'none';
		},
		
		updateHudScore: function(totalPoints){
			//document.getElementById('roundPoints').innerHTML = roundPoints;
			document.getElementById('totalPoints').innerHTML = totalPoints;
		},
		
		updateHudProgress: function(currentRound, numRounds) {
			document.getElementById('progress').getElementsByTagName('span')[0].innerHTML = currentRound + '/' + numRounds;
		},
		
		updateMuteButton: function(mute) {
			var button = document.getElementById('muteButton').getElementsByTagName('img');
			console.log('game:' + mute);
			if(mute) {
				button[0].style.visibility = 'hidden';
				button[1].style.visibility = 'visible';
			} else {
				button[1].style.visibility = 'hidden';
				button[0].style.visibility = 'visible';
			}
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
		
		hideTimeUp: function(correct) {
			var timeUpTextStyle = document.getElementById('timeUpText').style,
			self = this;
			
			timeUpTextStyle.zIndex = 0;
			timeUpTextStyle.margin = '50px 0 0 -150px';
			timeUpTextStyle.opacity = 0;
			
			setTimeout(function() {
				self.revealAll(document.getElementById(correct).innerHTML);
			}, 1001);
		}
		
	}),
	
	HomeScreen = my.Class({
		
		constructor: function(parent) {
			console.log('Home Screen created');
			Observe(this);
			this._parent = parent;
		},
		
		show: function() {
			return this._parent.show();
		},
		hide: function() {
			return this._parent.hide();
		},
		getElement: function() {
			return this._parent.getElement();
		},
		
		init: function(mute) {
			setTimeout(
				function(){
					document.getElementById('sliderWrapper').style.bottom = 0;
				},
				2000
			);
			
			this.addEventListener('muteButtonClicked', this.muteButtonClicked);
			
			this._muteButton =  document.getElementById('button_volume').getElementsByTagName('img');
			this.updateMuteButton(mute);
		},
		
		muteButtonClicked: function(e, mute) {
			this.updateMuteButton(mute.mute);
		},
		
		updateMuteButton: function(mute) {
			var imgs = this._muteButton;
			if(mute) {
				imgs[0].style.display = "none";
				imgs[1].style.display = "block";
			} else {
				imgs[1].style.display = "none";
				imgs[0].style.display = "block";
			}
		}
		
	}),
	
	HighscoreScreen = my.Class({
		
		constructor: function(parent) {
			console.log('Highscore Screen created');
			Observe(this);
			this._parent = parent;
		},
		
		show: function() {
			return this._parent.show();
		},
		hide: function() {
			return this._parent.hide();
		},
		getElement: function() {
			return this._parent.getElement();
		},
		
		init: function() {
			this.addEventListener('openHighscore', this.openHighscore);
		},
		
		openHighscore: function(e, highscore) {
			var table = document.getElementById('highscoreScreen').getElementsByTagName('tbody')[0]
			header = table.getElementsByTagName('tr')[0].innerHTML,
				fragment = '';

			for(var i = 0, l = highscore.length; i < l; i++ ) {
				var row = '<tr><td>'+(i+1)+'.</td><td>' + highscore[i].wiki + '</td><td>' + highscore[i].date + '</td><td>' + highscore[i].score + '</td></tr>';
				fragment += row;
			}
			
			table.innerHTML = header + fragment;
		}
	}),
	
	ScreenManager = my.Class({
		
		constructor: function(){
			Observe(this);
		},
		
		get: function(id){
			return screens[id] = screens[id] || new Screen(id, this);
		},
		
		getScreenIds: function() {
			var names = [];
			
			for(var id in screens) {
				names.push(id);
			}
			
			return names;
		}
	});
	
	return new ScreenManager();
});