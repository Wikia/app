var WikiaQuiz = {
	animationTiming: 400,
	ui: {},
	sound: {},
	isMuted: false,
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
		WikiaQuiz.ui.questions = $('#Questions');
		WikiaQuiz.ui.endScreen = $('#WikiaQuiz .quiz-end');
		WikiaQuiz.ui.thanksScreen = $('#WikiaQuiz .quiz-thanks');
		WikiaQuiz.ui.progressBar = $('#ProgressBar');
		WikiaQuiz.ui.progressBarIndicators = $('#ProgressBar .indicator');
		WikiaQuiz.ui.correctIcon = $('#CorrectIcon');
		WikiaQuiz.ui.wrongIcon = $('#WrongIcon');
		WikiaQuiz.ui.muteToggle = $('#MuteToggle');
		WikiaQuiz.sound.correct = document.getElementById('SoundAnswerCorrect');
		WikiaQuiz.sound.wrong = document.getElementById('SoundAnswerWrong');
		WikiaQuiz.sound.applause = document.getElementById('SoundApplause');
		WikiaQuiz.audio = (typeof Modernizr != 'undefined' && Modernizr.audio);
		for(sound in WikiaQuiz.sound) {
			if(WikiaQuiz.audio) {
				WikiaQuiz.sound[sound].load();
			} else {
				WikiaQuiz.sound[sound].play = function() {};	//empty function
			}
		}
		
		// events
		WikiaQuiz.ui.startButton.click(WikiaQuiz.handleStart);
		WikiaQuiz.ui.muteToggle.click(WikiaQuiz.toggleSound);
	},
	handleStart: function() {
		$.tracker.byStr('wikiaquiz/start');
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
				WikiaQuiz.initializeQuestion(WikiaQuiz.qSet.eq(WikiaQuiz.cqNum));
				WikiaQuiz.showQuiz();
			} else {
				WikiaQuiz.ui.countDownNumber.html(3 - ++i);
				WikiaQuiz.ui.countDownCadence.html(WikiaQuizVars.cadence[i]);
			}
		}, 1000);
	},
	showQuiz: function() {
		WikiaQuiz.ui.questions.add(WikiaQuiz.ui.countDown).animate({left:"-=800px"}, WikiaQuiz.animationTiming + 200);
	},
	initializeQuestion: function(cq) {
		$.tracker.byStr('wikiaquiz/view/q'+WikiaQuiz.cqNum);
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
			answer.addClass('selected');
			WikiaQuiz.ui.chosenAnswer = answer;
			if(answer.data('correct') == '1') {
				$.tracker.byStr('wikiaquiz/correct/q'+WikiaQuiz.cqNum);
				WikiaQuiz.correct = true;
				WikiaQuiz.score++;
				WikiaQuiz.ui.answerResponse.text(WikiaQuizVars.correctLabel);
			} else {
				$.tracker.byStr('wikiaquiz/wrong/q'+WikiaQuiz.cqNum);
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
						WikiaQuiz.playSound(WikiaQuiz.sound.answerIndicator);
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
		$.tracker.byStr('wikiaquiz/finalscore/'+WikiaQuiz.score);
		var score = (WikiaQuiz.score / WikiaQuiz.totalQ) * 100;
		var scoreUI = $("#FinalScore");
		scoreUI.find('.number').text(score);
		if(score == 100) {
			scoreUI.addClass('full');
		}
		WikiaQuiz.ui.progressBar.fadeOut(WikiaQuiz.animationTiming);
		WikiaQuiz.ui.endScreen.fadeIn(WikiaQuiz.animationTiming, function() {
			WikiaQuiz.playSound(WikiaQuiz.sound.applause);
			WikiaQuiz.ui.endScreen.find('.continue').click(function() {
				$.tracker.byStr('wikiaquiz/endscreen');
				WikiaQuiz.ui.endScreen.fadeOut(WikiaQuiz.animationTiming, function() {
					WikiaQuiz.ui.thanksScreen.fadeIn(WikiaQuiz.animationTiming, function() {
						WikiaQuiz.ui.thanksScreen.find('.more-info').click(function() {
							$.tracker.byStr('wikiaquiz/moreinfo');
						});
					});
				});
			});
		});
	},
	playSound: function(soundElement) {
		if(WikiaQuiz.audio && !WikiaQuiz.isMuted) {
			soundElement.load();
			soundElement.play();
		}
	},
	toggleSound: function() {
		$().log('Mute Toggle Clicked');
		WikiaQuiz.isMuted = $(this).find('input').attr('checked');
		$.tracker.byStr('wikiaquiz/mute/'+WikiaQuiz.isMuted);
	}
};

window.onload = function() {
	WikiaQuiz.init();
};