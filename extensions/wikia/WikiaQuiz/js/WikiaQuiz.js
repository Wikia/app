var WikiaQuiz = {
	sets: false,
	state: {answered: false},
	answerFeedbackCorrect: false,
	answerFeedbackWrong: false,
	cq: false, // cq - CurrentQuestion
	cas: false, // cas - CurrentAnswers
	scoreView: false,
	score: 0,	// move this to serverside
	init: function() {
		WikiaQuiz.cq = $('.question-sets .question-set:first-child');
		WikiaQuiz.initializeQuestion(WikiaQuiz.cq);
		Timer.init();
		$('.next-button').live('click', WikiaQuiz.handleNextClick);
		WikiaQuiz.answerFeedbackCorrect = $('.answer-feedback.star');
		WikiaQuiz.answerFeedbackWrong = $('.answer-feedback.wrong');
		WikiaQuiz.scoreView = $('.score-pane .score');
	},
	initializeQuestion: function() {
		WikiaQuiz.cas = WikiaQuiz.cq.find('.choices li');
		WikiaQuiz.cas.click(WikiaQuiz.handleAnswerClick).mouseenter(function(){
			$(this).addClass('hover');
			MultiAudio.play('sound-menu-hover');
		}).mouseleave(function(){
			$(this).removeClass('hover');
		});
	},
	handleAnswerClick: function(evt) {
		if(evt){
			evt.preventDefault();
		}
		if(!WikiaQuiz.state['answered']){
			if($(this).data('correct')) {
				WikiaQuiz.answerFeedbackCorrect.show(0, function(){
					WikiaQuiz.answerFeedbackCorrect.addClass('popup');
					MultiAudio.play('sound-answer-correct');
				});
				$(this).addClass('correct');
				WikiaQuiz.score++;
				WikiaQuiz.updateScore();
			} else {
				WikiaQuiz.answerFeedbackWrong.show(0, function(){
					WikiaQuiz.answerFeedbackWrong.addClass('popup');
					MultiAudio.play('sound-answer-wrong');
				});
				$(this).addClass('wrong');
				WikiaQuiz.cq.find('li[data-correct=1]').addClass('correct');
			}
			WikiaQuiz.state['answered'] = true;
			Timer.stopTimer();
		}
		WikiaQuiz.cas.unbind('mouseenter').unbind('mouseleave').unbind('click');
		$(this).addClass('hover');
		setTimeout(function() {
			WikiaQuiz.cq.find('.next-button').fadeIn();
		}, 1000);
	},
	updateScore: function() {
		WikiaQuiz.scoreView.html(WikiaQuiz.score);
	},
	handleNextClick: function(evt) {
		WikiaQuiz.cq.fadeOut(function() {
			WikiaQuiz.cq = WikiaQuiz.cq.next();
			WikiaQuiz.cq.fadeIn(function() {
				WikiaQuiz.initializeQuestion();
				Timer.startTimer();
			});
		});
		WikiaQuiz.resetFeedback();
	},
	resetFeedback: function() {
		WikiaQuiz.state['answered'] = false;
		WikiaQuiz.answerFeedbackCorrect.removeClass('popup').hide();
		WikiaQuiz.answerFeedbackWrong.removeClass('popup').hide();
	}
};

var Timer = {
	timerHandle: false,
	startTime: false,
	currentTime: false,
	timeLimit: 30,
	clockObj: false,
	init: function() {
		Timer.clockObj = $('.clock');
		Timer.currentTime = Timer.timeLimit;
		Timer.startTimer();
	},
	startTimer: function() {
		Timer.timerHandle = setInterval( Timer.resolveTimer, 1000);
	},
	stopTimer: function() {
		clearInterval(Timer.timerHandle);
	},
	resolveTimer: function() {
		if(Timer.currentTime > -1) {
			Timer.clockObj.html(Timer.convertToReadable());
		}
		if(Timer.currentTime == 0) {
			Timer.stopTimer();
		}
		Timer.currentTime--;
	},
	convertToReadable: function() {
		var m = Math.floor(Timer.currentTime / 60);
		var s = Timer.currentTime % 60;
		return m + ' : ' + (s < 10 ? '0' : '') + s;
	}
};

/* refactored code taken from: http://www.storiesinflight.com/html5/audio.html */
var MultiAudio = {
	channel_max: 10,
	audiochannels: new Array(),
	soundAssets: {},
	init: function(assets) {
		for(var a = 0; a < MultiAudio.channel_max; a++) {
			MultiAudio.audiochannels[a] = {};
			MultiAudio.audiochannels[a]['channel'] = new Audio();
			MultiAudio.audiochannels[a]['finished'] = -1;
		}
		if(assets) {
			MultiAudio.soundAssets = assets;
		}
	},
	play: function(s) {
		for(var a = 0; a < MultiAudio.audiochannels.length; a++) {
			thistime = new Date();
			if(MultiAudio.audiochannels[a]['finished'] < thistime.getTime()) {
				MultiAudio.audiochannels[a]['finished'] = thistime.getTime() + MultiAudio.soundAssets[s].duration*1000;
				MultiAudio.audiochannels[a]['channel'].src = MultiAudio.soundAssets[s].src;
				MultiAudio.audiochannels[a]['channel'].load();
				MultiAudio.audiochannels[a]['channel'].play();
				break;
			}
		}
	}
};

$(function() {
	var assets = {'sound-menu-hover': document.getElementById('sound-menu-hover'),
			'sound-answer-correct': document.getElementById('sound-answer-correct'),
			'sound-answer-wrong': document.getElementById('sound-answer-wrong')};
	MultiAudio.init(assets);
	WikiaQuiz.init();
});