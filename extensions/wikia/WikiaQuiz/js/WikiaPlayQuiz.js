var WikiaQuiz = {
	animationTiming: 400,
	ui: {},
	sound: {},
	isMuted: false,
	qSet: false,
	imgLargeSize: '245px',
	imgScaleFactor: '+=90',
	score: 0,
	vars: {},
	init: function() {
		// class vars
		WikiaQuiz.trackerLabelPrefix = window.wgDBname + '/' + window.wgTitle.replace(/\//g, '_') + '/';

		//tracking
		WikiaQuiz.trackEvent('impression', 'titlecard');

		//DOM
		jQuery.fx.interval = 13; // 16 is roughly 60 fps, 32 is roughly 30 fps
		WikiaQuiz.qSet = $('#WikiaQuiz .questions .question-set');
		WikiaQuiz.cqNum = 0;
		WikiaQuiz.totalQ = WikiaQuiz.qSet.length;
		WikiaQuiz.ui.titleScreen = $('#WikiaQuiz > .title-screen');
		WikiaQuiz.ui.countDown = $('#CountDown');
		WikiaQuiz.ui.countDownNumber = $('#CountDown .number');
		WikiaQuiz.ui.countDownCadence = $('#CountDown .cadence');
		WikiaQuiz.ui.startButton = $('#StartButton');
		WikiaQuiz.ui.questions = $('#Questions');
		WikiaQuiz.ui.endScreen = $('#WikiaQuiz > .quiz-end');
		WikiaQuiz.ui.emailScreen = $('#WikiaQuiz > .quiz-email');
		WikiaQuiz.ui.thanksScreen = $('#WikiaQuiz > .quiz-thanks');
		WikiaQuiz.ui.progressBar = $('#ProgressBar');
		WikiaQuiz.ui.progressBarIndicators = $('#ProgressBar .indicator');
		WikiaQuiz.ui.correctIcon = $('#CorrectIcon');
		WikiaQuiz.ui.wrongIcon = $('#WrongIcon');
		WikiaQuiz.ui.muteToggle = $('#MuteToggle');
		WikiaQuiz.sound.correct = document.getElementById('SoundAnswerCorrect');
		WikiaQuiz.sound.wrong = document.getElementById('SoundAnswerWrong');
		WikiaQuiz.sound.applause = document.getElementById('SoundApplause');
		WikiaQuiz.audio = (typeof Modernizr != 'undefined' && Modernizr.audio);
		WikiaQuiz.vars = window.WikiaQuizVars;

		var sound,
			playCallback = function() {};

		for(sound in WikiaQuiz.sound) {
			if(WikiaQuiz.audio) {
				WikiaQuiz.sound[sound].load();
			} else {
				WikiaQuiz.sound[sound].play = playCallback;
			}
		}

		// events
		WikiaQuiz.ui.startButton.click(WikiaQuiz.handleStart);
		WikiaQuiz.ui.muteToggle.click(WikiaQuiz.toggleSound);

		WikiaQuiz.ui.thanksScreen.add(WikiaQuiz.ui.emailScreen).find('.more-info').click(function(e) {
			$().log('more info');
			WikiaQuiz.trackEvent('click-link-text', 'moreinfo', -1, $(e.target).attr('href'), e );
		});

		$.loadFacebookSDK();

		$().log('init', 'WikiaQuiz');
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
				WikiaQuiz.initializeQuestion(WikiaQuiz.qSet.eq(WikiaQuiz.cqNum));
				WikiaQuiz.showQuiz();
			} else {
				WikiaQuiz.ui.countDownNumber.html(3 - ++i);
				WikiaQuiz.ui.countDownCadence.html(WikiaQuiz.vars.cadence[i]);
			}
		}, 1000);
	},
	showQuiz: function() {
		WikiaQuiz.ui.questions.animate({left:"-="+$('#WikiaQuiz').css('width')}, WikiaQuiz.animationTiming + 200);
		WikiaQuiz.ui.countDown.animate({left:"-=840px"}, WikiaQuiz.animationTiming + 200);
	},
	initializeQuestion: function(cq) {
		WikiaQuiz.trackEvent('impression', 'question' + (WikiaQuiz.cqNum + 1));
		WikiaQuiz.cq = cq;
		WikiaQuiz.ui.questionLabel = cq.find('.question-label, .question-image');
		WikiaQuiz.ui.questionBubble = cq.find('.question-bubble');
		WikiaQuiz.ui.answers = cq.find('.answers');
		WikiaQuiz.ui.video = cq.find('.video');
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
		WikiaQuiz.ui.questionBubble.animate({bottom:'440px'}, WikiaQuiz.animationTiming, function() {
			WikiaQuiz.ui.answers.bind('click', WikiaQuiz.handleAnswerClick);
		});
		WikiaQuiz.ui.answers.add(WikiaQuiz.ui.video).fadeIn(WikiaQuiz.animationTiming);
	},
	handleAnswerClick: function(evt) {
		if(WikiaQuiz.answered) {
			return;
		}
		WikiaQuiz.answered = true;
		var target = $(evt.target);
		var targetClass = target.attr('class');
		var answer = target.closest('.answer');
		if(targetClass != 'anchor-hack' && answer.length) {
			answer.unbind();
			answer.addClass('selected');
			WikiaQuiz.ui.chosenAnswer = answer;
			if(answer.data('correct') == '1') {
				WikiaQuiz.correct = true;
				WikiaQuiz.score++;
				WikiaQuiz.ui.answerResponse.text(WikiaQuiz.vars.correctLabel);
			} else {
				WikiaQuiz.correct = false;
				WikiaQuiz.ui.answerResponse.text(WikiaQuiz.vars.incorrectLabel);
			}
			WikiaQuiz.trackEvent('impression', 'answer' + (WikiaQuiz.cqNum + 1));

			WikiaQuiz.showSelection(answer);
		}

	},
	showSelection: function(answer) {
		var r = answer.find('.representation');
		if(r.length) {
			var elementsToHide = WikiaQuiz.ui.allRepresentations.not(r).add(WikiaQuiz.ui.allAnswerLabels).add(WikiaQuiz.ui.questionBubble).add(WikiaQuiz.ui.video);

			var i = WikiaQuiz.ui.allAnswers.index(answer);
			var left = (20 - (i * 190));

			if (WikiaQuiz.cq.hasClass('video')) {
				// skip animation
				r.fadeOut(WikiaQuiz.animationTiming);
				WikiaQuiz.showAnswer();
			} else {
				// do animation
				r.animate({
						height:WikiaQuiz.imgScaleFactor,
						width:WikiaQuiz.imgScaleFactor,
						left: left,
						top: -135
					},
					WikiaQuiz.animationTiming,
					WikiaQuiz.showAnswer
				);
			}
			elementsToHide.fadeOut(WikiaQuiz.animationTiming);
			//WikiaQuiz.ui.explanation.fadeIn(WikiaQuiz.animationTiming);
		}
	},

	showAnswer: function() {
		if(WikiaQuiz.correct) {
			WikiaQuiz.ui.answerIndicator = WikiaQuiz.ui.correctIcon;
			WikiaQuiz.sound.answerIndicator = WikiaQuiz.sound.correct;
		} else {
			WikiaQuiz.ui.answerIndicator = WikiaQuiz.ui.wrongIcon;
			WikiaQuiz.sound.answerIndicator = WikiaQuiz.sound.wrong;
		}

		WikiaQuiz.ui.nextButton.bind('click', WikiaQuiz.handleNextClick);

		var css = (WikiaQuiz.cq.hasClass('video')) ? {top: 50, left: 120} : {top: 25, left: 25};
		WikiaQuiz.ui.answerIndicator.css(css).removeClass('effect');

		setTimeout(function() {
			WikiaQuiz.playSound(WikiaQuiz.sound.answerIndicator);
		}, 100);
		WikiaQuiz.ui.explanation.fadeIn(WikiaQuiz.animationTiming);
	},

	handleNextClick: function(evt) {
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
	// show screen with user's score
	showEnd: function() {
		WikiaQuiz.trackEvent('impression', 'scorecard', WikiaQuiz.score);
		var score = Math.floor((WikiaQuiz.score / WikiaQuiz.totalQ) * 100);
		var scoreUI = $("#FinalScore");
		scoreUI.find('.number').text(score);
		if(score == 100) {
			scoreUI.addClass('full');
		}
		WikiaQuiz.ui.progressBar.fadeOut(WikiaQuiz.animationTiming);
		WikiaQuiz.ui.endScreen.fadeIn(WikiaQuiz.animationTiming, function() {
			WikiaQuiz.playSound(WikiaQuiz.sound.applause);
			// proceed to email screen when "Continue" is clicked
			WikiaQuiz.ui.endScreen.find('.continue').click(function() {
				if (window.WikiaQuizEmailRequired) {
					WikiaQuiz.showEmail();
				} else {
					WikiaQuiz.showThanks();
				}
			});
		});
	},
	// show screen with email field
	showEmail: function() {
		WikiaQuiz.trackEvent('impression', 'emailcard');
		WikiaQuiz.ui.endScreen.fadeOut(WikiaQuiz.animationTiming);
		WikiaQuiz.ui.emailScreen.fadeIn(WikiaQuiz.animationTiming, function() {
			// submit an email and proceed to thank you screen
			var emailForm =  WikiaQuiz.ui.emailScreen.find('form'),
				submitButton = emailForm.children('input[type="submit"]');

			emailForm.bind('submit', function(ev) {
				ev.preventDefault();
				submitButton.attr('disabled', true);

				$.post(wgScript, {
					action: 'ajax',
					rs: 'WikiaQuizAjax',
					method: 'addEmail',
					email: emailForm.children('input[name="email"]').val(),
					token: emailForm.children('input[name="token"]').val(),
					quizid: emailForm.children('input[name="quizid"]').val()
				}, function(data) {
					submitButton.attr('disabled', false);

					if (data.ok) {
						WikiaQuiz.showThanks();
					}
					else {
						alert(data.msg);
					}
				}, 'json');
			});
		});
	},

	// show thank you screen (the last one)
	showThanks: function() {
		WikiaQuiz.trackEvent('impression', 'marketingcard');

		(window.WikiaQuizEmailRequired ? WikiaQuiz.ui.emailScreen : WikiaQuiz.ui.endScreen).fadeOut(WikiaQuiz.animationTiming, function() {
			WikiaQuiz.ui.thanksScreen.fadeIn(WikiaQuiz.animationTiming);
		});
	},
	playSound: function(soundElement) {
		if(WikiaQuiz.audio && !WikiaQuiz.isMuted) {
			soundElement.load();
			soundElement.play();
		}
	},
	toggleSound: function() {
		WikiaQuiz.isMuted = $(this).find('input').attr('checked');
	},
	trackEvent: function(action, label, value, href, event) {
		var params = {
			action: action,
			browserEvent: event,
			category: 'wikia-quiz',
			href: href,
			label: WikiaQuiz.trackerLabelPrefix + label,
			trackingMethod: 'analytics'
		};
		if ( value > -1 ) {
			params.value = value;
		}
		if ( href ) {
			params.href = href;
		}
		Wikia.Tracker.track(params);
	}
};

$(function() {
	WikiaQuiz.init();
});
