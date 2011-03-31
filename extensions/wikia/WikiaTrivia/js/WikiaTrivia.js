var WikiaTrivia = {
	sets: false,
	state: {answered: false},
	answerFeedbackCorrect: false,
	answerFeedbackWrong: false,
	cq: false, // cq - CurrentQuestion
	scorePane: false,
	score: 0,	// move this to serverside
	init: function() {
		$('.choices li').click(WikiaTrivia.handleAnswerClick).mouseenter(function(){
			$(this).addClass('hover');
			MultiAudio.play('sound-menu-hover');
		}).mouseleave(function(){
			$(this).removeClass('hover');
		});
		Timer.init();
		$('.next-question').live('click', WikiaTrivia.handleNextClick);
		WikiaTrivia.answerFeedbackCorrect = $('.answer-feedback.star');
		WikiaTrivia.answerFeedbackWrong = $('.answer-feedback.wrong');
		WikiaTrivia.score = $('.score-pane .score');
	},
	handleAnswerClick: function(evt) {
		if(evt){
			evt.preventDefault();
		}
		if(!WikiaTrivia.state['answered']){
			if($(this).is(':contains("lol")')) {
				WikiaTrivia.answerFeedbackCorrect.show(0, function(){
					WikiaTrivia.answerFeedbackCorrect.addClass('popup');
					MultiAudio.play('sound-answer-correct');
				});
				$(this).addClass('correct');
			} else {
				WikiaTrivia.answerFeedbackWrong.show(0, function(){
					WikiaTrivia.answerFeedbackWrong.addClass('popup');
					MultiAudio.play('sound-answer-wrong');
				});
				$(this).addClass('wrong');
				$('.choices li:nth-child(4)').addClass('correct');
			}
			WikiaTrivia.state['answered'] = true;
			Timer.stopTimer();
		}
		$('.choices li').unbind('mouseenter').unbind('mouseleave');
		$(this).addClass('hover');
	},
	updateScore: function() {
		WikiaTrivia.scorePane.html(WikiaTrivia.score);
	},
	handleNextClick: function(evt) {

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
	WikiaTrivia.init();
});