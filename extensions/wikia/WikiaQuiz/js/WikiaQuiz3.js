var WikiaQuiz = {
	animationTiming: 400,
	ui: {},
	sound: {},
	qSet: false,
	imgLargeSize: '245px',
	imgScaleFactor: '+=90',
	score: 0,
	init: function() {
		//DOM
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
		WikiaQuiz.ui.correctIcon = $('#CorrectIcon');
		WikiaQuiz.ui.wrongIcon = $('#WrongIcon');
		WikiaQuiz.sound.correct = document.getElementById('SoundAnswerCorrect');
		WikiaQuiz.sound.wrong = document.getElementById('SoundAnswerWrong');
		WikiaQuiz.sound.applause = document.getElementById('SoundApplause');
		
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
		WikiaQuiz.ui.allAnswers.hover(function() {
				$(this).addClass('hover');
			}, function() {
				$(this).removeClass('hover');
			});
		WikiaQuiz.cq.fadeIn(WikiaQuiz.animationTiming, function() {
			setTimeout(WikiaQuiz.showAnswers, 2000);
		});
	},
	unbindAll: function() {
		WikiaQuiz.ui.answers.unbind('click');
		WikiaQuiz.ui.allAnswers.unbind('hover');
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
		var targetClass = target.attr('class');
		var answer = target.closest('.answer');
		if(targetClass != 'anchor-hack' && answer.length) {
			$().log('found:');
			$().log(answer);
			answer.unbind();
			WikiaQuiz.ui.chosenAnswer = answer;
			if(answer.data('correct') == '1') {
				WikiaQuiz.correct = true;
				WikiaQuiz.score++;
				WikiaQuiz.ui.answerResponse.text(WikiaQuizVars.correctLabel);
			} else {
				WikiaQuiz.correct = false;
				WikiaQuiz.ui.answerResponse.text(WikiaQuizVars.incorrectLabel);
			}
			
			WikiaQuiz.showSelection(answer);
		}
		
	},
	showSelection: function(answer) {
		var r = answer.find('.representation');
		if(r.length) {
			var elementsToHide = WikiaQuiz.ui.allRepresentations.not(r).add(WikiaQuiz.ui.allAnswerLabels).add(WikiaQuiz.ui.questionBubble);
			
			var i = WikiaQuiz.ui.allAnswers.index(answer);
			var left = (20 - (i * 190));
			$().log(left);
			r.animate({
				height:WikiaQuiz.imgScaleFactor,
				width:WikiaQuiz.imgScaleFactor,
				left: left,
				top: -135
				}, WikiaQuiz.animationTiming, function() {
					if(WikiaQuiz.correct) {
						WikiaQuiz.ui.answerIndicator = WikiaQuiz.ui.correctIcon;
						WikiaQuiz.sound.answerIndicator = WikiaQuiz.sound.correct;
					} else {
						WikiaQuiz.ui.answerIndicator = WikiaQuiz.ui.wrongIcon;
						WikiaQuiz.sound.answerIndicator = WikiaQuiz.sound.wrong;
					}
					
					WikiaQuiz.ui.nextButton.bind('click', WikiaQuiz.handleNextClick);
					WikiaQuiz.ui.answerIndicator.removeClass('effect');
					setTimeout(function() {
						WikiaQuiz.sound.answerIndicator.play();
					}, 100);
					WikiaQuiz.ui.explanation.fadeIn(WikiaQuiz.animationTiming);
				});
			elementsToHide.fadeOut(WikiaQuiz.animationTiming);
			//WikiaQuiz.ui.explanation.fadeIn(WikiaQuiz.animationTiming);
		}
	},
	handleNextClick: function(evt) {
		$().log('Next Clicked');
		WikiaQuiz.transition();
	},
	transition: function() {
		WikiaQuiz.unbindAll();
		WikiaQuiz.ui.answerIndicator.addClass('effect');
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
			WikiaQuiz.sound.applause.play();
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