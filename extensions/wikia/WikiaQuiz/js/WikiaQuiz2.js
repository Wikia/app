/*
$('.question-label, .question-bubble').addClass('off-screen')
$('li:nth-child(4) img').css('-webkit-transform', 'matrix(2, 0, 0, 2, -480, -120)');$('li:nth-child(4)').siblings().addClass('wrong');$('.question-bubble').addClass('hide');$('li:nth-child(4) p').addClass('hi
*/

var WikiaQuiz = {
	cq: false,
	imageWidth: 190,
	score: 0,
	startTime: false,
	init: function() {	
		$('.start-button').click(function() {
			$('.title-screen').hide();
			$('.count-down').show();
			WikiaQuiz.countDown();
		});
	},
	countDown: function() {
		var cadenceList = ['SET...', 'GO!'];
		var cadence = $('.count-down .cadence');
		var number = $('.count-down .number');
		var i = 0;
		var iHook = setInterval(function() {
			if(i == 2) {
				clearInterval(iHook);
				$('.count-down').fadeOut(500);
				$('.questions').fadeIn(1000, function() {
					WikiaQuiz.startQuiz();
				});
			} else {
				cadence.html(cadenceList[i]);
				number.html(3 - ++i);
			}
		}, 1000);
	},
	startQuiz: function() {
		WikiaQuiz.startTime = new Date();
		WikiaQuiz.initializeQuestion($('.questions .question-set:first-child'));	
	},
	initializeQuestion: function(cq) {
		WikiaQuiz.cq = cq;
		setTimeout(WikiaQuiz.initializeAnswers, 2000);
	},
	initializeAnswers: function() {
		WikiaQuiz.cq.find('.answers').fadeIn();
		WikiaQuiz.cq.find('.question-bubble').animate({'top':'-60px'});
		WikiaQuiz.cq.find('.question-label').fadeOut();
		setTimeout(function() {
			WikiaQuiz.cq.find('.answer').click(WikiaQuiz.handleAnswerClick);
		}, 1000);
	},
	handleAnswerClick: function() {
		WikiaQuiz.cq.find('.answer').unbind('click');
		var answer = $(this).closest('.answer');
		var i = WikiaQuiz.cq.find('.answer').index(answer);
		var img = answer.find('.answer-pic');
		var translateX = 0 - (i * WikiaQuiz.imageWidth);
		var label = answer.find('p');
		var exp = WikiaQuiz.cq.find('.answer-label, .next-button');
		if(answer.data('correct')) {
			WikiaQuiz.score++;
			console.log('foo');
		}
		exp = exp.add(answer.data('correct') ? WikiaQuiz.cq.find('.answer-explanation.correct') : WikiaQuiz.cq.find('.answer-explanation.wrong'));
		WikiaQuiz.cq.find('.answer-label').html(label.html());
		//img.css('-webkit-transform', 'matrix(2, 0, 0, 2, ' + translateX + ', -120)');
		answer.addClass('correct').siblings().addClass('wrong');
		//img.css('left', translateX + 'px');
		img.animate({
			height: 330,
			width: 330,
			top: -210,
			left: translateX
		});
		WikiaQuiz.cq.find('.question-bubble').addClass('hide');
		label.addClass('hide');
		exp.fadeIn(1000, function() {
			WikiaQuiz.cq.find('.next-button').click(function() {
				var next = WikiaQuiz.cq.next();
				WikiaQuiz.cq.fadeOut(1000, function() {
					if(next && next.length > 0) {
						next.fadeIn(1000, function() {
							WikiaQuiz.initializeQuestion(next);
						});
					} else {
						var now = new Date();
						var diff = now - WikiaQuiz.startTime;
						var ts = diff / 1000;
						var s = Math.floor(ts % 60);
						ts /= 60;
						var m = Math.floor(ts % 60);
						var time = m + ':' + (s < 10 ? '0' : '') + s;
						var qr = $('.quiz-result');
						qr.find('.points div').html(WikiaQuiz.score);
						qr.find('.time div').html(time);
						qr.fadeIn(1000);
					}
				});
			});
		});
	}
	
};

var Timer = {
	p: false, 
	c: false,
	ratio: 1,
	intervalHook: false,
	startTime: false,
	maxTime: 120000,
	r: 50,
	ir: 5,
	init: function() {
		Timer.p = document.getElementById('timer');
		Timer.r = $(Timer.p).height() / 2;
		Timer.ir = Timer.r - 5;
		Timer.c = Timer.p.getContext("2d");
		Timer.drawBackground();
		Timer.drawTimeleft();
		Timer.startTimer();
	},
	drawBackground: function() {
		Timer.c.fillStyle = '#51595c';
		Timer.c.moveTo(Timer.r, Timer.r);
		Timer.c.beginPath();
		Timer.c.arc(Timer.r, Timer.r, Timer.r, 0, Math.PI * 2, false);
		Timer.c.closePath();
		Timer.c.fill();
		Timer.c.fillStyle = '#fa5c20';
		Timer.c.moveTo(Timer.r, Timer.r);
		Timer.c.beginPath();
		Timer.c.arc(Timer.r, Timer.r, Timer.ir, 0, Math.PI * 2, false);
		Timer.c.closePath();
		Timer.c.fill();
	},
	drawTimeleft: function() {
		Timer.c.fillStyle = '#a7a7a7';
		Timer.c.moveTo(Timer.r, Timer.r);
		Timer.c.beginPath();
		Timer.c.lineTo(Timer.r, 0);
		Timer.c.arc(Timer.r, Timer.r, Timer.ir, Math.PI * 1.5, Math.PI * ((2 * Timer.ratio) - 0.5), true);
		Timer.c.lineTo(Timer.r, Timer.r);
		Timer.c.closePath();
		Timer.c.fill();
	},
	startTimer: function() {
		Timer.startTime = (new Date()).getTime();
		Timer.intervalHook = setInterval(Timer.resolveTimer, 40);
	},
	stopTimer: function() {
		clearInterval(Timer.intervalHook);
	},
	resolveTimer: function() {
		Timer.ratio = 1 - (((new Date()).getTime() - Timer.startTime) / Timer.maxTime);
		if(Timer.r > 0) {
			Timer.drawTimeleft();
		} else {
			Timer.stopTimer();
		}
	}
};

$(function() {
	WikiaQuiz.init();
	Timer.init();
});