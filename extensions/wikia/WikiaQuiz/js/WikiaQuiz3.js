var WikiaQuiz = {
	animationTiming: 400,
	ui: {},
	qSet: false,
	imgLargeSize: '245px',
	score: 0,
	init: function() {
		jQuery.fx.interval = 13; // 16 is roughly 60 fps, 32 is roughly 30 fps
		WikiaQuiz.qSet = $('#WikiaQuiz .questions .question-set');
		WikiaQuiz.cqNum = 0;
		WikiaQuiz.totalQ = WikiaQuiz.qSet.length;
		WikiaQuiz.ui.titleScreen = $('#WikiaQuiz .title-screen');
		WikiaQuiz.ui.countDown = $('#CountDown');
		WikiaQuiz.ui.countDownNumber = $('#CountDown .number');
		WikiaQuiz.ui.countDownCadence = $('#CountDown .cadence');
		WikiaQuiz.ui.startButton = $('#StartButton');
		WikiaQuiz.ui.endScreen = $('#WikiaQuiz .quiz-end');
		WikiaQuiz.ui.thanksScreen = $('#WikiaQuiz .quiz-thanks');
		WikiaQuiz.ui.progressBar = $('#ProgressBar');
		WikiaQuiz.ui.progressBarIndicators = $('#ProgressBar .indicator');
		
		// events
		WikiaQuiz.ui.startButton.click(WikiaQuiz.handleStart);
	},
	handleStart: function() {
		WikiaQuiz.ui.startButton.hide();
		WikiaQuiz.ui.progressBar.show();
		WikiaQuiz.countDown();
	},
	countDown: function() {
		WikiaQuiz.ui.titleScreen.hide();
		WikiaQuiz.ui.countDown.show();
		var i = 0;
		var iHook = setInterval(function() {
			if(i == 2) {
				clearInterval(iHook);
				WikiaQuiz.ui.countDown.fadeOut(WikiaQuiz.animationTiming, function() {
					WikiaQuiz.initializeQuestion(WikiaQuiz.qSet.eq(WikiaQuiz.cqNum));
				});
			} else {
				WikiaQuiz.ui.countDownNumber.html(3 - ++i);
				WikiaQuiz.ui.countDownCadence.html(WikiaQuizVars.cadence[i]);
			}
		}, 1000);
		//WikiaQuiz.initializeQuestion(WikiaQuiz.qSet.eq(WikiaQuiz.cqNum));
	},
	initializeQuestion: function(cq) {
		WikiaQuiz.cq = cq;
		WikiaQuiz.ui.questionLabel = cq.find('.question-label, .question-image');
		WikiaQuiz.ui.questionBubble = cq.find('.question-bubble');
		WikiaQuiz.ui.answers = cq.find('.answers');
		WikiaQuiz.ui.allAnswers = cq.find('.answer');
		WikiaQuiz.ui.allRepresentations = cq.find('.representation');
		WikiaQuiz.ui.allAnswerLabels = cq.find('.answer-label');
		WikiaQuiz.ui.correctAnswer = cq.find('.answer[data-correct=1]');
		WikiaQuiz.ui.correctAnswerLabel = WikiaQuiz.ui.correctAnswer.find('.answer-label').data('label');
		WikiaQuiz.ui.explanation = cq.find('.explanation');
		WikiaQuiz.ui.answerResponse = WikiaQuiz.ui.explanation.find('.answer-response');
		WikiaQuiz.ui.nextButton = WikiaQuiz.ui.explanation.find('button');
		WikiaQuiz.answered = false;
		WikiaQuiz.ui.progressBarIndicators.eq(WikiaQuiz.cqNum).addClass('on');
		WikiaQuiz.cq.fadeIn(WikiaQuiz.animationTiming, function() {
			setTimeout(WikiaQuiz.showAnswers, 2000);
		});
	},
	unbindAll: function() {
		WikiaQuiz.ui.answers.unbind('click');
		WikiaQuiz.ui.nextButton.unbind('click');
	},
	showAnswers: function() {
		WikiaQuiz.ui.questionLabel.fadeOut(WikiaQuiz.animationTiming);
		WikiaQuiz.ui.questionBubble.animate({bottom:'360px'}, WikiaQuiz.animationTiming, function() {
			WikiaQuiz.ui.answers.bind('click', WikiaQuiz.handleAnswerClick);
		});
		WikiaQuiz.ui.answers.fadeIn(WikiaQuiz.animationTiming);
	},
	handleAnswerClick: function(evt) {
		if(WikiaQuiz.answered) {
			return;
		}
		WikiaQuiz.answered = true;
		$().log('Answer Clicked')
		$().log(evt);
		var target = $(evt.target);
		var answer = target.closest('.answer');
		/*
		var srcElement = $(evt.srcElement);
		var answer = $(evt.srcElement).closest('.answer');
		*/
		if(target.attr('class') != 'anchor-hack' && answer.length) {
			$().log('found:');
			$().log(answer);
			WikiaQuiz.ui.chosenAnswer = answer;
			if(answer.data('correct') == '1') {
				WikiaQuiz.score++;
				WikiaQuiz.ui.answerResponse.text(WikiaQuizVars.correctLabel);
			} else {
				WikiaQuiz.ui.answerResponse.text(WikiaQuizVars.incorrectLabel);
			}
			WikiaQuiz.showSelection(answer);
		}
		
	},
	showSelection: function(answer) {
		var r = answer.find('.representation');
		if(r.length) {
			var e = WikiaQuiz.ui.allRepresentations.not(r).add(WikiaQuiz.ui.allAnswerLabels).add(WikiaQuiz.ui.questionBubble);
			
			var i = WikiaQuiz.ui.allAnswers.index(answer);
			var left = (20 - (i * 190));
			$().log(left);
			r.animate({
				height:WikiaQuiz.imgLargeSize,
				width:WikiaQuiz.imgLargeSize,
				left: left,
				top: -135
				}, WikiaQuiz.animationTiming);
			e.fadeOut(WikiaQuiz.animationTiming);
			WikiaQuiz.ui.explanation.fadeIn(WikiaQuiz.animationTiming, function() {
				WikiaQuiz.ui.nextButton.bind('click', WikiaQuiz.handleNextClick);
			});
		}
	},
	handleNextClick: function(evt) {
		$().log('Next Clicked');
		WikiaQuiz.transition();
	},
	transition: function() {
		WikiaQuiz.unbindAll();
		WikiaQuiz.cq.fadeOut(WikiaQuiz.animationTiming, function() {
			WikiaQuiz.cqNum++;
			if(WikiaQuiz.cqNum < WikiaQuiz.totalQ) {
				WikiaQuiz.initializeQuestion(WikiaQuiz.qSet.eq(WikiaQuiz.cqNum));
			} else {
				WikiaQuiz.showEnd();
			}
		});
	},
	showEnd: function() {
		var score = (WikiaQuiz.score / WikiaQuiz.totalQ) * 100;
		var scoreUI = $("#FinalScore");
		scoreUI.text(score);
		if(score == 100) {
			scoreUI.addClass('full');
		}
		WikiaQuiz.ui.progressBar.fadeOut(WikiaQuiz.animationTiming);
		WikiaQuiz.ui.endScreen.fadeIn(WikiaQuiz.animationTiming, function() {
			WikiaQuiz.ui.endScreen.find('.continue').click(function() {
				WikiaQuiz.ui.endScreen.fadeOut(WikiaQuiz.animationTiming, function() {
					WikiaQuiz.ui.thanksScreen.fadeIn(WikiaQuiz.animationTiming);
				});
			});
		});
	}
};

window.onload = function() {
	WikiaQuiz.init();
};